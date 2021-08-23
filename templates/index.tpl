<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="static/vendor/bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-dark text-white">
<div class="container position-relative">
{include file="blocks/header/index.tpl"}

{if $url == Blog\Destination::DESTINATION_HOME}
  {include file="pages/home/index.tpl"}
{elseif $url == Blog\Destination::DESTINATION_ABOUT}
    {include file="pages/about/index.tpl"}
{elseif $url == Blog\Destination::DESTINATION_POSTS}
    {include file="pages/posts/index.tpl"}
{else}
    {include file="pages/404/index.tpl"}
{/if}

{include file="blocks/footer/index.tpl"}
</div>
<script src="static/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>