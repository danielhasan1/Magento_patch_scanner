@extends('layout.master')
@section('content')
<style>
    .loader {
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #3498db;
      width: 120px;
      height: 120px;
      -webkit-animation: spin 2s linear infinite; /* Safari */
      animation: spin 2s linear infinite;
    }
    
    /* Safari */
    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    </style>

<div id="hide">
<h3>Please proceed after reading it carefully. Not working properly? Reason might be one of the following.</h3>
<ul>
    <li><b>This only works for magento platform services</b></li>
    <li>Please remember including correct <b>'http'</b> or <b>'https'</b> in the url</li>
    <li>Broken URL don't work</li>
    <li>Wrong URL may result in inappropriate behaviour</li>
</ul>
{!! Form::open(['action' => 'PostsController@store', 'method' => 'POST'])!!}
<div class="form-group">
    {{Form::label('title', 'Link')}}
    {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Paste correct URL here'])}}
</div>
{{Form::submit('Submit',['class'=> 'btn btn-primary', 'id' =>'hid'])}}
{!! Form::close()!!}
</div>
<script>
    $(document).ready(function(){
        $("#hid").click(function(){
            $("#hide").hide();
        });
        $("#hid").click(function(){
            $("#sh").show();
        });
    });
</script>
    <div class="loader center-block" id="sh" style="display: none;"></div>
@endsection