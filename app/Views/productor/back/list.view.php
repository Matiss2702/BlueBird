<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <?php $this->partial('back/topbar'); ?>
        <div class="container-fluid">
            <div class="bg-white">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h4 class="h4 font-weight-bold text-primary">Maisons de production</h4>
                    <a href="/admin/productor/create" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-sm-inline-block">Créer une nouvelle maison de production</span>
                    </a>
                </div>
                <div class="table-responsive">
                    <?php if ($productors) : ?>
                        <table class="table display dataTable mt-4 " id="productor-list">
                            <thead class="thead-light">
                                <tr>
                                    <th class="d-table-cell">ID</th>
                                    <th class="d-table-cell">Nom</th>
                                    <th class="d-none d-sm-table-cell">Description</th>
                                    <th class="d-none d-sm-table-cell">Pays</th>
                                    <th class="d-table-cell ">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productors as $productor): ?>
                                <tr>
                                    <td class="d-table-cell"><?= $productor['id']  ?? 'NULL' ?></td>
                                    <td class="d-table-cell"><?= $productor['name'] ?? 'NULL' ?></td>
                                    <td class="d-none d-sm-table-cell text-truncate" style="max-width:250px"><?=  $productor['description'] ?? 'NULL' ?></td>
                                    <td class="d-none d-sm-table-cell"><?= $productor['iso'] ?? 'NULL' ?></td>
                                    <td class="d-flex flex-column d-sm-table-cell">
                                        <a href="/admin/productor/show/<?=  $productor['id'] ?>" class="btn btn-secondary btn-sm mb-2 mb-lg-auto">
                                            <i class="fa fa-eye"></i>
                                            <span class="sr-only">Cliquer pour voir : <?=$productor["name"]?></span>
                                        </a>
                                        <a href="/admin/productor/edit/<?=  $productor['id'] ?>" class="btn btn-primary btn-sm mb-2 mb-lg-auto">
                                            <i class="fa fa-edit"></i>
                                            <span class="sr-only">Cliquer pour modifier : <?=$productor["name"]?></span>
                                        </a>
                                        <a href="/admin/productor/delete/<?=  $productor['id'] ?>" class="btn btn-danger btn-sm mb-2 mb-lg-auto">
                                            <i class="fa fa-trash"></i>
                                            <span class="sr-only">Cliquer pour supprimer : <?=$productor["name"]?></span>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="d-table-cell">ID</th>
                                    <th class="d-table-cell">Nom</th>
                                    <th class="d-none d-sm-table-cell">Description</th>
                                    <th class="d-none d-sm-table-cell">Pays</th>
                                    <th class="d-table-cell ">Action</th>
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