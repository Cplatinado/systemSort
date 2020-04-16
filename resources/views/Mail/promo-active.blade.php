@extends('Mail.master.master')
@section('content')
    <div class="container mb-3 mt-3">
        <div class="jumbotron jumbotron-fluid">
            <div class="container text-center">
                <h3 class="display-6">Cupom de Desconto</h3>
                <p class="lead">{{$codigo}}</p>
            </div>
        </div>


    </div>

@endsection
