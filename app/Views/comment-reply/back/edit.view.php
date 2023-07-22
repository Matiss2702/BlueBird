<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Modifier le commentaire #<?= $comment['id'] ?></h4>
        <a href="/admin/comment-reply/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container mt-5">
        <div class="w-75">
            <form action="/admin/comment-reply/update/<?= $comment['id'] ?>" method="POST">
                <div class="form-group">
                    <label for="user">Utilisateur</label>
                    <input type="text" class="form-control" value="<?= ucfirst(strtolower($comment['firstname'])) . ' ' . strtoupper($comment['lastname']) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="date">Date de publication</label>
                    <input class="form-control" value="<?= date('d F Y - H:i:s', strtotime($comment['created_at'])) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="content">Commentaire</label>
                    <textarea name="content" class="form-control"><?= $comment['content'] ?></textarea>
                    <?php if (isset($errors['content'])) : ?>
                        <?php foreach ($errors['content'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="firstname">Statut</label>
                    <select name="id_status" id="id_status" class="form-control" required>
                        <?php foreach($commentStatus as $status): ?>
                            <option value="<?= $status->id ?>" <?= $status->id == $comment['id_status'] ? 'selected' : '' ?>>
                                <?= $status->intitule ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['id_status'])) : ?>
                        <?php foreach ($errors['id_status'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
</div>