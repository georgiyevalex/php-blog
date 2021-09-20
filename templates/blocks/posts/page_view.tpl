<div class="card mb-3">
  {if $post.image_path}
    <img src="{$post.image_path}" class="card-img-top img-fluid" alt="...">
  {else}
    <img src="https://dummyimage.com/1320x400/c0bfd6/2e2f3d&text=Dummy+image" class="card-img-top img-fluid" alt="...">
  {/if}
  <div class="card-body">
    <h1 class="card-title text-dark">{$post.title}</h1>
    <p class="card-text text-dark">{$post.content}</p>
    <p class="card-text"><small class="text-muted">{$post.published_date|date_format:"F d, Y"}</small></p>
  </div>
</div>