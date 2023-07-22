<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <?php $this->partial('back/topbar'); ?>
        <div class="container-fluid">
            <div class="bg-white">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h4 class="h4 font-weight-bold text-primary">Articles</h4>
                    <a href="/admin/menu/create" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-sm-inline-block">Créer un nouvel article</span>
                    </a>
                </div>
                <div class="table-responsive">
                    <?php if ($menus) : ?>
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th class="d-table-cell">ID</th>
                                    <th class="d-none d-sm-table-cell">Titre</th>
                                    <th class="d-none d-sm-table-cell">Contenu</th>
                                    <th class="d-none d-sm-table-cell">Parent</th>
                                    <th class="d-none d-sm-table-cell">Zone</th>
                                    <th class="d-none d-sm-table-cell">Statut</th>
                                    <th class="d-none d-sm-table-cell">Date de création</th>
                                    <th class="d-table-cell">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($menus as $menu) : ?>
                                    <tr>
                                        <td class="d-table-cell"><?= $menu->id ?></td>
                                        <td class="d-none d-sm-table-cell"><?= $menu->title ?></td>
                                        <td class="d-none d-sm-table-cell"><?= $menu->slug ?></td>
                                        <td class="d-none d-sm-table-cell"><?= $menu->id_parent ?></td>
                                        <?php
                                            $zoneText = '';
                                            switch ($menu->zone) {
                                                case 0:
                                                    $zoneText = 'Topbar';
                                                    break;
                                                case 1:
                                                    $zoneText = 'Sidebar';
                                                    break;
                                                case 2:
                                                    $zoneText = 'Footer';
                                                    break;
                                            }
                                        ?>
                                        <td><?= $zoneText ?></td>
                                        <td><?= $menu->status ? 'Actif' : 'Inactif' ?></td>
                                        <td class="d-none d-sm-table-cell"><?= date('Y-m-d H:i:s', strtotime($menu->created_at)) ?></td>
                                        <td class="d-table-cell">
                                            <!-- Boutons d'action -->
                                            <a href="/admin/menu/show/<?= $menu->id ?>" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a>
                                            <a href="/admin/menu/edit/<?= $menu->id ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                            <a href="/admin/menu/delete/<?= $menu->id ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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