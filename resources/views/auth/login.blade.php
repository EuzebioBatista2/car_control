@extends("layouts.login")

@section("content")
  <login-page token_csrf="{{ @csrf_token() }}" :errors="{{ $errors->toJson() }}"
    :old="{{ json_encode(old()) }}" login="{{ route('login') }}" route_register="{{ route('register') }}"></login-page>
@endsection
