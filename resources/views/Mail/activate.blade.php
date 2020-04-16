@extends('Mail.master.master')
@section('content')
    <div class="container mb-3 mt-3">
        <h1> Olá {{$name ?? ''}} </h1>
        <br><br>

        <p style="font-size: 16px">Já está quase tudo pronto...<br><br>
            É necessário fazer a confirmação do seu email, para isso acesse o link a baixo.
            Este passo <b>é muito importante, pois somente os emails validos estão participando dos sorteios</b>,
            e através deste email que você será notificado caso seja o ganhador do sorteio
            <br>
        </p>

        <a href="{{$link}}" class="btn-block btn btn-outline-success">Validar Email </a>


    </div>

@endsection
