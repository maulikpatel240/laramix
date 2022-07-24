@extends('layouts.admin')

@section('content')
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                        <div class="card z-index-0 mt-7">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">

                                <div class="bg-gradient-info shadow-info border-radius-lg py-3 pe-1 text-center py-4">
                                    <h4 class="font-weight-bolder text-white mt-1 mb-0">{{ app_name() }}</h4>
                                    <p class="mb-1 text-sm text-white">Sign In</p>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                {{ Form::open([
                                    'route' => 'admin.checklogin',
                                    'class' => '',
                                    'id' => 'my-form',
                                    'name' => 'loginform',
                                    'enableAjaxSubmit' => 1,
                                ]) }}
                                <div id="formerror" class="formerror"></div>
                                <div class="mb-4">
                                    <div class="input-group input-group-outline is-filled">
                                        {{-- <label class="form-label">Email</label> --}}
                                        {{ Form::label('loginform-email', 'Email', ['class' => 'form-label']) }}
                                        {{ Form::text('email', old('email'), [
                                            'class' => 'form-control',
                                            'id' => 'loginform-email',
                                            // 'placeholder' => 'Email',
                                            'autocomplete' => 'email',
                                            'autofocus' => true,
                                            'aria-describedby' => 'username_addon',
                                        ]) }}
                                        {{-- <input type="email" class="form-control"> --}}
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="input-group input-group-outline is-filled">
                                        {{-- <label class="form-label">Password</label> --}}
                                        {{ Form::label('loginform-password', 'Password', ['class' => 'form-label']) }}
                                        {{-- <span class="input-group-text" id="password_addon"><i class="fas fa-lock"></i></span> --}}
                                        {{ Form::password('password', [
                                            'class' => 'form-control',
                                            'id' => 'loginform-password',
                                            // 'placeholder' => 'Password',
                                            'aria-describedby' => 'password_addon',
                                            'autocomplete' => 'off',
                                        ]) }}
                                        <span class="input-group-text"><i
                                                class="field-icon toggle-password fa-solid fas fa-eye cursor-pointer"
                                                toggle="#loginform-password"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-check form-switch d-flex align-items-center">
                                    {{ Form::checkbox('remember', 'on', old('agreement') == 'on' ? true : false, [
                                        'class' => 'form-check-input',
                                        'id' => 'loginform-remember',
                                    ]) }}
                                    {{ Form::label('loginform-remember', 'Remember Me', ['class' => 'form-check-label my-auto ms-2']) }}
                                    {{-- <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label my-auto ms-2" for="rememberMe">Remember me</label> --}}
                                </div>
                                <div class="text-center">
                                    {{ Form::button('Login', [
                                        'type' => 'submit',
                                        'class' => 'btn bg-gradient-info w-100 mt-4 mb-2',
                                        'id' => 'loginform-submit',
                                    ]) }}
                                </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-sm-4 px-1">
                                <p class="mb-0 mt-3 text-sm mx-auto">
                                    @if (Route::has('admin.password.request'))
                                        <a class="text-info text-gradient font-weight-bold"
                                            href="{{ route('admin.password.request') }}">
                                            {{ __('Forgot Password?') }}
                                        </a>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <div class="login-box">
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
    </div> --}}
@endsection
@section('pagescript')
    {!! JsValidator::formRequest('App\Http\Requests\Admin\LoginRequest', '#my-form') !!}
@endsection
