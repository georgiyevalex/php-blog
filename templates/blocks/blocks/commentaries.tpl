<div class="coment-bottom bg-white">
    {if $message}
        <div class="alert alert-danger" role="alert">
            {$message}
        </div>
    {/if}
    {if $user}
        <form class="d-flex flex-row add-comment-section mt-4 mb-4" action="/{Blog\CreateDestination::DESTINATION_ADD_COMMENT}" method="post" name="add_comment-form">
            <textarea class="form-control me-3" placeholder="Add comment" name="comment"></textarea>
            <input type="hidden" name="post_id" value="{$post.post_id}">
            <input type="hidden" name="url_key" value="{$post.url_key}">
            <button class="btn btn-primary" type="submit" style="max-height: 62px">Comment</button>
        </form>
    {/if}
    {if $commentaries}
        {foreach $commentaries as $commentary}
            <div class="commented-section mt-2 mb-3">
                <div class="d-flex flex-row align-items-center commented-user">
                    <h5 class="me-3">{$commentary.user}</h5>
                    <div class="mb-1 ml-2">{$commentary.published_date}</div>
                </div>
                <div class="comment-text-sm"><span>{$commentary.comment}</span></div>
            </div>
        {/foreach}
    {/if}
</div>