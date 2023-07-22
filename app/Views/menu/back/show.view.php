<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Détails de l'article #<?= $menu->getId() ?></h4>
        <a href="/admin/menu/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container mt-5">
        <div class="w-75">
            <form>
                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= $menu->getTitle() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="<?= $menu->getSlug() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="orders">Orders</label>
                    <input type="text" id="orders" name="orders" class="form-control" value="<?= $menu->getOrders() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="id_parent">Parent</label>
                    <input type="text" id="id_parent" name="id_parent" class="form-control" value="<?= $menu->getParent() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="zone">Zone</label>
                    <?php
                        $zoneText = '';
                        switch ($menu->getZone()) {
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
                    <input type="text" id="zone" name="zone" class="form-control" value="<?= $zoneText ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="status">Statut</label>
                    <input type="text" id="status" name="status" class="form-control" value="<?= $menu->getStatus() ? 'Actif' : 'Inactif' ?>" readonly>
                </div>
            </form>
        </div>
    </div>
</div>