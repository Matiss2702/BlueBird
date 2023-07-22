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
                    <label for="header_title">Titre d'en-tête</label>
                    <textarea id="header_title" name="header_title" class="form-control"><?= $old->header_title ?? '' ?></textarea>
                    <?php if (isset($errors['header_title'])) : ?>
                        <?php foreach ($errors['header_title'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="header_description">Description d'en-tête</label>
                    <textarea id="header_description" name="header_description" class="form-control"><?= $old->header_description ?? '' ?></textarea>
                    <?php if (isset($errors['header_description'])) : ?>
                        <?php foreach ($errors['header_description'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="main_title">Titre principal</label>
                    <textarea id="main_title" name="main_title" class="form-control"><?= $old->main_title ?? '' ?></textarea>
                    <?php if (isset($errors['main_title'])) : ?>
                        <?php foreach ($errors['main_title'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="main_content">Contenu principal</label>
                    <textarea id="main_content" name="main_content" class="form-control"><?= $old->main_content ?? '' ?></textarea>
                    <?php if (isset($errors['main_content'])) : ?>
                        <?php foreach ($errors['main_content'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="sidebar_title">Titre de la barre latérale</label>
                    <textarea id="sidebar_title" name="sidebar_title" class="form-control"><?= $old->sidebar_title ?? '' ?></textarea>
                    <?php if (isset($errors['sidebar_title'])) : ?>
                        <?php foreach ($errors['sidebar_title'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="sidebar_content">Contenu de la barre latérale</label>
                    <textarea id="sidebar_content" name="sidebar_content" class="form-control"><?= $old->sidebar_content ?? '' ?></textarea>
                    <?php if (isset($errors['sidebar_content'])) : ?>
                        <?php foreach ($errors['sidebar_content'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.tiny.cloud/1/fuvwzdwd88rngedna4ks4mrc13wcqg32i3kl2z4qqu2oyoeo/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: 'textarea'
    });
</script>