<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
          content="">
    <meta name="author"
          content="">

    <meta name="theme-color" content="#343a40">

    <title>{{$role->name}} ({{$role->real_name}})</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
          crossorigin="anonymous">

</head>

<body>

<div id="app">
    <role-dashboard :role="{{$role}}"></role-dashboard>
</div>

<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
