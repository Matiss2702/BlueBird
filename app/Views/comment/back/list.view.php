<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <?php $this->partial('back/topbar'); ?>
        <div class="container-fluid">
            <div class="bg-white">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h4 class="h4 font-weight-bold text-primary">Commentaires</h4>
                </div>
                <?php if ($comments) : ?>
                    <div class="table-responsive">
                        <table class="table ml-md-">
                            <thead class="thead-light">
                                <tr>
                                    <th class="d-table-cell">#</th>
                                    <th>Utilisateur</th>
                                    <th>Commentaire</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th class="d-table-cell">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($comments as $comment) : ?>
                                    <tr>
                                        <td class="d-table-cell"><?= $comment['id'] ?></td>
                                        <td><?= ucfirst(strtolower($comment['firstname'])) . ' ' . strtoupper($comment['lastname']) ?></td>
                                        <td class="truncated-message"><?= $comment['content'] ?></td>
                                        <td class="truncated-message"><?= $comment['comment_status'] ?></td>
                                        <td><?= date('Y-m-d H:i:s', strtotime($comment['created_at'])) ?></td>
                                        <td class="d-table-cell">
                                            <a href="/admin/comment/show/<?= $comment['id'] ?>" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a>
                                            <a href="/admin/comment/edit/<?= $comment['id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                            <a href="/admin/comment/delete/<?= $comment['id'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
