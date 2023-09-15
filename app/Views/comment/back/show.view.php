<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Détails du commentaire #<?= $comment['id'] ?></h4>
        <a href="/admin/comment/list" class="btn btn-primary ml-auto">
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
                    <label for="user">Utilisateur</label>
                    <input type="text" class="form-control" value="<?= ucfirst(strtolower($comment['firstname'])) . ' ' . strtoupper($comment['lastname']) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="comment">Commentaire</label>
                    <textarea class="form-control" readonly><?= $comment['content'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Statut</label>
                    <input class="form-control" readonly value="<?= $comment['comment_status'] ?>">
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input class="form-control" readonly value="<?= date('Y-m-d H:i:s', strtotime($comment['created_at'])) ?>">
                </div>
            </form>
        </div>
    </div>
</div>