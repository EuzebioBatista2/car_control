@extends("layouts.app")

@section("content")
  <register-page token_csrf="{{ @csrf_token() }}" :errors="{{ $errors->toJson() }}" :old="{{ json_encode(old()) }}"
    register="{{ route("register") }}"></register-page>
@endsection
