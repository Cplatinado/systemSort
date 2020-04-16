<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{asset('images/log.png')}}"/>


    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">

    @yield('css')
    <link rel="stylesheet" href="{{asset('css/sytle.css')}}">

</head>
<body>
<header>
    <div class="container-fluid  header">

        <div class="container ">
            <div class="row">
                <div class="col-sm-6    d-flex text-center justify-content-between ">
                    <img src="{{asset('images/log.png')}}" class="logo" alt="">
                    <img src="{{asset('images/bistro.png')}}" class="bistro" alt="">
                    <img src="{{asset('images/saude.png')}}" class="saude" alt="">


                </div>

                <div class="col-sm-12  col-lg-6 d-flex justify-content-end">

                    <img src="{{asset('images/gostoso.png')}}" class="fit" alt="">

                </div>
            </div>

            <div class="row">
                <div class="col">
                    <nav class="navbar navbar-expand-lg navbar-dark  ">
                        <button class="navbar-toggler " type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link white" href="{{route('web.index')}}">Home <span class="sr-only">(current)</span></a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link white" href="{{route('web.sorteios')}}">Sorteios <span
                                            class="sr-only">(current)</span></a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link white" href="{{route('web.promotions')}}">Promoções <span class="sr-only">(current)</span></a>
                                </li>

                        </div>
                    </nav>
                </div>

            </div>


        </div>


    </div>


</header>
<div class="container">

    @yield('content')

</div>

<div class="container-fluid">
    @yield('captura')
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 separador">
               <h5> Contato </h5>
                <div class="dropdown-divider"></div>
                <p>

                    Whats App: (45) 99846-5442<br>
                    E-mail: <a href="mailto:bistrodasaudefoz@gmail.com" class="white">bistrodasaudefoz@gmail.com</a>

                </p>




            </div>
            <div class="col-lg-4 separador">
                <h5> Endereço </h5>
                <div class="dropdown-divider"></div>

                <p>
                    Avenida Paraná Numero 1157
                    <Br>
                    Horario de Atendimento  Hrs 11:15 - Hrs 14:30
                </p>

            </div>
            <div class="col-lg-4 ">
                <h5> Redes sociais </h5>
                <div class="dropdown-divider"></div>

                <div id="fb-root"></div>
                <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v6.0"></script>
                <div class="fb-share-button" data-href="https://www.facebook.com/OBistrodaSaude/" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.facebook.com%2FOBistrodaSaude%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartilhar</a></div>
<br>
                <a class="instagram" href="https://www.instagram.com/bistrodasaude/"><IMG src="{{asset('images/instagram-esbocado.svg')}}" width="30px"> Instagram </a>

            </div>



        </div>
        <div class="row d-flex justify-content-center mt-3">
            <div class="col-12 text-center">
                Todos os Direitos Reservados -Digital Lab ®
            </div>
        </div>


    </div>

</footer>

<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
@yield('js')
</body>
</html>
