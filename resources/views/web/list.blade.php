@extends('web.master.master')
@section('css')
    <link rel="stylesheet" href="{{asset('css/ekko-lightbox.css')}}">
    <meta name="csrf-token" content="{{csrf_token()}}">
    {!! $head  ?? ''!!}

@endsection
@section('content')
    <h4 class="mt-4 mb-3"> {{ ( $sorteio == true ? 'Todos Sorteios' : 'Todas Promoções' ) }} </h4>
    <hr>

    <div class="row">

        @foreach($list as $item)
            <div class="col-sm-12 col-lg-3">
                <div class="card-deck">
                    <div class="card">
                        <a href="{{route('web.sort',['sorteio'=>$item->slug]) ?? route('web.sort',['sorteio'=>$item->slug])}}">
                            <img class="card-img-top"
                                 src="{{ ($item->cover() ??  asset('undraw_gift_card_6ekc.svg') ) }}"
                                 alt="Card image cap">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{$item->title}}</h5>
                            <p class="card-text">{{$item->call}}</p>
                            <p class="card-text"><small class="text-muted">
                                    {{( $sorteio  == true ? 'Data do Sorteio' : 'Fim da Pomoção' )}}
                                    {{ date('d/m/Y', strtotime( $item->updated_at)) }}</small></p>
                        </div>

                        <div class="card-footer">
                            <a href="{{ ($sorteio == true ? route('web.sort',['sorteio'=>$item->slug]) : route('web.promotion',['promocao'=>$item->slug]) ) }}"
                               class="btn btn-block btn-outline-success">Ver mais</a>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

        {{$list->links()}}


    </div>




@endsection

@section('captura')

    <div class="row captura d-flex justify-content-center align-items-center ">
        <div class="col-sm-7 ">

        </div>
        <div class="col-sm-4 white ">
            <h1 class="mt-2 text-center"> Fique por Dentro de Tudo !!!</h1>
            <p class="captura_font text-center">Gostou dos nossos sorteios ? não perca tempo e fique por dentro das as
                promoções e sorteios realizados
                basta inserir seu nome e email

            </p>

            <form id="captura" method="post" action="{{route('web.captura')}}" class="text-center">
                @csrf
                <div class="form-group">
                    <input type="text" required class=" form_captura" name="email" placeholder="Digite o Seu Melhor Email...">

                </div>
                <div class="form-group">
                    <input type="text" required class="form_captura" name="name" placeholder="Qual é seu nome ? ">

                </div>


                <button type="submit" class="form-button"> Enviar</button>


            </form>



        </div>


    </div>
    <div id="capturar" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Cadastro Concluido com sucesso !</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Já está tudo certo só esperar as novidades sairem :)</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')

    <script >

        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name ="csrf-token"]').attr('content')
                }
            });

            $('#captura').submit(function (event) {
                event.preventDefault();

                const  form = $(this);
                const action = form.attr('action');
                const  name = $('input[name="name"]').val();
                const  email = $('input[name="email"]').val();

                $.post(action, {name, email}, function (response) {

                    if(response == 'concluido'){
                        $('#capturar').modal('show');
                    }

                })


            })

        })

    </script>

@endsection
