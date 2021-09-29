<div class="row">
  {foreach $posts as $post}
    <div class="p3 col-md-4 mb-3">
      {if $post.image_path}
        <img src="{$post.image_path}" class="card-img-top" alt="..." width="300px" height="200px">
      {else}
        <img src="https://dummyimage.com/300x200/c0bfd6/2e2f3d&text=Dummy+image" class="card-img-top" alt="..." width="300px" height="200px">
      {/if}
      <div class="card-body bg-light">
        <h5 class="card-title text-black-50">{$post.title}</h5>
        <p class="card-text text-black">{$post.description}</p>
        <a href="/posts/{$post.url_key}" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  {/foreach}
</div>