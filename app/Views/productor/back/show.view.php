<div class="card w-100 mb-3">
    <div class="card-header d-flex">
    <h4 class="card-title">Details la maison de production #<?= $productor['id_productor'] ?> - <?= $productor['productor_name'] ?></h4>
        <a href="/admin/productor/list" class="btn btn-primary ml-auto">
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
                    <label for="name">Nom</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= $productor['productor_name'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="id_country">Pays</label>
                    <input type="text" id="id_country" name="id_country" class="form-control" value="<?= $productor['iso'] ?> - <?= $productor['nicename'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" readonly rows="10"><?= $productor['description'] ?></textarea>
                </div>
            </form>
        </div>
    </div>
</div>