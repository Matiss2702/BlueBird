<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <?php $this->partial('back/topbar'); ?>
        <div class="container-fluid">
            <div class="bg-white">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h4 class="h4 font-weight-bold text-primary">Catégories de Film</h4>
                    <a href="/admin/category-movie/create" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-sm-inline-block">Créer une Catégorie de film</span>
                    </a>
                </div>
                <div class="table-responsive">
                    <?php if ($categoriesMovie) : ?>
                        <table class="table" id="category-movie-list">
                            <thead class="thead-light">
                                <tr>
                                    <th class="d-table-cell">ID</th>
                                    <th class="d-table-cell">Nom</th>
                                    <th class="d-table-cell ">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categoriesMovie as $categoryMovie): ?>
                                <tr>
                                    <td class="d-table-cell"><?= $categoryMovie['id'] ?? '' ?></td>
                                    <td class="d-table-cell"><?= $categoryMovie['name']?? '' ?></td>
                                    <td class="d-flex flex-column d-sm-table-cell">
                                        <a href="/admin/category-movie/show/<?=  $categoryMovie['id']?>" class="btn btn-secondary btn-sm mb-2 mb-lg-auto">
                                            <i class="fa fa-eye"></i>
                                            <span class="sr-only">Cliquer pour voir : <?=$categoryMovie['name']?></span>
                                        </a>
                                        <a href="/admin/category-movie/edit/<?=  $categoryMovie['id']?>" class="btn btn-primary btn-sm mb-2 mb-lg-auto">
                                            <i class="fa fa-edit"></i>
                                            <span class="sr-only">Cliquer pour modifier : <?=$categoryMovie['name']?></span>
                                        </a>
                                        <a href="/admin/category-movie/delete/<?=  $categoryMovie['id']?>" class="btn btn-danger btn-sm mb-2 mb-lg-auto">
                                            <i class="fa fa-trash"></i>
                                            <span class="sr-only">Cliquer pour supprimer : <?=$categoryMovie['name']?></span>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="thead-light">
                                <tr>
                                    <th class="d-table-cell">ID</th>
                                    <th class="d-table-cell">Nom</th>
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
</div>s