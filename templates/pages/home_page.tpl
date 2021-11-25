<div class="container p-0">
  <h3 class="mb-4 mt-2">Latest posts</h3>
  <div class="row">
    <div class="col-md-9">
        {include file="../blocks/posts/card_view.tpl"}
    </div>

    <div class="col-md-3 nav-pills">
      {if $user}
        <a href="/{Blog\Destination::DESTINATION_NEW_POST}" class="btn btn-primary mb-4">Add new post</a>
      {/if}
      <h4 class="mb-4">Categories</h4>
      <nav class="nav flex-column">
        <a class="nav-link justify-content-between align-items-center d-flex active" aria-current="page" href="#">Fashion<span class="badge bg-primary rounded-pill">14</span></a>
        <hr class="mt-2 mb-2">
        <a class="nav-link justify-content-between align-items-center d-flex" href="#">Food <span class="badge bg-primary rounded-pill">14</span></a>
        <hr class="mt-2 mb-2">
        <a class="nav-link justify-content-between align-items-center d-flex" href="#">Travel</a>
        <hr class="mt-2 mb-2">
        <a class="nav-link justify-content-between align-items-center d-flex" href="#">Music</a>
        <hr class="mt-2 mb-2">
        <a class="nav-link justify-content-between align-items-center d-flex" href="#">Lifestyle</a>
        <hr class="mt-2 mb-2">
        <a class="nav-link justify-content-between align-items-center d-flex" href="#">Fitness</a>
        <hr class="mt-2 mb-2">
        <a class="nav-link justify-content-between align-items-center d-flex" href="#">Sport</a>
      </nav>
    </div>
  </div>
</div>