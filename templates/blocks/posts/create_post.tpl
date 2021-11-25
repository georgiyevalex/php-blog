{if $message}
    <div class="alert alert-danger" role="alert">
        {$message}
    </div>
{/if}
<form action="/{Blog\Destination::DESTINATION_CREATE_POST}" class="col g-3 needs-validation" method="post" name="form">
    <div class="col-md-6 mt-2">
        <label for="post_title" class="form-label">Title</label>
        <input type="text" class="form-control" placeholder="Enter title" id="post_title" name="title" value="{$post.title}">
    </div>
    <div class="col-md-6 mt-3">
        <label for="post_content" class="form-label">Content</label>
        <textarea class="form-control" name="content" id="post_content">{$post.content}</textarea>
    </div>
    <div class="col-md-6 mt-3">
        <label for="post_description" class="form-label">Description</label>
        <textarea class="form-control" name="description" id="post_description">{$post.description}</textarea>
    </div>
    <div class="col-md-6 mt-2">
        <label for="url_key" class="form-label">url_key</label>
        <input type="text" class="form-control" placeholder="url-key-for-the-post" id="url_key" name="url_key" value="{$post.url_key}">
    </div>
    <div class="col-12 mt-5">
        <input class="btn btn-primary" type="submit" value="Submit form">
    </div>
</form>