<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Blue bird' ?></title>
    <meta name="description" content="<?= $description ?? 'Découvrez Blue Bird, une plateforme géniale !' ?>">
    <!-- Inclusion des assets -->
    <?php $this->partial('assets'); ?>
</head>

<body>
    <?php $this->partial('front/basic-topbar'); ?>
    <!-- Contenu de la page -->
    <div class="container mt-5">
        <?php include $this->view; ?>
    </div>

    <?php $this->partial('front/footer'); ?>

    <?php $this->partial('logout-modal'); ?>

    <!-- Inclusion des scripts -->
    <?php $this->partial('scripts'); ?>
</body>

</html>