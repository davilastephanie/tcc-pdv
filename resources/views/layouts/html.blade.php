<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>

    <link rel="apple-touch-icon" sizes="60x60" href="{{ url('/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ url('/favicon/site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#321fdb">
    <meta name="theme-color" content="#321fdb">

    <link href="{{ asset('/coreui/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/coreui/vendors/@coreui/icons/css/free.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendors/datepicker/datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendors/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendors/select2/select2-bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendors/noty/noty.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendors/jquery-confirm/jquery-confirm.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendors/fancybox/jquery.fancybox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/vendors/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/dist/app.css') }}?t={{ filemtime(public_path('/dist/app.css')) }}" rel="stylesheet">
    @stack('style')
</head>
<body class="@yield('bodyClass')">

@yield('body')
@stack('modal')

<script src="{{ asset('/coreui/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
<script src="{{ asset('/coreui/vendors/@coreui/icons/js/svgxuse.min.js') }}"></script>
<script src="{{ asset('/vendors/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('/vendors/bootstrap-4.5.0.bundle.min.js') }}"></script>
<script src="{{ asset('/vendors/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/vendors/jquery.mask.min.js') }}"></script>
<script src="{{ asset('/vendors/jquery.maskMoney.min.js') }}"></script>
<script src="{{ asset('/vendors/jquery.blockUI.js') }}"></script>
<script src="{{ asset('/vendors/jquery.form.min.js') }}"></script>
<script src="{{ asset('/vendors/datepicker/datepicker.min.js') }}"></script>
<script src="{{ asset('/vendors/datepicker/i18n/datepicker.pt-BR.js') }}"></script>
<script src="{{ asset('/vendors/select2/select2.min.js') }}"></script>
<script src="{{ asset('/vendors/select2/select2.pt-BR.js') }}"></script>
<script src="{{ asset('/vendors/noty/noty.min.js') }}"></script>
<script src="{{ asset('/vendors/jquery-confirm/jquery-confirm.min.js') }}"></script>
<script src="{{ asset('/vendors/fancybox/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('/vendors/jquery-ui/jquery-ui.widget.js') }}"></script>
<script src="{{ asset('/vendors/jquery-file-upload/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('/vendors/jquery-file-upload/jquery.fileupload.js') }}"></script>
<script src="{{ asset('/dist/app.js') }}?t={{ filemtime(public_path('/dist/app.js')) }}"></script>
@stack('script')

<script>
    window.APP_URL = '{{ env('APP_URL') }}';
</script>

@if (session('status') || $errors->any())
    <script>
        var status = '{{ session('status') }}';
        var errors = @json($errors->all());

        $(function() {
            if (status.length > 0) {
                $.notification(status, 'success');
            } else {
                $.notification('Verifique as mensagens e tente novamente.', 'error');
            }
        });

        if (errors) {
            console.log('errors:', errors);
        }
    </script>
@endif
</body>
</html>