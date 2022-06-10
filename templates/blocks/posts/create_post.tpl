{if $message}
    <div class="alert alert-danger" role="alert">
        {$message}
    </div>
{/if}
<form action="/{Blog\CreateDestination::DESTINATION_CREATE_POST}" class="col g-3 needs-validation" method="post" enctype="multipart/form-data" name="create_post-form">
    <div class="col-md-6 mt-2">
        <label for="post_title" class="form-label">Title</label>
        <input type="text" class="form-control" placeholder="Enter title" id="post_title" name="title" value="{$post.title|escape}">
    </div>
    <div class="col-md-6 mt-3">
        <label for="post_content" class="form-label">Content</label>
        <textarea class="form-control" name="content" id="post_content">{$post.content|escape}</textarea>
    </div>
    <div class="col-md-6 mt-3">
        <label for="post_description" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="post_description">{$post.description|escape}</textarea>
    </div>
    <div class="col-md-6 mt-2">
        <label for="image_path" class="form-label">Image</label>
        <input type="file" class="form-control" id="image_path" name="image_path" value="{$post.image_path|escape}">
    </div>
    <div class="col-md-6 mt-2">
        <label for="category" class="form-label">Category</label>
        <select class="form-select" aria-label="Default select example" name="category">
            {foreach $categories as $category}
                <option value="{$category.category_id}">{$category.category_name|escape}</option>
            {/foreach}
        </select>
    </div>
    <div class="col-md-6 mt-2">
        <label for="url_key" class="form-label">url_key</label>
        <input type="text" class="form-control" placeholder="url-key-for-the-post" id="url_key" name="url_key" value="{$post.url_key}">
    </div>
    <div class="col-12 mt-5">
        <input class="btn btn-primary" type="submit" value="Submit form">
    </div>
</form>
