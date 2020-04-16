@extends('Mail.master.master')
@section('content')
    <div class="container mb-3 mt-3">
        <h1> Olá {{$name ?? ''}} </h1>
        <br><br>

        <p style="font-size: 16px">{{$sorteio}}.<br><br>
           {{$call}}
            <br>
        </p>

        <div style="background-image: {{asset('images/captura.png')}}"></div>

        <a href="{{$link}}" class="btn-block btn btn-outline-success">Ver Mais </a>


    </div>

@endsection
