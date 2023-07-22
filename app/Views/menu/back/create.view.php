<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Nouvel article</h4>
        <a href="/admin/menu/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container mt-5">
        <div class="w-75">
            <form action="/admin/menu/store" method="POST">
                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= $old->title ?? '' ?>">
                    <?php if (isset($errors['title'])) : ?>
                        <?php foreach ($errors['title'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="<?= $old->slug ?? '' ?>">
                    <?php if (isset($errors['slug'])) : ?>
                        <?php foreach ($errors['slug'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="orders">Orders</label>
                    <input type="number" id="orders" max="10" name="orders" class="form-control" value="<?= $old->orders ?? '' ?>">
                    <?php if (isset($errors['orders'])) : ?>
                        <?php foreach ($errors['orders'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="id_parent">Parent</label>
                    <input type="number" id="id_parent" name="id_parent" class="form-control" value="<?= $old->id_parent ?? '' ?>">
                    <?php if (isset($errors['id_parent'])) : ?>
                        <?php foreach ($errors['id_parent'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="status">Statut</label>
                    <select id="status" name="status" class="form-control">
                        <option value="0" <?= isset($old->status) && intval($old->status) === 0 ? 'selected' : '' ?>>Inactif</option>
                        <option value="1" <?= isset($old->status) && intval($old->status) === 1 ? 'selected' : '' ?>>Actif</option>
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
<script>
    // Écoute l'événement "input" du champ "title"
    document.getElementById('title').addEventListener('input', function() {
        var titleValue = this.value; // Récupère la valeur du champ "title"
        var slugValue = generateSlug(titleValue); // Génère le slug à partir du titre
        document.getElementById('slug').value = '/' + slugValue; // Ajoute le slash au début du slug
    });

    // Fonction pour générer le slug à partir du titre
    function generateSlug(title) {
        var slug = title.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-');
        return slug;
    }
</script>