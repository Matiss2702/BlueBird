<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Modifier la maison de production #<?= $productor->getId() ?> - <?= $productor->getName() ?></h4>
        <a href="/admin/productor/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container mt-5">
        <div class="w-75">
            <form action="/admin/productor/update/<?= $productor->getId() ?>" method="POST">
                <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= $old->name ?? $productor->getName()?>" required>
                    <?php if(isset($errors['name'])): ?>
                        <?php foreach($errors['name'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="id_country">Pays</label>
                    <select id="id_country" name="id_country" class="form-control" rows="10" required>
                        <?php foreach ($countries as $country):?>
                            <option value="<?= $country->id ?>" <?= $country->id == $productor->getIdCountry() ? 'selected': ''?>>
                                <?= $country->iso ?> - <?= $country->nicename ?>
                            </option>   
                        <?php endforeach;?>
                    </select>
                    <?php if(isset($errors['id_country'])): ?>
                        <?php foreach($errors['id_country'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="10" required><?= $old->description ?? $productor->getDescription() ?></textarea>
                    <?php if(isset($errors['description'])): ?>
                        <?php foreach($errors['description'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>