@extends('layout.login')

@section('content')
            <!-- if there are login errors, show them here -->
@if(Auth::check())
    <p class="navbar-text pull-right">
        Hello {{ Auth::user()->fullname }}
        <a href="{{ URL::to('logout')}}" >Logout</a>
    </p>
@endif

{{ Form::open(array('url' => 'login','class'=>'form-signin')) }}
        <h3>Welcome to</h3>
        <h2>{{ Config::get('site.name')}}</h2>
        <fieldset>
            @if (Session::get('loginError'))
                <div class="alert alert-danger">{{ Session::get('loginError') }}</div>
                     <button type="button" class="close" data-dismiss="alert"></button>
            @endif

            <input class="input-large span12" name="email" id="username" type="text" placeholder="email" />

            <input class="input-large span12" name="password" id="password" type="password" placeholder="password" />

            <div class="clearfix"></div>

            <label class="remember" for="remember"><input type="checkbox" id="remember" />Remember me</label>

            <div class="clearfix"></div>

            <button type="submit" class="btn btn-primary span12">Login</button>
        </fieldset>

{{ Form::close() }}

@stop