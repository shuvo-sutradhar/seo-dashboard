@extends('layouts.email')

@section('mail-contetnt')
<table role="presentation" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <p>Hello, <strong>{{ ucfirst($user->name) }}</strong>,</p>
        <p>You've got a new order <strong>#{{$order->order_number}}</strong> that needs your attention.</p>
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
          <tbody>
            <tr>
              <td align="left">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                    <tr>
                      <td> <a target="__blank" href="{{ url('orders/order/'.$order->order_number) }}" target="_blank">View Order</a> </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        <p>Or</p>
        <p>Click here to view it:<br> <a href="{{ url('orders/order/'.$order->order_number) }}">{{ url('orders/order/'.$order->order_number) }}</a></p>
        <p>Good luck!</p>
      </td>
    </tr>
  </table>
@endsection