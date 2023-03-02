<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomads - @yield('title')</title>
    @stack('prepend-style')
    @include('includes.style')
    @stack('addon-style')

</head>
<body>
    @include('includes.navbar-alternate')

    @yield('content')

    @include('includes.footer')
    
    @include('includes.script')
    @stack('prepend-script')
    @stack('addon-script')
</body>

@push('prepend-style')
    <link rel="stylesheet" href="{{url('frontend/libraries/gijgo-master/dist/combined/css/gijgo.min.css')}}">
@endpush

</html>