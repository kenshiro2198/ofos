<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/6.5.95/css/materialdesignicons.min.css">
    <!-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> -->

    <title>G-District</title>
</head>

<body style="margin-bottom:0px!important">
    <div id="app"></div>
    <div id="snackbar"></div>
</body>
<script src="{{mix('js/main.js')}}"></script>

</html>
