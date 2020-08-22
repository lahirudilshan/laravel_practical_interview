<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>ZinCat Feedback System</title>
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
        @yield('css')
    </head>
    <body class="bg-gray">
        <div class="container h-100">
            @yield('content')
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
        @yield('js')
    </body>
    <script>
        $(document).ready(function(){
            $('#submit_button').click(function(){
                $('.spinner-border').removeClass('d-none');
                $('i').addClass('d-none');
                
                setTimeout(() => {
                    $(this).prop('disabled', true);
                }, 200);
            });
        });
    </script>
</html>
