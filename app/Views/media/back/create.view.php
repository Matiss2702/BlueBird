<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Nouveau Fichier</h4>
        <a href="/admin/media/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container mt-5">
        <div class="w-75">
            <form action="/admin/media/store" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="file">Sélectionnez un fichier :</label>
                    <input type="file" name="file" id="file" accept=".jpg, .png, .jpeg, .pdf, .mp4" class="form-control" required>
                    <?php if(isset($errors['file'])): ?>
                        <?php foreach($errors['file'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="name">Nom du fichier ou <b>Title</b></label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= $old->name ?? '' ?>">
                    <?php if(isset($errors['name'])): ?>
                        <?php foreach($errors['name'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="<?= $old->slug ?? '' ?>">
                    <?php if(isset($errors['slug'])): ?>
                        <?php foreach($errors['slug'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="alt">Attribut <b>Alt</b></label>
                    <input type="text" id="alt" name="alt" class="form-control" value="<?= $old->alt ?? '' ?>">
                    <?php if(isset($errors['alt'])): ?>
                        <?php foreach($errors['alt'] as $error): ?>
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
    document.getElementById('name').addEventListener('input', function() {
        var nameValue = this.value;
        var slugValue = generateSlug(nameValue);
        document.getElementById('slug').value = '/' + slugValue;
    });

    function generateSlug(name) {
        var slug = name.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-');
        return slug;
    }
</script>