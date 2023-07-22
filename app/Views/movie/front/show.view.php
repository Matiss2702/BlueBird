<div id="content-wrapper">
    <div class="row">
        <div class="col-lg-8">
            <?php $this->partial('movie/general'); ?>
            <?php $this->partial('movie/rating'); ?>
            <?php $this->partial('movie/comments'); ?>
        </div>
        <div class="col-lg-4">
            <?php $this->partial('movie/search'); ?>
            <?php $this->partial('movie/categories'); ?>
        </div>
    </div>
</div>