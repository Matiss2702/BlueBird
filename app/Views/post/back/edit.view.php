<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Modifier l'article #<?= $post->getId() ?></h4>
        <a href="/admin/post/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container mt-5">
        <div class="w-75">
            <form action="/admin/post/update/<?= $post->getId() ?>" method="POST">
                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= $old->title ?? $post->getTitle() ?>">
                    <?php if(isset($errors['title'])): ?>
                        <?php foreach($errors['title'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="content">Contenu</label>
                    <textarea id="content" name="content" class="form-control"><?= $old->content ?? $post->getContent() ?></textarea>
                    <?php if(isset($errors['content'])): ?>
                        <?php foreach($errors['content'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>
