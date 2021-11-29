{if $pagination.paging > 1}
    <nav aria-label="...">
        <ul class="pagination">
            <li class="page-item {if $pagination.current <= 1}disabled{/if}">
                <a class="page-link" href="?page={$pagination.current - 1}">Previous</a>
            </li>
            {section name=pagination start=0 loop=$pagination.paging step=1}
                {if $smarty.section.pagination.iteration == $pagination.current}
                    <li class="page-item active" aria-current="page">
                        <span class="page-link">{$smarty.section.pagination.iteration}</span>
                    </li>
                {else}
                    <li class="page-item">
                        <a class="page-link" href="?page={$smarty.section.pagination.iteration}">{$smarty.section.pagination.iteration}</a>
                    </li>
                {/if}
            {/section}
            <li class="page-item {if $pagination.current >= $pagination.paging}disabled{/if}">
                <a class="page-link" href="?page={$pagination.current + 1}">Next</a>
            </li>
        </ul>
    </nav>
{/if}