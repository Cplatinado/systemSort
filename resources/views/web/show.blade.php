@extends('web.master.master')
@section('css')
    <link rel="stylesheet" href="{{asset('css/ekko-lightbox.css')}}">
    <meta name="csrf-token" content="{{csrf_token()}}">
    {!! $head  ?? ''!!}

@endsection
@section('content')
    <section class="main_property">
        <div class="main_property_header mt-4  ">
            <div class="container">
                <h1 class="">{{$item->title}}</h1>
            </div>
        </div>


        <div class="main_property_content py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div id="carouselProperty" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @if($item->images()->get()->count())
                                    @foreach($item->images()->get() as $image)
                                        <li data-target="#carouselProperty"
                                            data-slide-to="{{$loop->iteration}}" {!! ($loop->iteration == 1 ? 'class="active"' : '') !!}></li>
                                    @endforeach
                                @endif


                            </ol>
                            <div class="carousel-inner">
                                @if($item->images()->get()->count())


                                    @foreach($item->images()->get() as $image)
                                        <div class="carousel-item {{($loop->iteration == 1 ? "active" : '')}} ">
                                            <a href="{{$image->getUrlCroppedAttribute()}}"
                                               data-toggle="lightbox"
                                               data-gallery="property-gallery" data-type="image">
                                                <img src="{{$image->getUrlCroppedAttribute()}}"
                                                     class="d-block w-100"
                                                     alt="{{$item->title}}">
                                            </a>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                            <a class="carousel-control-prev" href="#carouselProperty" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Anterior</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselProperty" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Próximo</span>
                            </a>
                        </div>


                        <div class="main_property_content_description">
                            <h2 class="text-front">Descrição</h2>
                            {!! $item->description !!}
                        </div>


                    </div>

                    <div class="col-12 col-lg-4">
                        {{--                        <button class="btn btn-outline-success btn-lg btn-block icon-whatsapp mb-3">Converse com o Corretor!--}}
                        {{--                        </button>--}}

                        <div class="sortear-content">
                            <h3 class="bg-front sortear text-center">
                                Participar {{ ($promotion == true ? 'da Promoção' : ' do Sorteio' ) }} </h3>
                            <div class="container">
                                <form
                                    method="post" name="participar" action="{{ ($promotion == true ? route('web.promocoes.participar') :
                                        route('web.sorteios.participar') ) }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Seu nome:</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                               placeholder="Informe seu nome completo">
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                    </div>

                                    <div class="form-group">
                                        <label for="telephone">Seu telefone:</label>
                                        <input type="int" id="telephone" name="tel" class="form-control  mask-phone"
                                               placeholder="Informe seu telefone com DDD">
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Seu e-mail:</label>
                                        <input type="text" id="email" name="email" class="form-control"
                                               placeholder="Informe seu melhor e-mail">
                                    </div>


                                    <div class="form-group">
                                        <button class="btn btn-block btn-front">Enviar</button>
                                        <p class="text-center text-front mb-0 mt-4 font-weight-bold">(45)  99846-5442</p>
                                    </div>
                                </form>
                            </div>


                        </div>

                        <div class="main_property_share py-3 text-right">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Cadastro Concluido com Sucesso !!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="font-size: 15px">Já está quase tudo pronto...<BR><BR>
                        Nos Enviamos um E-mail para você, poderia confirmar  o mesmo ?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="error" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ooopss!!!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="errors" >


                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('js/ekko-lightbox.min.js')}}"></script>
    <script src="{{asset('js/jquery.Mask.js')}}"></script>
    <script src="{{asset('js/jqueryMask.js')}}"></script>
    <script>
        $(function () {

            $('body').on('click', '[data-toggle="lightbox"]', function (event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });

            $('.open_filter').on('click', function (event) {
                event.preventDefault();

                box = $(".form_advanced");
                button = $(this);

                if (box.css("display") !== "none") {
                    button.text("Filtro Avançado ↓");
                } else {
                    button.text("✗ Fechar");
                }

                box.slideToggle();
            });
        })
    </script>
    <script >
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name ="csrf-token"]').attr('content')
                }
            });



            $('form[name="participar"]').submit(function (event) {
                event.preventDefault();
                const form = $(this);
                const action = form.attr('action');
                const email = form.find('input[name ="email"]').val();
                const tel = form.find('input[name ="tel"]').val();
                const name = form.find('input[name ="name"]').val();
                const id = form.find('input[name ="id"]').val();


                $.post(action, {name, email, tel, id}, function (response) {

                    console.log(response.errors);
                    if(response.message == 'enviado'){
                        $('#modalExemplo').modal('show');
                    }



                    if(response.errors){
                        $('#errors').empty();
                        if(response.errors == 'E-mail já cadastrado' ){
                            $('#errors').append("<div class= 'alert alert-warning'>" +response.errors + "</div> ");
                            $('#error').modal('show');

                        }

                        $.each(response.errors ,function (key, item) {
                            $('#errors').append("<div class= 'alert alert-warning'>" +item.error + "</div> ");

                        })

                        $('#error').modal('show');
                    }


                })


            })



        })



    </script>

@endsection
