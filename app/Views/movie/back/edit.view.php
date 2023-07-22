<?php $duration = sprintf("%02d:%02d:00", floor($movie->getDuration() / 60), $movie->getDuration() % 60); ?>
<div class="card w-100">
    <div class="card-header d-flex">
        <h4 class="card-title">Modifier la maison de production #<?= $movie->getId() ?> - <?= $movie->getTitle() ?></h4>
        <a href="/admin/movie/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container my-4">
        <div class="w-100">
            <form action="/admin/movie/update/<?= $movie->getId() ?>" method="POST">
                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= $old->title ?? $movie->getTitle()?>" required>
                    <?php if(isset($errors['title'])): ?>
                        <?php foreach($errors['title'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="ids_category_movie">Catégories</label>
                    <select multiple name="ids_category_movie[]" id="ids_category_movie" class="form-control" required>
                        <?php foreach($categoriesMovie as $categoryMovie): ?>
                            <option value="<?= $categoryMovie->id ?>" <?= in_array($categoryMovie->id, $movieCategoriesMovie) ? 'selected' : '' ?>>
                                <?= $categoryMovie->name?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if(isset($errors['ids_categorie_movie'])): ?>
                        <?php foreach($errors['ids_categorie_movie'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="release_date">Date de sortie</label>
                        <input type="date" name="release_date" id="release_date" value="<?= $old->release_date ?? $movie->getReleaseDate()?>" class="form-control" required>
                        <?php if(isset($errors['release_date'])): ?>
                            <?php foreach($errors['release_date'] as $error): ?>
                                <div class="text-danger"><?= $error; ?></div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="col">
                        <label for="duration">Durée du film</label>
                        <input type="time" id="duration" name="duration" class="form-control" value="<?= $duration ?>" required>
                        <?php if(isset($errors['duration'])): ?>
                            <?php foreach($errors['duration'] as $error): ?>
                                <div class="text-danger"><?= $error; ?></div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="10" required><?= $old->description ?? $movie->getDescription() ?></textarea>
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