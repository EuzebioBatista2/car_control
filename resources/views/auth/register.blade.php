@extends("layouts.register")

@section("content")
  <register-page token_csrf="{{ @csrf_token() }}" :errors="{{ $errors->toJson() }}" :old="{{ json_encode(old()) }}"
    register="{{ route("register") }}" route_login="{{ route('login') }}"></register-page>
@endsection
