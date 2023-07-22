<article>
    <header class="mb-4">
        <h1 class="font-weight-bold text-dark mb-1"><?= $movie->getTitle() ?></h1>
        <div class="text-muted fst-italic mb-2">Date de sortie : <?= $movie->getFormattedReleaseDate() ?> - Durée : <?= $movie->getFormattedDuration() ?></div>
        <?php foreach($categoriesMovie as $categoryMovie): ?>
            <?php if (in_array($categoryMovie->id, $movieCategoriesMovie)): ?>
                <a class="badge bg-secondary text-decoration-none link-light text-white" href="#!"><?= $categoryMovie->name ?></a>
            <?php endif; ?>
        <?php endforeach; ?>
    </header>
    <div class="row">
        <div class="col-lg-4">
            <figure class="mb-4">
                <img class="img-fluid rounded" src="assets/img/poster.jpg" />
            </figure>
        </div>
        <div class="col-lg-8">
            <section class="mb-5">
                <ul class="list-unstyled">
                    <li>
                        <span class="font-weight-bold">Réalisateur :</span>
                        <span>Makoto Shinkai</span>
                    </li>
                    <li>
                        <span class="font-weight-bold">Avec :</span>
                        <span>Yoann Borg, Ryûnosuke Kamiki, Alice Orsat</span>
                    </li>
                </ul>
                <p class="synopsis-text"><?= $movie->getDescription() ?></p>
                <div class="row">
                    <div class="col-6"><button type="button" class="btn btn-primary w-100">Bande-annonce</button></div>
                    <div class="col-6"><button type="button" class="btn btn-primary w-100">Voir le film</button></div>
                </div>
            </section>
        </div>
    </div>
</article>