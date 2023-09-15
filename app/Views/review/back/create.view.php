<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Nouvelle notation</h4>
        <a href="/admin/review/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container mt-5">
        <div class="w-75">
            <form action="/admin/review/store" method="POST">
                <div class="form-group">
                    <label for="id_user">Auteur</label>
                    <select id="id_user" name="id_user" class="form-control">
                        <?php foreach ($users as $user) : ?>
                            <option
                                value="<?= $user->id ?>"
                                <?= isset($old->id_user) && $old->id_user == $user->id ? 'selected' : '' ?>
                            >
                                <?= $user->lastname . ' ' . $user->firstname ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['id_user'])) : ?>
                        <?php foreach ($errors['id_user'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="id_movie">Film</label>
                    <select id="id_movie" name="id_movie" class="form-control">
                        <?php foreach ($movies as $movie) : ?>
                            <option
                                value="<?= $movie->id ?>"
                                <?= isset($old->id_movie) && $old->id_movie == $movie->id ? 'selected' : '' ?>
                            >
                                <?= $movie->title ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['id_movie'])) : ?>
                        <?php foreach ($errors['id_movie'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="rate">Note</label>
                    <input type="number" id="rate" name="rate" class="form-control" value="<?= isset($old->rate) && $old->rate ?>" hidden>
                    <div class="review-stars">
                        <i class="fa fa-star review-star <?= isset($old->rate) && $old->rate >= 1 ? 'text-warning' : '' ?>"></i>
                        <i class="fa fa-star review-star <?= isset($old->rate) && $old->rate >= 2 ? 'text-warning' : '' ?>"></i>
                        <i class="fa fa-star review-star <?= isset($old->rate) && $old->rate >= 3 ? 'text-warning' : '' ?>"></i>
                        <i class="fa fa-star review-star <?= isset($old->rate) && $old->rate >= 4 ? 'text-warning' : '' ?>"></i>
                        <i class="fa fa-star review-star <?= isset($old->rate) && $old->rate >= 5 ? 'text-warning' : '' ?>"></i>
                    </div>
                    <?php if (isset($errors['rate'])) : ?>
                        <?php foreach ($errors['rate'] as $error) : ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="comment">Critique</label>
                    <textarea id="comment" name="comment" class="form-control" rows="12"><?= $old->comment ?? '' ?></textarea>
                    <?php if(isset($errors['comment'])): ?>
                        <?php foreach($errors['comment'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>