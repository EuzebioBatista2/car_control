@extends("layouts.app")

@section("content")
  <login-page token_csrf="{{ @csrf_token() }}" :errors="{{ $errors->toJson() }}"
    :old="{{ json_encode(old()) }}" login="{{ route('login') }}"></login-page>
@endsection
