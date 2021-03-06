@extends('adminlte::page')
@section('title', 'Sorteio')

@section('content_header')
@endsection

@section('content')
    <div class="row  ">
        <div class="col-sm">
            <h3><i class="fas fa-gift"></i> Editar Sorteio</h3>

        </div>




    </div>

    <form method="post" action="{{route('admin.sorteios.update',['sorteio'=>$sorteio->id])}}"
          enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row ">


            <div class="col-sm-12">


                <a class="btn bg-gradient-primary" data-toggle="collapse" href="#informacao" role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    Informações
                </a>

                <a class="btn  bg-gradient-primary" data-toggle="collapse" href="#galeria" role="button"
                   aria-expanded="false" aria-controls="collapseExample">
                    Galeria
                </a>

                <a href="" data-toggle="modal" data-target="#sorteioo" class="btn bg-gradient-primary"> Realizar
                    Sorteio</a>
                <a href="" data-toggle="modal" data-target="#lancar" class="btn bg-gradient-primary"> Lançar
                    Sorteio</a>

                <a href="{{route('web.sort',['sorteio'=>$sorteio->slug])}}" class="btn bg-gradient-primary"> Ver
                    Sorteio</a>


                <div class="collapse" id="informacao">
                    <div class="card card-body">
                    <div class="row d-flex justify-content-around">
                        <div class="col-sm-4">

                            <ul class="list-group">
                                <li class="list-group-item">Usuarios Cadastrados: {{$usercreate}} </li>
                                <li class="list-group-item">Usuarios Confirmados:  {{$userconfimed}}</li>
                                <li class="list-group-item">Usuarios não Confirmados: {{$usernoconfimed}} </li>


                            </ul>
                        </div>
                        <div class="col-sm-4">
                            <ul class="list-group">


                                <li class="list-group-item">Visitantes: {{$sorteio->views}}</li>
                                <li class="list-group-item">Visitantes não cadastrados: {{$sorteio->views - $usercreate}}</li>

                            </ul>
                        </div>
                    </div>
                </div>
                </div>

            </div>


            <div class="col-sm-12">
                <div class="collapse" id="galeria">
                    <div class="card card-body">
                        <div class="form-group">


                            <label><i class="fas fa-images"></i> Fotos</label>
                            <input type="file" name="files[]" class="form-control-file" multiple="">

                            <div class="content_image"></div>
                        </div>


                    </div>

                    <div class="property_image d-flex justify-content-between flex-wrap">
                        @foreach($sorteio->images()->orderBy('cover', 'ASC')->get() as $image)
                            <div class="property_image_item "
                                 style="   !important;margin-bottom: 20px; margin-right: 20px; border-radius: 4px; position: relative; margin-left: 5px">
                                <img src="{{ $image->url_cropped }}" width="270" class="" alt="">
                                <div class="property_image_actions "
                                     style="position: absolute;top: 10px;left: 10px; ">
                                    <a href="javascript:void(0)"
                                       class="fas fa-check-square image-set-cover align-items-center"
                                       style="color: {{ ($image->cover == true ? 'green' : 'grey') }}; background-color: rgb(255,255,255); border-radius: 1px; margin-top: 10px; height: 12px;  margin-right: 5px "
                                       data-action="{{route('admin.image.cover',['image'=>$image->id])}}"></a>


                                    <a href="javascript:void(0)"
                                       class="fas fa-window-close image-remove"
                                       style="color: red ; background-color: rgb(255,255,255); border-radius: 1px; margin-top: 10px; height: 12px; "
                                       data-action="{{route('admin.image.destroy',['image'=>$image->id])}}"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>


                </div>


            </div>

        </div>


        </div>
        <div class=" card  mt-4 pt-4 pr-2 pl-4">
            <div class="row ">
                <div class="col-sm-12">
                    <!-- text input -->
                    <div class="form-group">
                        <label><i class="fas fa-signature"></i> Titulo</label>
                        <input type="text" name="titulo" required class="form-control" value="{{$sorteio->title}}"
                               placeholder="Ex: Sorteio Do Mês">
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label><i class="fas fa-filter"></i>Status</label>
                        <select name="status" class="form-control">
                            <option value=""></option>
                            <option value="0" {{($sorteio->status == 0 ? 'selected' : '')}}>Inativo</option>
                            <option value="1" {{($sorteio->status == 1 ? 'selected' : '')}}>Ativo</option>

                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label><i class="fas fa-filter"></i>Data Do Sorteio</label>
                        <input type="text" class="form-control mask-date" required placeholder="dd/mm/aaaa"
                               name="date" value="{{$sorteio->date}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label><i class="fas fa-filter"></i>Headline</label>
                        <input type="text" name="headline" class="form-control required "
                               placeholder="Ex: Venha participar de sorteio maravilhoso"
                               value="{{$sorteio->headline  ?? ''}}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label><i class="fas fa-filter"></i>Chama do Sorteio</label>
                        <input type="text" class="form-control mask-date" required
                               placeholder="Faça uma breve e chamativa descrição do sorteio"
                               name="call" value="{{$sorteio->call ?? ''}}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- textarea -->
                    <div class="form-group">
                        <div class="form-group">
                            <label><i class="fas fa-signature"></i> Descrição</label>
                            <textarea name="description" required cols="10" rows="20"
                                      class="mce form-control"> {!! $sorteio->description !!} </textarea>
                        </div>
                    </div>

                </div>


            </div>


        </div>
        <div class="row justify-content-end">
            <button type="submit" class="btn bg-gradient-success"> Salvar</button>

        </div>


    </form>


    <div class="modal fade" id="lancar" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-lancar" method="post" action="{{route('admin.lancar.sort',['id'=>$sorteio->id])}}">
                    @csrf
                    <div class="modal-header">

                        <h4 class="modal-title"><i class="fas fa-gift"></i>Lançar Sorteio </h4>
                        <hr>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group text-center">

                                    <h5>Desejá notificar todos os contatos  sobre novo sorteio ?</h5>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">fechar</button>
                        <input type="submit"  class="btn btn-info " value="Enviar">
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="modal fade" id="sorteioo"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="sortear" action="{{route('admin.sortear',['id'=> $sorteio->id])}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">

                        <h4 class="modal-title"><i class="fas fa-gift"></i>{{($sorteio->finalized == true ? 'Sorteio finalizado' : 'Realizar Sorteio')}} </h4>
                        <hr>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group text-center">
                                    <label><i class="fas fa-users"></i> Usuarios cadastrados</label>
                                    <p>{{$users}}</p>
                                    <h5>{{($sorteio->finalized == true ? 'Sorteio finalizado' : 'Deseja Realizar Sorteio ?')}}</h5>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">fechar</button>
                        <input type="submit"  class="btn btn-info {{($sorteio->finalized == true ? 'disabled' : '')}}" value="Sortear">
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="result-modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="sortear" action="{{route('admin.sortear',['id'=> $sorteio->id])}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">

                        <h4 class="modal-title"><i class="fas fa-gift"></i> Sorteio Realizado com Sucesso...</h4>
                        <hr>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="jumbotron jumbotron-fluid">
                                    <div class="container">
                                        <h1 class="display-4">Ganhador(a)</h1>
                                        <div id="result">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">fechar</button>
                        <input type="submit" class="btn btn-info" value="Sortear Novamente">
                    </div>
                </form>
                <form id="" method="post" action="{{route('admin.finalizar.sort',['id'=>$sorteio->id])}}">
                    @csrf
                    <div class="row ">
                        <div class="col-sm-12  d-flex justify-content-end">
                            <input type="hidden" id="name" name="name" value="">
                            <input type="hidden" id="email" name="email">
                            <input type="submit" class="btn btn-block mb-2 btn-success" value="Finalizar Sorteio">

                        </div>

                    </div>




                </form>

            </div>


        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->






@endsection

@section('js')

    <script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('js/scripts.js')}}"></script>

    <script>
        $(function () {
            $('input[name="files[]"]').change(function (files) {

                $('.content_image').text('');

                $.each(files.target.files, function (key, value) {
                    var reader = new FileReader();
                    reader.onload = function (value) {
                        $('.content_image').append(
                            '<div class="property_image_item">' +
                            '<div class="embed radius" ' +
                            'style="background-image: url(' + value.target.result + '); background-size: cover; background-position: center center;">' +
                            '</div>' +
                            '</div>');
                    };
                    reader.readAsDataURL(value);
                });
            });
        })
    </script>

    @if(session()->exists('message') )
        <script>

            $(function () {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000
                });

                Toast.fire({
                    type: '{{session('type')}}',
                    title: '{{session('message') }}'
                })
            })
        </script>
    @endif


    <script>
        $(function () {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            $('.image-remove').click(function (event) {
                event.preventDefault();

                var button = $(this);

                $.ajax({
                    url: button.data('action'),
                    type: 'DELETE',
                    dataType: 'json',
                    success: function (response) {
                        var type = 'success';
                        var message = 'Imagen Deletada Com sucesso !!';

                        if (response.success === true) {
                            button.closest('.property_image_item').fadeOut(function () {
                                $(this).remove();
                                alert(type, message)


                            });
                        }
                    }
                })
            });

            $('.image-set-cover').click(function (event) {
                event.preventDefault();

                var button = $(this);

                $.post(button.data('action'), {}, function (response) {

                    if (response.success === true) {
                        var type = 'success';
                        var message = 'Capa Aleterada Com sucesso !!';
                        $('.property_image').find('a.fa-check-square ').css('color', 'grey');
                        button.css('color', 'green');
                        alert(type, message)

                    }
                }, 'json');
            });







            $('form[name="sortear"]').submit(function (event) {
                event.preventDefault();
                const form = $(this);
                const action = form.attr('action');



                $.post(action, {}, function (response) {

                    console.log(response);
                    console.log(response.name);

                        $.each(response ,function (key, item) {
                            $('#result').empty();
                            $('#result').append("<p class='lead'>"+ 'Nome: ' +item.name+ "</p> ");
                            $('#result').append("<p class='lead'>"+ 'E-Mail: ' +item.email+ "</p> ");
                            $('#result').append("<p class='lead'>"+ 'Telefone: ' +item.tel+ "</p> ");
                            $('#name').val(item.name);
                            $('#email').val(item.email);


                        })
                    //
                        $('#result-modal').modal('show');



                })


            });


            $('#form-lancar').submit(function (event) {
                event.preventDefault();
                const form = $(this);
                const action = form.attr('action');
                $.post(action, { }, function (response) {

                    if(response == 'enviado'){
                        var type = 'success';
                        var message = 'E-mails enviado com sucesso ';
                        $('#lancar').modal('hide');
                        alert(type,message);


                    }
                })


            });


            function alert(type, message) {
                $(function () {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000
                    });

                    Toast.fire({
                        type: type,
                        title: message
                    })
                })


            }


        });



    </script>


@endsection
