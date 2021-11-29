<div class="container p-0">
  <h3 class="mb-4 mt-2">Latest posts{if $category_page} in category "{$current_category}"{/if}</h3>
  <div class="row">
    <div class="col-md-9">
        {include file="../blocks/posts/card_view.tpl"}
        {include file="../blocks/blocks/pagination.tpl"}
    </div>

    <div class="col-md-3 nav-pills">
      {if $user}
        <a href="/{Blog\Destination::DESTINATION_NEW_POST}" class="btn btn-primary mb-4">Add new post</a>
      {/if}

      {if $categories}
        <h4 class="mb-4">Categories</h4>
        <nav class="nav flex-column">
          <a class="nav-link justify-content-between align-items-center d-flex{if $main_page} active{/if}" aria-current="page" href="/">All</a>
            <hr class="mt-2 mb-2">

          {foreach $categories as $category}
            <a class="nav-link justify-content-between align-items-center d-flex{if $category.category_name == $current_category} active{/if}" aria-current="page" href="/categories/{$category.category_name}">{$category.category_name|ucfirst}</a>
            {if !$category@last}
              <hr class="mt-2 mb-2">
            {/if}
          {/foreach}
        </nav>
      {/if}
    </div>
  </div>
</div>