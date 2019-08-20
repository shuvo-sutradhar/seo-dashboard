@extends('layouts.auth')

@section('auth-page-content')

    <div class="panel card-sign">
        <div class="card-title-sign mt-3 text-right">
            <h2 class="title text-uppercase font-weight-bold m-0"><i class="fas fa-user mr-1"></i> Sign Up</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">

                @csrf

                <div class="form-group mb-3">
                    <label>Name</label>
                    <input name="name" type="text" class="form-control form-control-lg {{ $errors->has('name') ? ' is-invalid' : '' }}"  required value="{{ old('name') }}" />

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label>E-mail Address</label>
                    <input name="email" type="email" class="form-control form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" />
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group mb-0">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label>Password</label>
                            <input name="password" type="password" class="form-control form-control-lg {{ $errors->has('password') ? ' is-invalid' : '' }}" required />

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label>Password Confirmation</label>
                            <input name="password_confirmation" type="password" class="form-control form-control-lg" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="checkbox-custom checkbox-default">
                            <input id="AgreeTerms" name="agreeterms" type="checkbox"/>
                            <label for="AgreeTerms">I agree with <a href="#">terms of use</a></label>
                        </div>
                    </div>
                    <div class="col-sm-4 text-right">
                        <button type="submit" class="btn btn-primary mt-2">Sign Up</button>
                    </div>
                </div>

                <span class="mt-3 mb-3 line-thru text-center text-uppercase">
                    <span>or</span>
                </span>

                <div class="mb-1 text-center">
                    <a class="btn btn-facebook mb-3 ml-1 mr-1" href="#">Connect with <i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-twitter mb-3 ml-1 mr-1" href="#">Connect with <i class="fab fa-twitter"></i></a>
                </div>

                <p class="text-center">Already have an account? <a href="{{ route('login') }}">Sign In!</a></p>

            </form>

        </div>
    </div>


@endsection