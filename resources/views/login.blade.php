@section('content_header')
    <meta name="csrf-token" content="{{csrf_token()}}">
@stop


@extends('adminlte::login')


@section('js')
    <script !src="">
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name ="csrf-token"]').attr('content')
                }
            });
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $('form[name="login"]').submit(function (event) {
                event.preventDefault();
                const form = $(this);
                const action = form.attr('action');
                const email = form.find('input[name ="email"]').val();
                const password = form.find('input[name ="password"]').val();

                $.post(action, {email: email, password: password}, function (response) {
                    console.log(response);

                  

                    if (response.message) {
                        Toast.fire({
                            type: 'error',
                            title: response.message
                        })
                    }

                    if(response.redirect){
                        window.location.href = response.redirect
                    }
                }, 'json');

            });

        });

    </script>
@endsection
