<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe;
use \Cartalyst\Stripe\Exception\CardErrorException;
use \Cartalyst\Stripe\Exception\BadRequestException;
use \Cartalyst\Stripe\Exception\InvalidRequestException;
use \Cartalyst\Stripe\Exception\NotFoundException;
use \Cartalyst\Stripe\Exception\ServerErrorException;

use Cart;
use App\User;
use App\Service;
use App\ServiceVariant;
use App\Order;
use App\Invoice;
use App\InvoiceBilling;
use App\InvoiceItem;
use App\OrderMessage;




class ClientDashboardController extends Controller
{
    
	// return client service page
    public function getServicesPage()
    {
    	$services = Service::where('display', 1)->latest()->paginate(8);
    	return view('dashboard.services', compact('services'));
    }

    // return service detials page with service info
    public function getServiceDetails($slug)
    {
    	$service = Service::where('slug', $slug)->firstOrFail();

    	$serviceVariants = ServiceVariant::where('service_id', $service->id)->get(['variant_name', 'variant_value'])->groupBy('variant_name');

    	return view('dashboard.service_details', compact('service', 'serviceVariants'));
    }

    // cart index pge
    public function cartPage()
    {
    	return view('dashboard.cart');
    }

    // store services into cart
    public function storeIntoCart(Request $request)
    {
    	$request->validate([

            'serviceName' => 'required|max:255'

        ]);

    	$service = Service::where('slug', $request->serviceName)->firstOrFail();

       	Cart::add($service->id, $service->name,  1, $service->price)->associate('App\Service');
       
        return redirect()->route('services')->with('cartInfo', 'Service adedd to cart!');
    }


    // remove service from cart
    public function removeFromCart($id)
    {
    	Cart::remove($id);
        return redirect()->route('cart.index')->with('success', 'Service has been removed from cart ');
    }



    // return checkout page
    public function getCheckoutPage()
    {
    	
    	if(Cart::count() <= 0)
    	{
    		return redirect()->route('cart.index')->with('error', "Please add services on your cart first ");
    	}
    	return view('dashboard.checkout');
    }

    // preform checkout and return user to thank you page
    public function performCheckout(Request $request)
    {
    	

    	$request->validate([

            'cardHolderName' => 'required|string|max:255',
            'cardHolderEmail' => 'required|email|max:255'
        ]);


        // get cart content for stripe
        $contents = Cart::content()->map(function ($item){
            return $item->model->name .', '. $item->qty;
        })->values()->toJson();

    	try 
    	{  
            // stripe charge from client cart
			$charge = Stripe::charges()->create([
			    
			    'amount'   => Cart::total(),
			    'currency' => 'USD',
                'source' => $request->stripeToken,
			    'description' => 'SEO dashboard order charge',
                'receipt_email' => $request->cardHolderEmail,
                'metadata' => [

                    'contents' => $contents,
                    'quantity' => Cart::instance('default')->count()

                ]
			    
			]);

            


            // unique order number
            $orderNumber = strtoupper(uniqid('CODE'));

            // insert row for every ervery service
            $i = 1;
            foreach(Cart::content() as $key => $item)
            {
                $order = Order::create([
                    'user_id' => auth()->user()->id,
                    'service_id' => $item->model->id,
                    'team_member_id' => null,
                    'order_number' => $orderNumber.'_'.$i,
                    'order_note' => 'Write your order note',
                    'quantity' => $item->qty,
                    'order_status' => 'submitted',
                    'payment_staus' => 'By Card',
                ]);
                $i++;
            }


            // generate invoice for the order
            $invoice = Invoice::create([

                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'invoice_number' => $orderNumber,
                'invoice_total' => Cart::total(),
                'invoice_discount' => 0.0,
                'invoice_vat' => Cart::tax(),
                'invoice_status' => 'complete',
                'payment_method' => 'checkout',
                'payment_getway' => 'stripe'

            ]);

            
            // insert billing information 
            $invoiceBilling = InvoiceBilling::create([

                'invoice_id' => $invoice->id,
                'first_name' => $request->cardHolderName,
                'email' => $request->cardHolderEmail
            ]);



            // insert row for each billing item
            foreach(Cart::content() as $key => $item)
            {
                $invoiceItem = InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'service_id' => $item->model->id,
                    'quantity' => $item->qty
                ]);
            }


            // payment successfull and destroy user cart
            Cart::instance('default')->destroy();


            // return user to the next step
            return redirect()->route('checkout.confirmation')->with('success', 'Order has been placed successfully');
    	}



    	catch (CardErrorException  $e) 
        {
    		return redirect()->back()->with('error', $e->getMessage());
    	}

        catch (BadRequestException $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }

        catch (InvalidRequestException $e) 
        {
            return redirect()->back()->with('error', $e->getMessage());
        }

        catch (NotFoundException $e) 
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
        catch (ServerErrorException $e) 
        {
            return redirect()->back()->with('error', $e->getMessage());
        }


    }

    // return checkout confirmation page
    public function getConfirmationPage()
    {
    	return view('dashboard.confirmation');
    }




    // return order communation page
    public function getOrdersPage()
    {

        $orders = Order::where('user_id', auth()->user()->id)->get();
        return view('dashboard.orders', compact('orders'));
    }


    // return order communation page
    public function getOrderpage($number)
    {

    	$order = Order::where('order_number', $number)->firstOrFail();
        return view('dashboard.order_single', compact('order'));
    }




    //return invoice page
    public function getInvoicePage()
    {

        return view('dashboard.invoices');
    }


}
