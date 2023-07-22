<!-- Inclusion des scripts supplémentaires -->
<?php foreach ($this->scripts as $script) : ?>
    <script src="<?= $script ?>" defer></script>
<?php endforeach; ?>