<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Nouvelle page</h4>
        <a href="/admin/page/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container mt-5">
        <div class="w-75">
            <form action="/admin/page/store" method="POST">
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
                    <label for="description">Description de la page</label>
                    <textarea id="description" name="description" class="form-control"><?= $old->description ?? '' ?></textarea>
                    <?php if (isset($errors['description'])) : ?>
                        <?php foreach ($errors['description'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="content">Contenu</label>
                    <textarea id="content" name="content" class="form-control"><?= $old->content ?? '' ?></textarea>
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
<script>
    document.getElementById('title').addEventListener('input', function() {
        var titleValue = this.value;
        var slugValue = generateSlug(titleValue);
        document.getElementById('slug').value = '/' + slugValue;
    });

    function generateSlug(title) {
        var slug = title.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-');
        return slug;
    }
</script>