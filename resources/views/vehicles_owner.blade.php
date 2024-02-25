@extends("layouts.dashboard")

@section("content")
  <div class="container-fluid h-100">
    <div class="row py-3 h-100">
      <div class="col-12" id="box">
        <vehicles-owner-page :vehicles="{{ json_encode($vehicles) }}" :customer="{{ json_encode($customer) }}" :columns="{{ json_encode($columns) }}"
          csrf_token="{{ @csrf_token() }}" :errors="{{ $errors->toJson() }}" :old="{{ json_encode(old()) }}"
          :route="{{ json_encode(route("vehicles")) }}" :search="{{ json_encode($search)}}"></vehicles-owner-page>
      </div>
    </div>
  </div>
@endsection
