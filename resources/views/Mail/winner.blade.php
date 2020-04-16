@extends('Mail.master.master')
@section('content')
    <div class="container mb-3 mt-3">
        <h1> Parabéns {{$name ?? ''}} </h1>
        <br><br>

        <p style="font-size: 16px">Você foi o ganhador(a)...<br><br>

            Do sorteio <b>{{$sorteio}} </b>e você tem o prazo de <b>7 dias Uteis </b> para entrar em contato Conosco caso
            Contrario você perdera o direito ao premioo entre em contato pelo WhatssApp clicando no botão a baixo    ou
            indo diretamente no endereço Av. Paraná 1157 - centro




        </p>
        <a href="https://api.whatsapp.com/send?phone=55+45+998465442&amp;text=Olá, eu fui o ganhador do sorteio .">
            <button class="btn btn-outline-success btn-lg btn-block  mb-3">
                Enviar Mensagen
            </button> </a>


    </div>

@endsection
