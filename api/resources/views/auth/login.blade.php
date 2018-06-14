@extends('layouts.app')

@section('styles')
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@stop

@section('content')

  <div class="container">
    <div class="row">

      <div class="col-xs-12 offset-sm-3 col-sm-6">

        <div class="card mx-auto">
          <div class="card-body">

            <div class="col form-box">
              <div class="form-top">
              </div>
              <div class="form-bottom">
                <form role="form" method="POST" action="{{ url('/login') }}" class="login-form">

                  {!! csrf_field() !!}

                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="sr-only" for="email">E-Mail</label>
                    <input type="text" name="email" placeholder="E-Mail" class="form-email form-control" id="form-email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                      <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                      </span>
                    @endif
                  </div>

                  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="sr-only" for="password">Password</label>
                    <input type="password" name="password" placeholder="Password" class="form-password form-control" id="form-password" value="{{ old('password') }}">
                    @if ($errors->has('password'))
                      <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                      </span>
                    @endif
                  </div>

                  <button type="submit" class="btn btn-info">Login</button>

                </form>
              </div>
            </div>

          </div>

        </div>
      </div>

    </div>
  </div>

@endsection
