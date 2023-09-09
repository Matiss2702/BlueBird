<div id="content-wrapper" class="container-fluid">
    <?php if ($movies) : ?>
        <div class="row">
            <h1 class="h1">Tous les films de la catégorie : <?=strtoupper($categoryMovie['name'])?></h1>
        </div>
        <section class="row">
            <?php foreach ($movies as $movie) : ?>
                <?php $movieLink = strtolower(str_replace(" ", "-", $movie['title'])); ?>
                <a href="/movie/<?=$movieLink?>" class="col-md-4 col-sm-6 col-12">
                    <div class="p-4"></div>
                    <h2 class="h4"><?=$movie['title']?></h2>
                    <div class="p-4"></div>
                </a>
            <?php endforeach ?>
        </section>
    <?php else :?>
        <section class="row">
            <h1 class="h1 alert alert-danger">Aucun film pour la catégorie : <?=strtoupper($categoryMovie['name'])?></h1>
        </section>
    <?php endif ; ?>
</div>