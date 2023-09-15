<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <?php $this->partial('back/topbar'); ?>
        <div class="container-fluid">
            <div class="bg-white">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h4 class="h4 font-weight-bold text-primary">Fichier</h4>
                    <a href="/admin/media/create" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-sm-inline-block">Ajouter un nouveau fichier</span>
                    </a>
                </div>
                <div class="table-responsive">
                    <?php if ($medias) : ?>
                        <table class="table display dataTable mt-4" id="media-list">
                            <thead class="thead-light">
                                <tr>
                                    <th class="d-table-cell">Fichier</th>
                                    <th class="d-table-cell">Nom</th>
                                    <th class="d-table-cell">Alt</th>
                                    <th class="d-table-cell">Slug</th>
                                    <th class="d-table-cell">Ajouté le</th>
                                    <th class="d-table-cell">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($medias as $media) : ?>
                                    <tr>
                                        <td class="d-table-cell" style="max-width:80px; height:100%">
                                            <?= $media->src ?>
                                        </td>
                                        </td>
                                        <td class="d-table-cell">
                                            <?= $media->name ?>
                                        </td>
                                        <td class="d-table-cell">
                                            <?= $media->alt ?>
                                        </td>
                                        <td class="d-table-cell">
                                            <a href="<?= SITE_URL?>/uploads<?=$media->slug?>" target="_blank">
                                                <?= $media->slug?>
                                            </a>
                                        </td>
                                        <td class="d-table-cell"><?= date('Y-m-d', strtotime($media->created_at)) ?></td>
                                        <td class="d-table-cell">
                                            <!-- Boutons d'action -->
                                            <button class="btn btn-info btn-sm" onclick="copyToClipboard('<?= SITE_URL ?>/uploads<?= $media->slug ?>')"><i class="fa fa-copy"></i> Copier l'URL</button>
                                            <a href="/admin/media/show/<?= $media->id ?>" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a>
                                            <a href="/admin/media/edit/<?= $media->id ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                            <a href="/admin/media/delete/<?= $media->id ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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