<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title ?? WEBSITE_TITLE ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $description ?? WEBSITE_DESCRIPTION ?>">
    <!-- Inclusion des assets -->
    <?php $this->partial('assets'); ?>
    <!-- Inclusion des scripts nécéssaires -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php $this->partial('front/topbar'); ?>
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