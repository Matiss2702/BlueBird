<?php foreach ($movies as $movie) : ?>
    <?php $movieLink = strtolower(str_replace(" ", "-", $movie->title)); ?>
    <a href="/movie/<?= $movieLink?>"class="col-md-4 col-sm-6 col-12">
        <div class="p-4"></div>
        <h2 class="h4"><?= $movie->title; ?></h2>
        <div class="p-4"></div>
    </a>
<?php endforeach;?>