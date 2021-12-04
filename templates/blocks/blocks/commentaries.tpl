<div class="coment-bottom bg-white">
    <form class="d-flex flex-row add-comment-section mt-4 mb-4" action="/create-comment" method="post" >
        <textarea class="form-control me-3" placeholder="Add comment"></textarea>
        <button class="btn btn-primary" type="button" style="max-height: 62px">Comment</button>
    </form>
    {if $commentaries}
        {foreach $commentaries as $commentary}
            <div class="commented-section mt-2 mb-3">
                <div class="d-flex flex-row align-items-center commented-user">
                    <h5 class="me-3">{$commentary.user_id}</h5>
                    <div class="mb-1 ml-2">{$commentary.published_date}</div>
                </div>
                <div class="comment-text-sm"><span>{$commentary.comment}</span></div>
            </div>
        {/foreach}
    {/if}
</div>