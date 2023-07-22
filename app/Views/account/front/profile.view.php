<div class="card w-75 mb-3 mx-auto">
    <div class="container my-4">
        <div class="w-100">
            <form>
                <div class="form-group">
                    <label for="firstname">Firstname</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?= $account->getFirstname() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="lastname">Lastname</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" value="<?= $account->getLastname() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="form-control" value="<?= $account->getEmail() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" id="password" name="password" class="form-control" value="" placeholder="********" readonly>
                </div>
            </form>
        </div>
    </div>
</div>