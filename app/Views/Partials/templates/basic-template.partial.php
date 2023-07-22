<div class="container">
    <header class="mt-4 mb-4">
        <h1 class="text-center"><?= $headerTitle ?? 'Bienvenue sur notre blog' ?></h1>
        <p class="text-center"><?= $headerDescription ?? 'Ici, nous partageons nos pensées et nos idées.' ?></p>
    </header>

    <main>
        <?php foreach ($blogPosts ?? [] as $post) : ?>
            <article class="mb-4">
                <h2><?= $post['title'] ?? 'Titre de l\'article' ?></h2>
                <p><?= $post['content'] ?? 'Contenu de l\'article' ?></p>
            </article>
        <?php endforeach; ?>
    </main>
</div>