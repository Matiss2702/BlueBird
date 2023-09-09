<form action="/movie/q/" method="GET">
    <div class="form-group">
        <label for="category_movie" class="h5">Catégories</label>
        <div class="d-flex flex-column">
            <?php foreach ($categoriesMovie as $categoryMovie) : ?>
                <label for="<?=strtolower($categoryMovie['name'])?>">
                    <input 
                        type="radio" 
                        name="category_movie" 
                        id="<?=strtolower($categoryMovie['name'])?>" 
                        value="<?=strtolower($categoryMovie['name'])?>"
                        <?= isset($_GET['category_movie']) && $_GET['category_movie'] == strtolower($categoryMovie['name']) ? 'checked' : ''; ?>
                    >
                    <span><?=$categoryMovie['name']?></span>
                </label>
            <?php endforeach;?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Filtrer</button>
    <?php if (isset($_GET['category_movie'])) : ?>
        <br><br>
        <a href="/movie">Réinitialiser</a>
    <?php endif;?>
</form>