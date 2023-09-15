<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Détails du commentaire #<?= $comment['comment_id'] ?></h4>
        <a href="/admin/comment-reply/list" class="btn btn-primary ml-auto">
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
                    <label for="object">Utilisateur</label>
                    <input type="text" class="form-control" value="<?= ucfirst(strtolower($comment['comment_firstname'])) . ' ' . strtoupper($comment['comment_lastname']) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="message">Commentaire</label>
                    <textarea class="form-control" readonly><?= $comment['comment_content'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="firstname">Statut</label>
                    <input class="form-control" readonly value="<?= $comment['comment_status'] ?>">
                </div>
                <div class="form-group">
                    <label for="lastname">Date</label>
                    <input class="form-control" readonly value="<?= date('d F Y - H:i:s', strtotime($comment['comment_date'])) ?>">
                </div>
            </form>
        </div>
        <div class="w-75 mt-5">
            <hr>
            <h4 class="text-center">En réponse au commentaire ci-dessous :</h4>
                <div class="d-flex justify-content-center">
                    <a href="/admin/comment/show/<?= $comment['parent_id'] ?>" class="btn btn-secondary btn-sm mr-2"><i class="fa fa-eye"></i></a>
                    <a href="/admin/comment/edit/<?= $comment['parent_id'] ?>" class="btn btn-primary btn-sm mr-2"><i class="fa fa-edit"></i></a>
                </div>
            <form>
                <div class="form-group">
                    <label for="user">Utilisateur</label>
                    <input type="text" class="form-control" value="<?= ucfirst(strtolower($comment['parent_firstname'])) . ' ' . strtoupper($comment['parent_lastname']) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="comment">Commentaire</label>
                    <textarea class="form-control" readonly><?= $comment['parent_content'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Statut</label>
                    <input class="form-control" readonly value="<?= $comment['parent_status'] ?>">
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input class="form-control" readonly value="<?= date('d F Y - H:i:s', strtotime($comment['parent_date'])) ?>">
                </div>
            </form>
        </div>
    </div>
</div>