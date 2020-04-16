@extends('adminlte::page')
@section('title', 'Sorteios')

@section('content_header')
    <h3>Sorteios {{ ($ativos == 'home' ? '' : $ativos ) }}</h3>
    @if($errors->all())
        @foreach($errors->all() as $error)
            <div class="alert alert-warning">{{$error}}</div>
        @endforeach
    @endif

@endsection

@section('content')



    <div class="row ">
        <div class="col-sm-12">
            <h5>Ações</h5>
            <a href="{{route('admin.sorteios.index')}}"
               class="btn btn-sm  {{($ativos == 'ativos' ? 'home' : '')}} bg-gradient-success mr-2  "><i
                    class="fas fa-list-ul"></i> Todos Sorteios </a>
            <a href="{{route('admin.sorteio.ativos')}}"
               class="btn btn-sm  {{($ativos == 'ativos' ? 'active' : '')}} bg-gradient-success mr-2  "><i
                    class="fas fa-list-ul"></i> Ativos </a>

            <a href="{{route('admin.sorteio.inativos')}}"
               class="btn btn-sm {{($ativos == 'inativos' ? 'active' : '')}} bg-gradient-warning mr-2"><i
                    class="fas fa-list-ul"></i> Inativos</a>

            <a href="" class="btn btn-sm bg-gradient-primary  " data-toggle="modal" data-target="#add"><i
                    class="fas fa-plus"></i> Novo Sorteio</a>


            <hr>
        </div>
    </div>

    <h4> Visao geral</h4>
    <div class="row d-flex justify-content-around mt-4">


        <div class="col-md-3">
            <div class="card bg-secondary">
                <div class="card-header">
                    <h3 class="card-title">Sorteios</h3>


                    <!-- /.card-tools -->
                </div>


                <!-- /.card-header -->
                <div class="card-body" style="display: block;">
                    <p>Sorteios Criados: {{$sortscreate}}</p>
                    <p>Sorteios Finalizados:{{$sortsFinalized}}</p>
                    <p>Sorteios Ativos: {{$sortsavailable}}</p>
                    <p>Sorteios Inativos: {{$sortsunavaiable}}</p>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        <div class="col-md-3">
            <div class="card bg-secondary">
                <div class="card-header">
                    <h3 class="card-title">Usuarios </h3>

                    <div class="card-tools">

                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="display: block;">
                    <p>Usuario cadastrados nos sorteios: {{$usersort}}</p>
                    <p>Usuario cadastrados nas promoções: {{$userpromo}}</p>
                    <p>total cadastrados: {{$userpromo + $usersort}}</p>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary">
                <div class="card-header">
                    <h3 class="card-title">Promoções</h3>

                    <div class="card-tools">

                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="display: block;">
                    <p>Promoções Criados: {{$promocreate}}</p>
                    <p>Promoções Finalizados: {{$promofinalized}}</p>
                    <p>Promoções Ativos: {{$promoavailable}}</p> <br>
                    <br>

                </div>
                <!-- /.card-body -->
            </div>

            <!-- /.card -->
        </div>

    </div>
    <hr>
    <h4>Ultimos Sorteios {{ ($ativos == 'home' ? '' : $ativos ) }}</h4>

    <div class="row">
        @foreach($sorts as $sort)

            <div class="col-md-3">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{$sort->title}}</h3>
                    </div>
                    <div class="card-body ">
                        <img width="100%" src="{{$sort->cover()}}">
                    </div>

                    <div class="card-footer">
                        <a href="{{route('admin.sorteios.edit',['sorteio'=>$sort->id])}}"
                           class="btn btn-block bg-gradient-success"> <i class="fas fa-plus"> </i> Ver mais</a>

                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        @endforeach
    </div>

    {{$sorts->links()}}





    <div class="modal fade" id="add" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('admin.sorteios.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">

                        <h4 class="modal-title"><i class="fas fa-gift"></i> Adcionar Sorteio</h4>
                        <hr>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label><i class="fas fa-signature"></i> Titulo</label>
                                    <input type="text" name="titulo" required class="form-control"
                                           placeholder="Ex: Sorteio Do Mês" value="{{old('titulo')}}">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-6">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label><i class="fas fa-images"></i> Fotos</label>
                                    <input type="file" name="cover" class="form-control-file " style="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><i class="fas fa-filter"></i>Data Do Sorteio</label>
                                    <input type="text" class="form-control mask-date" required placeholder="dd/mm/aaaa"
                                           name="date" value="{{old('date')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- textarea -->
                                <div class="form-group">
                                    <div class="form-group">
                                        <label><i class="fas fa-signature"></i> Descrição</label>
                                        <textarea name="description" required cols="8" rows="4"
                                                  class="mce form-control">{{old('description')}} </textarea>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">fechar</button>
                        <input type="submit" class="btn btn-info" value="Adicionar">
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


@endsection

@section('js')
    <script src="{{asset('js/scripts.js')}}"></script>
    <script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('js/jquery.mask.js')}}"></script>
    <script src="{{asset('js/jqueryMask.js')}}"></script>

@endsection
