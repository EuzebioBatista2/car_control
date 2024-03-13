@extends("layouts.dashboard")

@section("content")
  <div class="container-fluid h-100">
    <div class="row py-3 h-100">
      <div id="background-box">
        <div class="col-12" id="box">
          <graph-page :customers="{{ json_encode($customers) }}" :vehicles="{{ json_encode($vehicles) }}"
            :reviews="{{ json_encode($reviews) }}" :line_graph="{{ json_encode($line_graph) }}"
            :genders_total="{{ json_encode($genders) }}" :top_customers="{{ json_encode($top_customers) }}"
            :route_pdf="{{ json_encode(route('pdf')) }}" :route_excel="{{ json_encode(route('excel')) }}"></graph-page>
        </div>
      </div>
    </div>
  </div>
@endsection
