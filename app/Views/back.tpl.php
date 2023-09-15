<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? WEBSITE_TITLE ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $description ?? WEBSITE_DESCRIPTION ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Inclusion des assets -->
    <?php $this->partial('assets'); ?>
    <link rel="stylesheet" href="/css/datatables/datatables.min.css">
    <!-- Inclusion des scripts nécéssaires -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/chkwzjujlbt5or0j9fb6826oee76gp65q4h5v057pajzzay6/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php $this->partial('back/sidebar'); ?>

        <?php include $this->view; ?>
    </div>

    <?php $this->partial('logout-modal'); ?>

    <!-- Inclusion des scripts -->
    <?php $this->partial('scripts'); ?>
</body>

</html>