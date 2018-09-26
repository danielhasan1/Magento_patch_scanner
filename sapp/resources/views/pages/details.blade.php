@extends('layout.master')
@section('content')
<b> {{$single->created_at}}</b>
<div class="jumbotron text-center">
    <h3> {{$single->title}}</h3>
    <h4> {{$single->body}}</h4>
</div>
@endsection