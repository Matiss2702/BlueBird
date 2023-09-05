<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <?php $this->partial('back/topbar'); ?>
        <div class="container-fluid">
            <div class="bg-white">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h4 class="h4 font-weight-bold text-primary">Notations</h4>
                    <a href="/admin/review/create" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-sm-inline-block">Créer une nouvelle notation</span>
                    </a>
                </div>
                <div class="table-responsive">
                    <?php if ($reviews) : ?>
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th class="d-table-cell">ID</th>
                                    <th class="d-none d-sm-table-cell">Auteur</th>
                                    <th class="d-none d-sm-table-cell">Film</th>
                                    <th class="d-none d-sm-table-cell">Note</th>
                                    <th class="d-none d-sm-table-cell">Critique</th>
                                    <th class="d-none d-sm-table-cell">Date de création</th>
                                    <th class="d-table-cell">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reviews as $review) : ?>
                                    <tr>
                                        <td class="d-table-cell"><?= $review['id'] ?></td>
                                        <td class="d-none d-sm-table-cell"><?= $review['lastname'] . ' ' . $review['firstname'] ?></td>
                                        <td class="d-none d-sm-table-cell"><?= $review['title'] ?></td>
                                        <td class="d-none d-sm-table-cell">
                                            <i class="fa fa-star <?= $review['rate'] >= 1 ? 'text-warning' : '' ?>"></i>
                                            <i class="fa fa-star <?= $review['rate'] >= 2 ? 'text-warning' : '' ?>"></i>
                                            <i class="fa fa-star <?= $review['rate'] >= 3 ? 'text-warning' : '' ?>"></i>
                                            <i class="fa fa-star <?= $review['rate'] >= 4 ? 'text-warning' : '' ?>"></i>
                                            <i class="fa fa-star <?= $review['rate'] >= 5 ? 'text-warning' : '' ?>"></i>
                                        </td>
                                        <td class="d-none d-sm-table-cell"><?= substr($review['comment'], 0, 75).'...' ?></td>
                                        <td class="d-none d-sm-table-cell"><?= date('d/m/Y', strtotime($review['created_at'])) ?></td>
                                        <td class="d-table-cell">
                                            <!-- Boutons d'action -->
                                            <a href="/admin/review/show/<?= $review['id'] ?>" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a>
                                            <a href="/admin/review/edit/<?= $review['id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                            <a href="/admin/review/delete/<?= $review['id'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->partial('back/footer'); ?>
</div>