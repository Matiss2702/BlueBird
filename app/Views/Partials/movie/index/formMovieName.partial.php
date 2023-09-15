<form action="/movie/q/" method="GET">
    <div class="form-group">
        <label for="movie" class="h5">Film</label>
        <input type="text" name="movie" id="movie" class="form-control" required value="<?= isset($_GET['movie']) ? $_GET['movie'] : '' ?>">
    </div>
    <button type="submit" class="btn btn-primary">Rechercher</button>
    <?php if (isset($_GET['movie'])) : ?>
        <br>
        <a href="/movie">Réinitialiser</a>
    <?php endif;?>
</form>