<?php $duration = sprintf("%02d:%02d:00", floor($movie->getDuration() / 60), $movie->getDuration() % 60); ?>
<div class="card w-100">
    <div class="card-header d-flex">
    <h4 class="card-title">Details du film #<?= $movie->getId() ?> - <?= $movie->getTitle() ?></h4>
        <a href="/admin/movie/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container my-4">
        <div class="w-100">
            <form>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= $movie->getTitle() ?>" readonly>
                </div>
                <div class="form-row mb-4">
                    <div class="col">
                        <label for="release_date">Date de sortie</label>
                        <input type="date" id="release_date" name="release_date" class="form-control" value="<?=$movie->getReleaseDate()?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="ids_category_movie">Catégories</label>
                    <select multiple name="ids_category_movie[]" id="ids_category_movie" class="form-control" readonly>
                        <?php foreach($categoriesMovie as $categoryMovie): ?>
                            <?php if (in_array($categoryMovie->id, $movieCategoriesMovie)): ?>
                                <option value="<?= $categoryMovie->id ?>">
                                    <?= $categoryMovie->name?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="duration">Durée du film</label>
                    <input type="time" id="duration" name="duration" class="form-control" value="<?=$duration?>" readonly>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" readonly rows="10"><?= $movie->getDescription() ?></textarea>
                </div>
            </form>
        </div>
    </div>
</div>