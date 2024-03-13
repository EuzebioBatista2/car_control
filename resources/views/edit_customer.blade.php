@extends("layouts.dashboard")

@section("content")
  <div class="container-fluid h-100">
    <div class="row py-3 h-100">
      <div id="background-box-edit">
        <div class="col-12" id="box">
          <edit-customer-page :customer="{{ json_encode($customer) }}"
          csrf_token="{{ @csrf_token() }}" :errors="{{ $errors->toJson() }}" :old="{{ json_encode(old()) }}"
          :route="{{ json_encode(route("customers")) }}"></edit-customer-page>
        </div>
      </div>
    </div>
  </div>
@endsection
