{foreach $posts as $post}
  <div class="card mb-5" style="width: 18rem;">
    <img src="https://dummyimage.com/300x200/c0bfd6/2e2f3d&text=Dummy+image" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title text-black-50">{$post.title}</h5>
      <p class="card-text text-black">{$post.description}</p>
      <a href="{$post.url_key}" class="btn btn-primary">Go somewhere</a>
    </div>
  </div>
{/foreach}