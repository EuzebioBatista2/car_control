@extends("layouts.dashboard")

@section("content")
  <div class="container-fluid h-100">
    <div class="row py-3 h-100">
      <div id="background-box">
        <div class="col-12" id="box">
          <reviews_owner-page :reviews="{{ json_encode($reviews) }}" :vehicle="{{ json_encode($vehicle) }}" :columns="{{ json_encode($columns) }}"
            csrf_token="{{ @csrf_token() }}" :errors="{{ $errors->toJson() }}" :old="{{ json_encode(old()) }}"
            :route="{{ json_encode(route("reviews")) }}" :date="{{ json_encode($date) }}" :old_date="{{ json_encode($old_date) }}"></reviews_owner-page>
        </div>
      </div>
    </div>
  </div>
@endsection
