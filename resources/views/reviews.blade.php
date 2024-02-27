@extends("layouts.dashboard")

@section("content")
  <div class="container-fluid h-100">
    <div class="row py-3 h-100">
      <div class="col-12" id="box">
        <reviews-page :reviews="{{ json_encode($reviews) }}" :columns="{{ json_encode($columns) }}"
          csrf_token="{{ @csrf_token() }}" :errors="{{ $errors->toJson() }}" :old="{{ json_encode(old()) }}"
          :route="{{ json_encode(route("reviews")) }}" :search="{{ json_encode($search)}}"></reviews-page>
      </div>
    </div>
  </div>
@endsection
