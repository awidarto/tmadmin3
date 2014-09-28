@extends('layout.login')

@section('content')

{{ Form::open(array('url' => 'login','class'=>'form-signin')) }}
        <h2>Welcome to {{ Config::get('site.name')}}</h2>
        <h6>
            Please sign in to get started!
        </h6>
        <fieldset>
            @if (Session::get('loginError'))
                <div class="alert alert-danger">{{ Session::get('loginError') }}</div>
                     <button type="button" class="close" data-dismiss="alert"></button>
            @endif

            <input class="input-large form-control mg-b-sm" name="email" id="username" type="text" placeholder="email" />

            <input class="input-large form-control mg-b-sm" name="password" id="password" type="password" placeholder="password" />

            <label class="checkbox pull-left">
                <input type="checkbox" value="remember-me">Remember me
            </label>

            <button class="btn btn-info btn-block" type="submit">Sign in</button>

            <div class="text-right mg-b-sm mg-t-sm">
                <a href="{{ URL::to('cameo') }}/#">Forgot password?</a>
            </div>

            <p class="center-block mg-t mg-b text-right">Dont have an account?
                <a href="{{ URL::to('signup') }}">Signup here.</a>
            </p>
        </fieldset>

{{ Form::close() }}


@stop