<?php foreach ($movies as $movie) : ?>
    <div class="col-md-4 col-sm-6 col-12">
        <a href="/movie/<?= strtolower(str_replace(' ', '-', $movie['title'])) ?>" class="text-decoration-none">
            <img src="/uploads<?= $movie['slug'] ?>" alt="<?= $movie['alt'] ?>" class="movie-poster">
        </a>
        <a href="/movie/<?= strtolower(str_replace(' ', '-', $movie['title'])) ?>" class="text-decoration-none">
            <h3 class="h4"><?= $movie['title'] ?></h3>
        </a>

        <?php foreach ($movie['categories'] as $category) : ?>
            <span class="badge badge-primary"><?= $category ?></span>
        <?php endforeach; ?>
    </div>
<?php endforeach;?>