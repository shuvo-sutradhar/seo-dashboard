@extends('layouts.email')

@section('mail-contetnt')
<table role="presentation" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <p>Hello, <strong>{{ ucfirst($user->name) }}</strong>,</p>
        <p>You've got a new invoice in your account. Please sign in and pay it here:</p>
        <p><a href="{{ url('/dashboard/invoices/'.$invoice->invoice_number) }}" target="__blank">{{ url('/dashboard/invoices/'.$invoice->invoice_number) }}</a></p>
        <br>
        <p>Thanks,<br> Admin</p>
      </td>
    </tr>
  </table>
  <br><br>

  @php
   $invoice = \App\invoice::where('invoice_number', $invoice->invoice_number)->firstOrFail();
   $invoice_item = \App\InvoiceItem::where('invoice_id', $invoice->id)->get();
  @endphp
  <h2 style="margin-bottom: 2px">Invoice</h2>
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


  <div class="payInvoice text-center" style="display: block;width: 100%;text-align: center;margin-top: 40px;">
    <a href="{{url('/dashboard/invoices/'.$invoice->invoice_number)}}" target="_blank" style="padding: 10px;background: #00b2b2;color: #fff;text-decoration: none;border-radius: 5px;">Pay Invoice</a>
  </div>
@endsection