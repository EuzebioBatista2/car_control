@extends('layouts.home')

@section('content')
  <home-page :auth="{{ json_encode($auth) }}"></home-page>
@endsection
