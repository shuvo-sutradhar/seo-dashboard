@extends('layouts.auth')

@section('auth-page-content')

    <div class="panel card-sign">
        <div class="card-title-sign mt-3 text-right">
            <h2 class="title text-uppercase font-weight-bold m-0"><i class="fas fa-user mr-1"></i> Sign In</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">

                @csrf
                
                <div class="form-group mb-3">
                    <label>E-Mail Address</label>
                    <div class="input-group">
                        <input name="email" type="text" class="form-control form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" required value="{{ old('email') }}">
                        <span class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                        </span>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group mb-3">
                    <div class="clearfix">
                        <label class="float-left">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="float-right">Lost Password?</a>
                        @endif
                    </div>
                    <div class="input-group">
                        <input name="password" type="password" class="form-control form-control-lg {{ $errors->has('password') ? ' is-invalid' : '' }}" required>
                        <span class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        </span>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="checkbox-custom checkbox-default">
                            <input  type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="RememberMe">Remember Me</label>
                        </div>
                    </div>
                    <div class="col-sm-4 text-right">
                        <button type="submit" class="btn btn-primary mt-2">Sign In</button>
                    </div>
                </div>

                <span class="mt-3 mb-3 line-thru text-center text-uppercase">
                    <span>or</span>
                </span>

                <div class="mb-1 text-center">
                    <a class="btn btn-facebook mb-3 ml-1 mr-1" href="#">Connect with <i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-twitter mb-3 ml-1 mr-1" href="#">Connect with <i class="fab fa-twitter"></i></a>
                </div>

                <p class="text-center">Don't have an account yet? <a href="{{ route('register') }}">Sign Up!</a></p>

            </form>
        </div>
    </div>


@endsection