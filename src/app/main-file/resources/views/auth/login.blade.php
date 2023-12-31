@extends('layouts.auth')
@php
    use App\Models\Utility;
    // $lang = \App\Models\Utility::getValByName('default_language');
    $logo=asset(Storage::url('uploads/logo/'));
    $company_logo=Utility::getValByName('company_logo');
    $settings = Utility::settings();

@endphp
@push('custom-scripts')
    @if(env('RECAPTCHA_MODULE') == 'yes')
        {!! NoCaptcha::renderJs() !!}
    @endif
@endpush
@section('page-title')
    {{__('Login')}}
@endsection

@section('auth-lang')
<select class="btn btn-primary my-1 me-2" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" id="language">
    @foreach(Utility::languages() as $code => $language)
        <option class="" @if($lang == $code) selected @endif value="{{ route('login',$code) }}">{{Str::upper($language)}}</option>
    @endforeach
</select>
@endsection

@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <h2 class="mb-3 f-w-600">{{__('Login')}}</h2>
    </div>
    {{-- @if ($errors->any())
        @foreach ($errors->all() as $error)
            <span class="text-danger">{{$error}}</span>
        @endforeach
    @endif --}}
    {{Form::open(array('route'=>'login','method'=>'post','id'=>'loginForm' ))}}
    @csrf
    <div class="">
        <div class="form-group mb-3">
            <label for="email" class="form-label d-flex align-items-center justify-content-between">{{__('Email')}}</label>
            <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
            <div class="invalid-feedback" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="password" class="form-label d-flex align-items-center justify-content-between">{{__('Password')}}</label>
            <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" required autocomplete="current-password">
            @error('password')
            <div class="invalid-feedback" role="alert">{{ $message }}</div>
            @enderror

        </div>

        @if(env('RECAPTCHA_MODULE') == 'yes')
            <div class="form-group mb-3">
                {!! NoCaptcha::display() !!}
                @error('g-recaptcha-response')
                <span class="small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
        @endif
        <div class="form-group mb-4">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs d-flex align-items-center justify-content-between">{{ __('Forgot Your Password?') }}</a>
            @endif
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-block mt-2" id="login_button">{{__('Login')}}</button>

        </div>
        @if($settings['enable_signup'] == 'on')
            <p class="my-4 text-center">{{__("Don't have an account?")}} <a href="{{ route('register') }}" class="text-primary">{{__('Register')}}</a></p>
        @endif

        <div class="row">
            <div class="col-6 d-grid">
                <a href="{{route('customer.login')}}" class="btn-login btn btn-primary btn-block mt-2 text-white">{{__('Customer Login')}}</a>

            </div>
            <div class="col-6 d-grid">
                <a href="{{route('vender.login')}}" class="btn-login btn btn-primary btn-block mt-2 text-white">{{__('Vendor Login')}}</a>
            </div>
        </div>

    </div>
    {{Form::close()}}
@endsection

@push('custom-scripts')
    
<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $("#loginForm").submit(function (e) {
            $("#login_button").attr("disabled", true);
            return true;
        });
    });



</script>
@endpush