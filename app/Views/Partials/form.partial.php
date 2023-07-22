<form method="<?= $config["config"]["method"] ?>"
      action="<?= $config["config"]["action"] ?>"
      enctype="<?= $config["config"]["enctype"] ?>"
      id="<?= $config["config"]["id"] ?>"
      class="<?= $config["config"]["class"] ?>">

    <?php foreach ($config["inputs"] as $name=>$configInput): ?>

        <input
                name="<?= $name ?>"
                placeholder="<?= $configInput["placeholder"] ?>"
                class="<?= $configInput["class"] ?>"
                id="<?= $configInput["placeholder"] ?>"
                type="<?= $configInput["type"] ?>"
                <?= $configInput["required"]?"required":"" ?>
         ><br>

    <?php endforeach;?>

    <!-- Errors -->
    <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php endforeach;?>
    <!-- End Errors -->

    <input type="submit" class="btn btn-primary btn-user btn-block"
           name="submit" value="<?= $config["config"]["submit"] ?>">
</form>