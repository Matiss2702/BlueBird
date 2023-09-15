<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="bg-white">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h1 class="h1 font-weight-bold text-primary">Toutes nos catégories</h1>
            </div>
            <div class="container-fluid py-4">
                <ul class="list-group">
                    <?php foreach ($categories as $category) : ?>
                        <li class="list-group-item">
                            <a href="/category/<?= strtolower(str_replace(' ', '-', $category->name)) ?>" class="text-primary text-decoration-none">
                                <?= $category->name ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>