<form action="/movie/q/" method="GET">
    <div class="form-group">
        <label for="movie_name" class="h5">Film</label>
        <input type="text" name="movie_name" id="movie_name" class="form-control" required value="<?= isset($_GET['movie_name']) ? $_GET['movie_name'] : '' ?>">
    </div>
    <button type="submit" class="btn btn-primary">Rechercher</button>
    <?php if (isset($_GET['movie_name'])) : ?>
        <br>
        <a href="/movie">Réinitialiser</a>
    <?php endif;?>
</form>