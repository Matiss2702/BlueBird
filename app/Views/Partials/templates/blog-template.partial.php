<div class="container">
    <header class="mt-4 mb-4">
        <h1 class="text-center"><?= $headerTitle ?? 'Bienvenue sur notre site' ?></h1>
        <p class="text-center"><?= $headerDescription ?? 'Description de notre site' ?></p>
    </header>

    <main class="row">
        <article class="col-md-8">
            <h2><?= $mainTitle ?? 'Article principal' ?></h2>
            <p><?= $mainContent ?? 'Contenu de l\'article principal' ?></p>
        </article>

        <aside class="col-md-4">
            <h3><?= $sidebarTitle ?? 'Sidebar' ?></h3>
            <p><?= $sidebarContent ?? 'Contenu de la barre latérale' ?></p>
        </aside>
    </main>
</div>