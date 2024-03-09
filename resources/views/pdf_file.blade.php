@extends("layouts.file")

@section("content")
  <div class="container-fluid h-100">
    <div class="row py-3 h-100">
      <div class="col-12" id="box">
        <pdf-page :customers_graph="{{ json_encode($customers_graph) }}"
          :vehicles_graph="{{ json_encode($vehicles_graph) }}" :reviews_graph="{{ json_encode($reviews_graph) }}"
          :line_graph="{{ json_encode($line_graph) }}" :genders_graph="{{ json_encode($genders_graph) }}"
          :top_customers_graph="{{ json_encode($top_customers_graph) }}"
          :customers_table="{{ json_encode($customers_table) }}"
          :customers_columns="{{ json_encode($customers_columns) }}"
          :vehicles_table="{{ json_encode($vehicles_table) }}"
          :vehicles_columns="{{ json_encode($vehicles_columns) }}"
          :reviews_table="{{ json_encode($reviews_table) }}"
          :reviews_columns="{{ json_encode($reviews_columns) }}"
          :route_dashboard="{{ json_encode(route('dashboard')) }}"></pdf-page>
      </div>
    </div>
  </div>
@endsection
