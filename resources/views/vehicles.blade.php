@extends("layouts.dashboard")

@section("content")
  <div class="container-fluid h-100">
    <div class="row py-3 h-100">
      <div id="background-box">
        <div class="col-12" id="box">
          <vehicles-page :vehicles="{{ json_encode($vehicles) }}" :columns="{{ json_encode($columns) }}"
            csrf_token="{{ @csrf_token() }}" :errors="{{ $errors->toJson() }}" :old="{{ json_encode(old()) }}"
            :route="{{ json_encode(route("vehicles")) }}" :select="{{ json_encode($select) }}"
            :data="{{ json_encode($data) }}" :url_route="{{ json_encode(route('welcome'))}}"></vehicles-page>
        </div>
      </div>
    </div>
  </div>
@endsection
