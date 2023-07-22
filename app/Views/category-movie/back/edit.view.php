<div class="card w-100">
    <div class="card-header d-flex">
        <h4 class="card-title">Modifier la catégorie de film #<?= $categoryMovie->getId() ?> - <?= $categoryMovie->getName() ?></h4>
        <a href="/admin/category-movie/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container my-4">
        <div class="w-100">
            <form action="/admin/category-movie/update/<?= $categoryMovie->getId() ?>" method="POST">
                <div class="form-group">
                    <label for="name">Titre</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= $old->name ?? $categoryMovie->getName()?>" required>
                    <?php if(isset($errors['name'])): ?>
                        <?php foreach($errors['name'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>