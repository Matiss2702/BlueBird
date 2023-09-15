<article>
    <div class="row">
        <div class="col-lg-4">
            <figure class="mb-4">
                <img src="/uploads<?= $movie['slug'] ?>" alt="<?= $movie['alt'] ?>" class="movie-poster-large">
            </figure>
        </div>
        <div class="col-lg-8">
            <section class="mb-5">
                <h1 class="font-weight-bold text-dark mb-1"><?= ucfirst($movie['title']) ?></h1>
                <div class="text-muted fst-italic mb-2">Date de sortie : <?= $release_date ?> - Durée : <?= $movie_duration ?></div>
                <?php foreach($categoriesMovie as $categoryMovie): ?>
                    <?php if (in_array($categoryMovie->id, $movieCategoriesMovie)): ?>
                        <a class="badge bg-secondary text-decoration-none link-light text-white" href="/category/<?= strtolower($categoryMovie->name) ?>"><?= $categoryMovie->name ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
                <h2 class="h6 mt-4">Synopsis</h2>
                <p class="synopsis-text"><?= $movie['description'] ?></p>
                <div class="row">
                    <div class="col-6"><button type="button" class="btn btn-primary w-100">Bande-annonce</button></div>
                    <div class="col-6"><button type="button" class="btn btn-primary w-100">Voir le film</button></div>
                </div>
            </section>
        </div>
    </div>
</article>