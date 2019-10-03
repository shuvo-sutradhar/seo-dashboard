@extends('layouts.email')

@section('mail-contetnt')
<table role="presentation" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <p>Hello, <strong>{{ ucfirst($user->name) }},</p>
        <p>Thanks for signing up. Your login information is below:</p>
        <ul style="margin:5px 0px; padding: 0; list-style: none;">
            <li><strong>E-mail:</strong> {{ $user->email }}</li>
            <li><strong>Password:</strong> {{ $user->realPassword }}</li>
        </ul>
        <p>You can signin here: <br><a target="__blank" href="{{ url('/') }}">{{ url('/') }}</a></p>
        <p>Please bookmark the login link and add this email to your address book.</p>
        <br>
        <p>Thanks,<br>Admin</p>
      </td>
    </tr>
  </table>
@endsection