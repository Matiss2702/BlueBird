<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Détails de la notation #<?= $review['id'] ?></h4>
        <div class="ml-auto">
            <a href="/admin/review/edit/<?= $review['id'] ?>" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-edit"></i>
                </span>
                <span class="text">Modifier l'élément</span>
            </a>
            <a href="/admin/review/list" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-arrow-left"></i>
                </span>
                <span class="text">Revenir à la liste</span>
            </a>
        </div>
    </div>
    <div class="container mt-5">
        <div class="w-75">
            <form>
                <div class="form-group">
                    <label for="id_user">Auteur</label>
                    <input type="text" id="id_user" name="id_user" class="form-control" value="<?= $review['lastname'] . ' ' . $review['firstname'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="id_movie">Film</label>
                    <input type="text" id="id_movie" name="id_movie" class="form-control" value="<?= $review['title'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="rate">Note</label>
                    <div>
                        <i class="fa fa-star <?= $review['rate'] >= 1 ? 'text-warning' : '' ?>"></i>
                        <i class="fa fa-star <?= $review['rate'] >= 2 ? 'text-warning' : '' ?>"></i>
                        <i class="fa fa-star <?= $review['rate'] >= 3 ? 'text-warning' : '' ?>"></i>
                        <i class="fa fa-star <?= $review['rate'] >= 4 ? 'text-warning' : '' ?>"></i>
                        <i class="fa fa-star <?= $review['rate'] >= 5 ? 'text-warning' : '' ?>"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="comment">Critique</label>
                    <textarea id="comment" name="comment" class="form-control" rows="12" readonly><?= $review['comment'] ?></textarea>
                </div>
            </form>
        </div>
    </div>
</div>