<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <?php $this->partial('back/topbar'); ?>
        <div class="container-fluid">
            <div class="bg-white">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h4 class="h4 font-weight-bold text-primary">Films</h4>
                    <a href="/admin/movie/create" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i>
                        <span class="d-none d-sm-inline-block">Créer un film</span>
                    </a>
                </div>
                <div class="table-responsive">
                    <?php if ($movies) : ?>
                        <p class="pb-2 px-3">Affichage de <strong><?= count($movies);?></strong> films</p>
                        <table class="table display dataTable mt-4 " id="movie-list">
                            <thead class="thead-light">
                                <tr>
                                    <th class="d-table-cell">ID</th>
                                    <th class="d-table-cell">Titre</th>
                                    <th class="d-none d-sm-table-cell">Description</th>
                                    <th class="d-none d-sm-table-cell">Date de sortie</th>
                                    <th class="d-none d-sm-table-cell">Durée en heure</th>
                                    <th class="d-table-cell ">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($movies as $movie): ?>
                                <tr>
                                    <td class="d-table-cell"><?= $movie['id'] ?? '' ?></td>
                                    <td class="d-table-cell"><?= $movie['title'] ?? '' ?></td>
                                    <td class="d-none d-sm-table-cell text-truncate" style="max-width:250px"><?=  $movie['description'] ?? '' ?></td>
                                    <td class="d-none d-sm-table-cell"><?php $date = strtotime($movie['release_date']) ; echo $release_date = date('d/m/Y', $date) ?></td>
                                    <td class="d-table-cell"><?= $movie['duration'] ?? '' ?></td>
                                    <td class="d-flex flex-column d-sm-table-cell">
                                        <a href="/admin/movie/show/<?=  $movie['id']?>" class="btn btn-secondary btn-sm mb-2 mb-lg-auto">
                                            <i class="fa fa-eye"></i>
                                            <span class="sr-only">Cliquer pour voir : <?=$movie['title']?></span>
                                        </a>
                                        <a href="/admin/movie/edit/<?=  $movie['id']?>" class="btn btn-primary btn-sm mb-2 mb-lg-auto">
                                            <i class="fa fa-edit"></i>
                                            <span class="sr-only">Cliquer pour modifier : <?=$movie['title']?></span>
                                        </a>
                                        <a href="/admin/movie/delete/<?=  $movie['id']?>" class="btn btn-danger btn-sm mb-2 mb-lg-auto">
                                            <i class="fa fa-trash"></i>
                                            <span class="sr-only">Cliquer pour supprimer : <?=$movie['title']?></span>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="thead-light">
                                <tr>
                                    <th class="d-table-cell">ID</th>
                                    <th class="d-table-cell">Titre</th>
                                    <th class="d-none d-sm-table-cell">Description</th>
                                    <th class="d-none d-sm-table-cell">Date de sortie</th>
                                    <th class="d-none d-sm-table-cell">Durée en heure</th>
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