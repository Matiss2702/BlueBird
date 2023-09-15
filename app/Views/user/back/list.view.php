<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <?php $this->partial('back/topbar'); ?>
        <div class="container-fluid">
            <div class="bg-white">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h4 class="h4 font-weight-bold text-primary">Utilisateurs</h4>
                    <a href="/admin/user/create" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i>
                        Créer un nouvel utilisateur
                    </a>
                </div>
                <?php if ($users) : ?>
                    <table class="table display dataTable mt-4 " id="user-list">
                        <thead class="thead-light">
                            <tr>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Statut</th>
                                <th>Date de création</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= $user->firstname ?></td>
                                    <td><?= $user->lastname ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= $user->status ? 'Actif': 'Inactif' ?></td>
                                    <td><?= date('Y-m-d H:i:s', strtotime($user->created_at)) ?></td>
                                    <td>
                                        <!-- Boutons d'action -->
                                        <a href="/admin/user/show/<?= $user->id ?>" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="/admin/user/edit/<?= $user->id ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="/admin/user/delete/<?= $user->id ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="thead-light">
                            <tr>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Statut</th>
                                <th>Date de création</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php $this->partial('back/footer'); ?>
</div>
