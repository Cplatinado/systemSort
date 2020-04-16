<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bistrõ da Saude </title>

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
                    Telefone Fixo:
                    <br>
                    Whats App:

                </p>




            </div>
            <div class="col-lg-4 separador">
                <h5> Endereço </h5>
                <div class="dropdown-divider"></div>

                <p>
                    Avenida Paraná Numero 123
                    <Br>
                    Horario de Atendimento  Hrs 11:00 - Hrs 15:00
                </p>

            </div>
            <div class="col-lg-4">
                <h5> Redes sociais </h5>
                <div class="dropdown-divider"></div>

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
