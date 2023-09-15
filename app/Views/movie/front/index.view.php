<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="bg-white">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h1 class="h1 font-weight-bold text-primary">Tous nos films</h1>
            </div>
            <div class="container-fluid py-4">
                <div class="row">
                    <aside class="col-md-3 col-12">
                        <div class="d-flex flex-column">
                            <h3 class="h4">Recherche avancée</h3>
                            <br>
                            <?php $this->partial('movie/index/formMovieName'); ?>
                            <br><br>
                            <?php $this->partial('movie/index/formCategoryMovie'); ?>
                        </div>
                    </aside>
                    <section class="col-md-9 col-12">
                        <div class="row">
                        <?php if (isset($moviesFiltered)) : ?>
                            <?php $this->partial('movie/index/moviesFiltered'); ?>
                        <?php elseif ($movies) :?>
                            <?php $this->partial('movie/index/moviesNotFiltered'); ?>
                        <?php endif;?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>