<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <?php $this->partial('back/topbar'); ?>
        <div class="container-fluid">
            <div class="bg-white">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h4 class="h4 font-weight-bold text-primary">Articles</h4>
                    <a href="/admin/post/create" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-sm-inline-block">Créer un nouvel article</span>
                    </a>
                </div>
                <div class="table-responsive">
                    <?php if ($posts) : ?>
                        <table class="table display dataTable mt-4 " id="post-list">
                            <thead class="thead-light">
                                <tr>
                                    <th class="d-table-cell">ID</th>
                                    <th class="d-none d-sm-table-cell">Titre</th>
                                    <th class="d-none d-sm-table-cell">Contenu</th>
                                    <th class="d-none d-sm-table-cell">Date de création</th>
                                    <th class="d-table-cell">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td class="d-table-cell"><?= $post->id ?></td>
                                    <td class="d-none d-sm-table-cell"><?= $post->title ?></td>
                                    <td class="d-none d-sm-table-cell"><?= $post->content ?></td>
                                    <td class="d-none d-sm-table-cell"><?= date('Y-m-d H:i:s', strtotime($post->created_at)) ?></td>
                                    <td class="d-table-cell">
                                        <!-- Boutons d'action -->
                                        <a href="/admin/post/show/<?= $post->id ?>" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="/admin/post/edit/<?= $post->id ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="/admin/post/delete/<?= $post->id ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="thead-light">
                                <tr>
                                    <th class="d-table-cell">ID</th>
                                    <th class="d-none d-sm-table-cell">Titre</th>
                                    <th class="d-none d-sm-table-cell">Contenu</th>
                                    <th class="d-none d-sm-table-cell">Date de création</th>
                                    <th class="d-table-cell">Action</th>
                                </tr>
                        </tfoot>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->partial('back/footer'); ?>
</div>
