@extends("layouts.dashboard")

@section("content")
  <div class="container-fluid h-100">
    <div class="row py-3 h-100">
      <div id="background-box-edit">
        <div class="col-12" id="box">
          <account-page :informations="{{ json_encode(route("informations")) }}"
            :password="{{ json_encode(route("password")) }}" csrf_token="{{ @csrf_token() }}"
            :errors="{{ $errors->toJson() }}" :old="{{ json_encode(old()) }}"
            :route="{{ json_encode(route("dashboard")) }}" :account="{{ json_encode(auth()->user()) }}"
            :delete="{{ json_encode(route("delete")) }}"></account-page>
        </div>
      </div>
    </div>
  </div>
@endsection
