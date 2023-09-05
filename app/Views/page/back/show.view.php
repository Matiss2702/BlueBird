<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Détails de la page #<?= $page->getId() ?></h4>
        <a href="/admin/page/list" class="btn btn-primary ml-auto">
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
                    <input type="text" id="title" name="title" class="form-control" value="<?= $page->getTitle() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="<?= $page->getSlug() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" class="form-control" value="<?= $page->getDescription() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="content">Contenu</label>
                    <div class="form-control w-100 h-100" style="background-color: #eaecf4;opacity: 1;"><?= $page->getContent() ?></div>
                </div>
            </form>
        </div>
    </div>
</div>
