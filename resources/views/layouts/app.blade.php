
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('components.link')

    <title>@yield('title')</title>
</head>

<body>
    @include('components.navbar')
    @yield('content')

    @include('components.script')
</body>

</html>
