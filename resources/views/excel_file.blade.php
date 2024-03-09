@extends("layouts.file")

@section("content")
  <div class="container-fluid h-100">
    <div class="row py-3 h-100">
      <div class="col-12" id="box">
        <excel-page
          :customers_table="{{ json_encode($customers_table) }}"
          :customers_columns="{{ json_encode($customers_columns) }}"
          :vehicles_table="{{ json_encode($vehicles_table) }}"
          :vehicles_columns="{{ json_encode($vehicles_columns) }}"
          :reviews_table="{{ json_encode($reviews_table) }}"
          :reviews_columns="{{ json_encode($reviews_columns) }}"
          :route_dashboard="{{ json_encode(route('dashboard')) }}"></excel-page>
      </div>
    </div>
  </div>
@endsection
