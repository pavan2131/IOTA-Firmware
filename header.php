<?php
//include config.php globally
include __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= $title ?? 'Home' ?> | <?= config('app_name')?> </title>
    <link rel="stylesheet" href="<?= config('app_url')?>/assets/css/win-ui.css">
    <link rel="stylesheet" href="<?= config('app_url')?>/assets/css/win-home.css">
    <link rel="stylesheet" href="<?= config('app_url')?>/assets/css/app-config.css">
    <link rel="stylesheet" href="<?= config('app_url')?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= config('app_url')?>/assets/icons/winui-icons.min.css">
    <link rel="stylesheet" href="<?= config('app_url')?>/assets/icons/winui-icons.slim.css">
    <script src="https://www.gstatic.com/firebasejs/8.8.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.8.0/firebase-database.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.8.0/firebase-storage.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
  <script src="https://cdn.plot.ly/plotly-2.20.0.min.js" charset="utf-8"></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="<?= config('app_url')?>/assets/js/bootstrap.js" defer></script>
    <script src="<?= config('app_url')?>/assets/js/win-ui.js" defer></script>
    <style>
           .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 999999;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        a{
            text-decoration: none;
        }
    </style>
</head>
<body>
    
<div id="preloader" class="preloader">

<div class="app-loader-busy loader-lg animate"></div>
</div>
<script>
      $(window).on('load', function () {
        $('.preloader').fadeOut(1000);
    });
</script>

