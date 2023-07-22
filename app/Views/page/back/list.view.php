<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <?php $this->partial('back/topbar'); ?>
        <div class="container-fluid">
            <div class="bg-white">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h4 class="h4 font-weight-bold text-primary">Pages</h4>
                    <a href="/admin/page/create" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-sm-inline-block">Créer un nouvelle page</span>
                    </a>
                </div>
                <div class="table-responsive">
                    <?php if ($pages) : ?>
                        <table class="table">
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
                                <?php foreach ($pages as $page): ?>
                                <tr>
                                    <td class="d-table-cell"><?= $page->id ?></td>
                                    <td class="d-none d-sm-table-cell"><?= $page->title ?></td>
                                    <td class="d-none d-sm-table-cell"><?= $page->content ?></td>
                                    <td class="d-none d-sm-table-cell"><?= date('Y-m-d H:i:s', strtotime($page->created_at)) ?></td>
                                    <td class="d-table-cell">
                                        <!-- Boutons d'action -->
                                        <a href="/admin/page/show/<?= $page->id ?>" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="/admin/page/edit/<?= $page->id ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="/admin/page/delete/<?= $page->id ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
