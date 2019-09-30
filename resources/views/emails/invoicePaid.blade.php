@extends('layouts.email')

@section('mail-contetnt')
<table role="presentation" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <p>Hey, <strong>{{ ucfirst($user->name) }}</strong>,</p>
        <p>You received a payment for invoice #{{ $invoice->invoice_number }}.</p>
      </td>
    </tr>
  </table>
  <br><br>

  @php
   $invoice = \App\invoice::where('invoice_number', $invoice->invoice_number)->firstOrFail();
   $invoice_item = \App\InvoiceItem::where('invoice_id', $invoice->id)->get();
  @endphp
  <div class="align-center mt-4 mb-3">
     <h2 style="margin-bottom: 0px;">Receipt</h2>
     <p>Payment reference #{{ $invoice->invoice_number }}</p>
  </div>
  <table cellpadding="5" cellspacing="0" style="margin:0;box-sizing:border-box;vertical-align:top;width:100%">
     <tbody>
        @foreach($invoice_item as $item)      
        <tr>
           <td align="left" style="border-top:1px dashed #ddd">{{ $item->invoiceService->name }}</td>
           <td style="text-align:right;border-top:1px dashed #ddd">
            @if($item->discount)
              <strike>${{ $item->invoiceService->price }}</strike><br>
              ${{ $item->invoiceService->price - $item->discount }}
            @else
              ${{ $item->invoiceService->price }}
            @endif
           </td>
           <td style="vertical-align:top;text-align:right;border-top:1px dashed #ddd">x {{ $item->quantity }}</td>
           <td style="text-align:right;border-top:1px dashed #ddd">
            @if($item->discount)
              ${{ ($item->invoiceService->price - $item->discount) * $item->quantity }}
            @else
              ${{ $item->invoiceService->price }}
            @endif
           </td>
        </tr>
        @endforeach
     </tbody>
     <tfoot>
        <tr>
           <td style="text-align:left;border-top:1px dashed #ddd;padding-top:10px">&nbsp;</td>
           <td style="text-align:right;border-top:1px dashed #ddd;padding-top:10px">&nbsp;</td>
           <th style="text-align:right;border-top:1px dashed #ddd;padding-top:10px">Total</th>
           <th style="text-align:right;border-top:1px dashed #ddd;padding-top:10px">${{ $invoice->invoice_total }}</th>
        </tr>
     </tfoot>
  </table>

  <br><br>
  
  <h2 style="margin-bottom: 2px">Billing Details</h2>
  <div class="billing-address">
    @if($invoice->invoiceBill->first_name)
    <p style="margin-bottom: 3px">Name: {{ $invoice->invoiceBill->first_name }} {{ $invoice->invoiceBill->last_name ? $invoice->invoiceBill->last_name : ''}}</p>
    @endif
    @if($invoice->invoiceBill->email)
    <p style="margin-bottom: 3px">Email: {{ $invoice->invoiceBill->email }}</p>
    @endif
    @if($invoice->invoiceBill->phone)
    <p style="margin-bottom: 3px">Phone: {{ $invoice->invoiceBill->phone }}</p>
    @endif
    @if($invoice->invoiceBill->address)
    <p style="margin-bottom: 3px">Address: {{ $invoice->invoiceBill->address }}</p>
    @endif
    @if($invoice->invoiceBill->country)
    <p style="margin-bottom: 3px">Country: {{ $invoice->invoiceBill->country }}</p>
    @endif
    @if($invoice->invoiceBill->city)
    <p style="margin-bottom: 3px">City: {{ $invoice->invoiceBill->city }}</p>
    @endif
    @if($invoice->invoiceBill->state)
    <p style="margin-bottom: 3px">State: {{ $invoice->invoiceBill->state }}</p>
    @endif
    @if($invoice->invoiceBill->post_code)
    <p style="margin-bottom: 3px">Post Code: {{ $invoice->invoiceBill->post_code }}</p>
    @endif
  </div>


  <div class="payInvoice text-center" style="display: block;width: 100%;text-align: center;margin-top: 40px;">
    <a href="{{url('/dashboard/invoices/'.$invoice->invoice_number)}}" target="_blank" style="padding: 10px;background: #00b2b2;color: #fff;text-decoration: none;border-radius: 5px;">View in your account</a>
  </div>
@endsection