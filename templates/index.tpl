<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="/static/vendor/bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light text-dark">
<div class="container bg-white text-dark min-vh-100">
{include file="blocks/header.tpl"}
<main>
  {if $url == Blog\Destination::DESTINATION_HOME}
    {include file="pages/home_page.tpl"}
  {elseif $url == Blog\Destination::DESTINATION_ABOUT}
      {include file="pages/about_page.tpl"}
  {elseif $url == Blog\Destination::DESTINATION_POSTS}
      {include file="pages/post_page.tpl"}
  {elseif $url == Blog\Destination::DESTINATION_REGISTRATION}
      {include file="pages/registration_page.tpl"}
  {elseif $url == Blog\Destination::DESTINATION_LOGIN}
      {include file="pages/login_page.tpl"}
  {elseif $url == Blog\Destination::DESTINATION_PROFILE}
      {include file="pages/profile_page.tpl"}
  {elseif $url == Blog\Destination::DESTINATION_SEARCH}
      {include file="pages/search_page.tpl"}
  {else}
      {include file="pages/404.tpl"}
  {/if}
</main>

{include file="blocks/footer.tpl"}
</div>
<script src="/static/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/static/js/main.js"></script>
</body>
</html>