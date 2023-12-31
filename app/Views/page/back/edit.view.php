<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Modifier la page #<?= $page->getId() ?></h4>
        <a href="/admin/page/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container mt-5">
        <div class="w-75">
            <form action="/admin/page/update/<?= $page->getId() ?>" method="POST">
                <div class="form-group">
                    <label for="title">Préremplir à partir d'une version antérieure</label>
                    <select id="versions" class="form-control">
                        <option value="">Aucune</option>
                        <?php foreach ($versions as $version) : ?>
                            <option value="<?= $version['id'] ?>" data-version-data='<?= json_encode($version) ?>'>
                                <?= $version['title'] . ' - ' . date('d/m/Y H:i:s', strtotime($version['created_at'])) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="isHome">Page d'accueil</label>
                    <select id="is_home" name="is_home" class="form-control">
                        <option value="0" <?= ($old['is_home'] ?? !$page->getIsHome()) ? 'selected' : '' ?>>Non</option>
                        <option value="1" <?= ($old['is_home'] ?? $page->getIsHome()) ? 'selected' : '' ?>>Oui</option>
                    </select>
                    <?php if (isset($errors['isHome'])) : ?>
                        <?php foreach ($errors['isHome'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= $old->title ?? $page->getTitle() ?>">
                    <?php if (isset($errors['title'])) : ?>
                        <?php foreach ($errors['title'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="<?= $old->slug ?? $page->getSlug() ?>">
                    <?php if (isset($errors['slug'])) : ?>
                        <?php foreach ($errors['slug'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" class="form-control" value="<?= $old->description ?? $page->getDescription() ?>">
                    <?php if (isset($errors['description'])) : ?>
                        <?php foreach ($errors['description'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="content">Contenu</label>
                    <textarea id="content" name="content" class="form-control"><?= $old->content ?? $page->getContent() ?></textarea>
                    <?php if (isset($errors['content'])) : ?>
                        <?php foreach ($errors['content'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>