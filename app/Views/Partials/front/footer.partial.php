<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <ul class="footer-menu">
                    <?php
                    $footerMenus = array_filter($menus, function ($menu) {
                        return $menu->zone == 2;
                    });
                    $orderedMenus = array_column($footerMenus, null, 'orders');
                    ksort($orderedMenus);

                    foreach ($orderedMenus as $menu) : ?>
                        <?php  if($menu->status == 1) : ?>
                            <li><a href="<?= $menu->slug ?>"><?= $menu->title ?></a></li>
                        <?php endif;?>
                    <?php endforeach; ?>
                </ul>
                <p>BlueBird &copy; 2023 - Tous droits réservés</p>
            </div>
            <div class="col-lg-6">
                <div class="footer-social">
                    <ul class="social-icons">
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p class="footer-credits">Retrouvez tous infos sur votre cms préferer</p>
                <p class="footer-credits">©Blue Bird</p>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer {
        padding: 30px 0;
        background-color: #f8f9fc;
    }

    .footer-menu {
        list-style: none;
        padding: 0;
        margin-bottom: 15px;
    }

    .footer-menu li {
        display: inline-block;
        margin-right: 15px;
    }

    .footer-menu li:last-child {
        margin-right: 0;
    }

    .footer-menu li a {
        color: #666666;
        text-decoration: none;
    }

    .footer-social {
        text-align: right;
    }

    .social-icons {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .social-icons li {
        display: inline-block;
        margin-right: 10px;
    }

    .social-icons li:last-child {
        margin-right: 0;
    }

    .social-icons a {
        color: #666666;
        font-size: 18px;
    }

    .footer-credits {
        margin-top: 10px;
        font-size: 12px;
        color: #999999;
    }
</style>
