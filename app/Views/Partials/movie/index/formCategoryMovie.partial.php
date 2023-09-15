<form action="/movie/q/" method="GET">
    <div class="form-group">
        <label for="category_movie" class="h5">Catégories</label>
        <div class="d-flex flex-column">
            <?php foreach ($categories as $category) : ?>
                <label for="<?= $category['id'] ?>">
                    <input 
                        type="radio" 
                        name="category" 
                        id="<?= $category['id'] ?>" 
                        value="<?= $category['id'] ?>"
                        <?= isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'checked' : ''; ?>
                    >
                    <span><?=$category['name']?></span>
                </label>
            <?php endforeach;?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Filtrer</button>
    <?php if (isset($_GET['category'])) : ?>
        <br><br>
        <a href="/movie">Réinitialiser</a>
    <?php endif;?>
</form>