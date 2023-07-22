<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Modifier l'article #<?= $menu->getId() ?></h4>
        <a href="/admin/menu/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container mt-5">
        <div class="w-75">
            <form action="/admin/menu/update/<?= $menu->getId() ?>" method="POST">
                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= $old->title ?? $menu->getTitle() ?>">
                    <?php if (isset($errors['title'])) : ?>
                        <?php foreach ($errors['title'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="<?= $old->slug ?? $menu->getSlug() ?>">
                    <?php if (isset($errors['slug'])) : ?>
                        <?php foreach ($errors['slug'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="orders">Orders</label>
                    <input type="text" id="orders" name="orders" class="form-control" value="<?= $old->orders ?? $menu->getOrders() ?>">
                    <?php if (isset($errors['orders'])) : ?>
                        <?php foreach ($errors['orders'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="zone">Zone</label>
                    <select id="zone" name="zone" class="form-control">
                        <option value="0" <?= ($old['zone'] ?? !$menu->getZone()) ? 'selected' : '' ?>>Topbar</option>
                        <option value="1" <?= ($old['zone'] ?? $menu->getZone()) ? 'selected' : '' ?>>Sidebar</option>
                        <option value="2" <?= ($old['zone'] ?? $menu->getZone()) ? 'selected' : '' ?>>Footer</option>
                    </select>
                    <?php if (isset($errors['status'])) : ?>
                        <?php foreach ($errors['status'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="id_parent">Parent</label>
                    <input type="text" id="orders" name="id_parent" class="form-control" value="<?= $old->id_parent ?? $menu->getParent() ?>">
                    <?php if (isset($errors['id_parent'])) : ?>
                        <?php foreach ($errors['id_parent'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="status">Statut</label>
                    <select id="status" name="status" class="form-control">
                        <option value="0" <?= ($old['status'] ?? !$menu->getStatus()) ? 'selected' : '' ?>>Inactif</option>
                        <option value="1" <?= ($old['status'] ?? $menu->getStatus()) ? 'selected' : '' ?>>Actif</option>
                    </select>
                    <?php if (isset($errors['status'])) : ?>
                        <?php foreach ($errors['status'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>