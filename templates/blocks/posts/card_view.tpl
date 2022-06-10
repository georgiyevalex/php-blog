<div class="row">
  {foreach $posts as $post}
    <div class="p3 {if $url==Blog\Destination::DESTINATION_SEARCH}col-md-3{else}col-md-4{/if} mb-4">
      {if $post.image_path}
        <img src="/{$post.image_path}" class="card-img-top" alt="..." width="300" height="200">
      {else}
        <img src="https://dummyimage.com/300x200/c0bfd6/2e2f3d&text=Dummy+image" class="card-img-top" alt="..." width="300px" height="200px">
      {/if}
      <div class="card-body bg-light match-height d-flex flex-column justify-content-between">
        <div class="card-top-part mb-4">
          <h5 class="card-title text-black-50">{$post.title|ucfirst|escape}</h5>
          <p class="card-text text-black">{$post.description|ucfirst|escape}</p>
        </div>
        <div class="card-bot-part d-flex align-items-center justify-content-between">
          <a href="/posts/{$post.url_key}" class="btn btn-primary">Go somewhere</a>
          <p class="card-text"><small class="text-muted">{$post.published_date|date_format:"F d, Y"|escape}</small></p>
        </div>
      </div>
    </div>
  {/foreach}
</div>
