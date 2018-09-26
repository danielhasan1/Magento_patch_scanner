@extends('layout.master')
@section('content')
<h1>History</h1>
@if(count($hist)>0)
    @foreach($hist as $history)
        <div class="well">
            <h4>{{$history->title}}</h4>
            <small>Checked on {{$history->created_at}}</small>
        </div>
    @endforeach
    {{$hist->links()}}
@else
<h1> No Histroy</h1>
@endif

@endsection