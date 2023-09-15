<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Détails de l'article #<?= $post->getId() ?></h4>
        <a href="/admin/post/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container mt-5">
        <div class="w-75">
            <form>
                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= $post->getTitle() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="content">Contenu</label>
                    <textarea id="content" name="content" class="form-control" readonly><?= $post->getContent() ?></textarea>
                </div>
            </form>
        </div>
    </div>
</div>
