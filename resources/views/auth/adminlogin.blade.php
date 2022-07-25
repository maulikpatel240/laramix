@extends('layouts.admin')

@section('content')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="" class="h1">{{ app_name() }}</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">{{ __('Sign in to start your session') }}</p>
                {{ Form::open([
                    'route' => 'admin.checklogin',
                    'class' => '',
                    'id' => 'my-form',
                    'name' => 'loginform',
                    'enableAjaxSubmit' => 1,
                ]) }}
                <div id="formerror" class="formerror"></div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text" id="username_addon"><i class="fas fa-user"></i></span>
                        {{ Form::text('email', old('email'), [
                            'class' => 'form-control',
                            'id' => 'loginform-email',
                            'placeholder' => 'Email',
                            'autocomplete' => 'email',
                            'autofocus' => true,
                            'aria-describedby' => 'username_addon',
                        ]) }}
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text" id="password_addon"><i class="fas fa-lock"></i></span>
                        {{ Form::password('password', [
                            'class' => 'form-control',
                            'id' => 'loginform-password',
                            'placeholder' => 'Password',
                            'aria-describedby' => 'password_addon',
                            'autocomplete' => 'off',
                        ]) }}
                        <span class="input-group-text"><i
                                class="field-icon toggle-password fa-solid fas fa-eye cursor-pointer"
                                toggle="#loginform-password"></i> </span>

                    </div>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            {{ Form::checkbox('remember', 'on', old('agreement') == 'on' ? true : false, [
                                'class' => 'form-check-input',
                                'id' => 'loginform-remember',
                            ]) }}
                            {{ Form::label('loginform-remember', 'Remember Me', ['class' => '']) }}
                        </div>
                    </div>
                    <div class="col-4">
                        {{ Form::button('Login', [
                            'type' => 'submit',
                            'class' => 'btn btn-primary d-block w-100 mt-3',
                            'id' => 'loginform-submit',
                        ]) }}
                    </div>
                </div>
                {{ Form::close() }}
                <p class="mb-1">
                    @if (Route::has('admin.password.request'))
                        <a class="fs--1" href="{{ route('admin.password.request') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
@section('pagescript')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\LoginRequest', '#my-form') !!}
@endsection
