<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>500 Internal Server Error</title>
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/css/error.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/fontawesome/css/all.min.css') }}">
    <script src="{{ asset('vendor/my-blog/assets/jquery/jquery.min.js') }}"></script>

</head>

<body>
    <div id="notFound">
        <div class="notFound">
            <div class="notFound_404">
                <h1>500</h1>
            </div>
            <h2>Internal Server Error</h2>
            <p>
                Sorry! Something went wrong on our server, please try again later.
            </p>
            <a class="buttonError" onClick="window.location.reload()" id="refreshpage">Refresh</a>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#refreshpage').on('click', function(e) {
                e.preventDefault();

                $.ajax({
                    beforeSend: function() {
                        $('.buttonError').attr('disable', 'disable');
                        $('.buttonError').html('<i class="fa fa-spin fa-spinner"></i>')
                    },
                });
            })
        });
    </script>
</body>

</html>
