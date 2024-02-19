@extends("layouts.dashboard")

@section("content")
  <div class="container-fluid h-100">
    <div class="row py-3 h-100">
      <div class="col-12" id="box">
        <customers-page :customers="{{ json_encode($customers) }}" :columns="{{ json_encode($columns) }}"
          csrf_token="{{ @csrf_token() }}" :errors="{{ $errors->toJson() }}" :old="{{ json_encode(old()) }}"
          :route="{{ json_encode(route("customers")) }}"></customers-page>
      </div>
    </div>
  </div>
@endsection
