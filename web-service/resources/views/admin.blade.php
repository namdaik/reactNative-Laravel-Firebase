<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quick Order</title>
    <meta name="theme-color" content="#ffffff">
    <link href="{{ mix('css/admin/index.css') }}" type="text/css" rel="stylesheet" />
    <script defer src="{{ mix('js/admin/vendor.js') }}"></script>
    <script defer src="{{ mix('js/admin/manifest.js') }}"></script>
    <script defer src="{{ mix('js/admin/index.js') }}"></script>
</head>
<body>
<div id="app">
    <app></app>
</div>
</body>
</html>
