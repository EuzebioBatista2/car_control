@extends("layouts.dashboard")

@section("content")
  <div class="container-fluid h-100">
    <div class="row py-3 h-100">
      <div id="background-box-edit">
        <div class="col-12" id="box">
          <edit-vehicle-page :customer="{{ json_encode($customer) }}" :vehicle="{{ json_encode($vehicle) }}"
          csrf_token="{{ @csrf_token() }}" :errors="{{ $errors->toJson() }}" :old="{{ json_encode(old()) }}"
          :route="{{ json_encode(route("vehicles")) }}" :url_route="{{ json_encode(route('welcome'))}}"></edit-vehicle-page>
        </div>
      </div>
    </div>
  </div>
@endsection
