<html>
<head>
    <title> @yield('title') </title>
    
    <link rel="stylesheet" href="/css/bootstrap.min.css" >
    <link rel="stylesheet" href="/css/bootstrap-theme.min.css">

    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
</head>
<body>

@include('shared.navbar')

@yield('content')

</body>
</html>
