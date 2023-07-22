<div class="card w-75 mb-3 mx-auto">
    <div class="container my-4">
        <div class="w-100">
            <form action="account/update" method="POST">
                <div class="form-group">
                    <label for="firstname">Firstname</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?= $old['firstname'] ?? $account->getFirstname() ?>">
                    <?php if(isset($errors['firstname'])): ?>
                        <?php foreach($errors['firstname'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="lastname">Lastname</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" value="<?= $old['lastname'] ?? $account->getLastname() ?>">
                    <?php if(isset($errors['lastname'])): ?>
                        <?php foreach($errors['lastname'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="form-control" value="<?= $old['email'] ?? $account->getEmail() ?>">
                    <?php if(isset($errors['email'])): ?>
                        <?php foreach($errors['email'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <input type="checkbox" id="showPassword" name="showPassword" >
                    <label for="showPassword">Changer mon mot de passe</label>
                </div>
                <hr>
                <div class="form-group" id="passwordFields" style="display: none;">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" value="" placeholder="********">
                    <?php if(isset($errors['password'])): ?>
                        <?php foreach($errors['password'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group" id="confirmPasswordField" style="display: none;">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" value="" placeholder="********">
                    <?php if(isset($errors['confirmPassword'])): ?>
                        <?php foreach($errors['confirmPassword'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>

<script>
    const showPasswordCheckbox = document.getElementById('showPassword');
    const passwordFields = document.getElementById('passwordFields');
    const confirmPasswordField = document.getElementById('confirmPasswordField');

    showPasswordCheckbox.addEventListener('change', function() {
        if (showPasswordCheckbox.checked) {
            passwordFields.style.display = 'block';
            confirmPasswordField.style.display = 'block';
        } else {
            passwordFields.style.display = 'none';
            confirmPasswordField.style.display = 'none';
        }
    });
</script>