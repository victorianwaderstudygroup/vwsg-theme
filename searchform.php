<form role="search" method="get" class="search-form" action="<?= site_url() ?>">
	<button class="search-collapse">
		<i class="fas fa-times"></i>
	</button>
    <label>
        <input type="search" class="search-field" value="<?= get_search_query() ?>" name="s"/>
    </label>
    <button class="search-submit">
        <i class="fas fa-search"></i>
    </button>
</form>