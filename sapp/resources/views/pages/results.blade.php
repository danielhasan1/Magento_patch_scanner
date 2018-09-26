@extends('layout.master')
@section('content')
<div class="">
        
</div>
<ul>
    <li><b>unkn</b> might be because - The check might have been blocked by other security measures you, or your provider, have taken.</li>
    <li>To perform this check correctly, MageReport requires the url to the backend of your Magento installation. Without this url, we’re unable to conclude if this patch is installed.</li>
    <hr>
    <li><b>fail</b> might be because - No such patch or configuration found</li>
</ul>
<table class="table">
    <br>
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Patch</th>
        <th scope="col">Scanned Result</th>
        <th scope="col">RiskRating</th>
      </tr>
    </thead>
      <tbody>
            @for($i=0;$i<count($key);$i++)
        <tr>
           
        <th scope="row">{{$i+1}}</th>
        @if(preg_match('/[0-9]/', $key[$i]))
          <td>Security Patch {{ $key[$i]}}</td>
        @else <td>{{$key[$i]}}</td>
        @endif
        @if($val[$i]->$key[$i]->result==='unkn')
          <td class="warning">{{$val[$i]->$key[$i]->result}}</td>
        @elseif($val[$i]->$key[$i]->result==='fail')
          <td class="danger">{{$val[$i]->$key[$i]->result}}</td>
        @else
          <td>{{$val[$i]->$key[$i]->result}}</td>
        @endif
        @if($val[$i]->$key[$i]->riskRating==='medium')
          <td class="success">{{$val[$i]->$key[$i]->riskRating}}</td>
        @elseif($val[$i]->$key[$i]->riskRating==='high') 
          <td class="danger">{{$val[$i]->$key[$i]->riskRating}}</td>
        @else
          <td>{{$val[$i]->$key[$i]->riskRating}}</td>
       @endif

      </tr>
      @endfor
    </tbody>
  </table>
  <br>
  <hr>
    <h3 class="text-center">Patch Details </h3>
  
  <br>
  <hr>
    @foreach ($detail as $item)
      <div class="well">  
          <h5> {{$item->nodeValue}}</h5>
      </div>
    @endforeach
  
@endsection

        