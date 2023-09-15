<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Détails du Fichier #<?= $media->getId() ?></h4>
        <a href="/admin/media/list" class="btn btn-primary ml-auto">
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
                    <p>Appercu</p>
                    <div class="form-control">
                        <a href="<?= SITE_URL ?>/uploads<?= $media->getSlug() ?>" target="_blank" class="d-block">Cliquer pour voir le fichier</a>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= $media->getName() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="<?= $media->getSlug() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="alt">Texte Alternatif</label>
                    <input type="text" id="alt" name="alt" class="form-control" value="<?= $media->getAlt() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="created_at">Ajouté le</label>
                    <input type="text" id="created_at" name="created_at" class="form-control" value="<?= date('Y-m-d', strtotime($media->getCreatedAt())) ?>" readonly>
                </div>
            </form>
        </div>
    </div>
</div>