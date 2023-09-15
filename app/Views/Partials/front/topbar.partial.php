<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <div class="container-fluid">
        <a class="navbar-brand text-primary font-weight-bold" href="/">BLUE BIRD <sup>©</sup></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php if ($menus) : ?>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php
                    $topbarMenus = array_filter($menus, function ($menu) {
                        return $menu->zone == 0 && $menu->status == 1;
                    });
                    $orderedMenus = array_column($topbarMenus, null, 'orders');
                    ksort($orderedMenus);

                    foreach ($orderedMenus as $menu) :
                        $hasChildMenu = false;
                        $childMenus = [];
                        foreach ($menus as $childMenu) {
                            if ($childMenu->id_parent == $menu->id) {
                                $childMenus[] = $childMenu;
                                $hasChildMenu = true;
                            }
                        }
                        if ($menu->status == 1) {
                            if ($hasChildMenu) : ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle<?= $menu->id_parent == '' ? ' dropdown-closed' : '' ?>" href="<?= $menu->slug ?>" id="navbarDropdown<?= $menu->id ?>" role="button" <?= $hasChildMenu ? 'data-bs-toggle="dropdown" aria-expanded="false"' : '' ?>>
                                        <?= $menu->title ?>
                                        <?php if ($hasChildMenu) : ?>
                                            <span class="dropdown-chevron"></span>
                                        <?php endif; ?>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown<?= $menu->id ?>">
                                        <?php
                                        $orderedChildMenus = array_column($childMenus, null, 'orders');
                                        ksort($orderedChildMenus);

                                        foreach ($orderedChildMenus as $childMenu) : ?>
                                            <?php if ($childMenu->status == 1) : ?>
                                                <li>
                                                    <a class="dropdown-item" href="<?= $childMenu->slug ?>">
                                                        <?= $childMenu->title ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php else :
                                if ($menu->id_parent == '') :
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= $menu->slug ?>">
                                            <?= $menu->title ?>
                                        </a>
                                    </li>
                    <?php
                                endif;
                            endif;
                        }
                    endforeach;
                    ?>
                    <?php foreach ($menus as $menu) : ?>
                        <?php if ($menu->id_parent === "null") : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown<?= $menu->id ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= $menu->title ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown<?= $menu->id ?>">
                                    <?php foreach ($menus as $childMenu) : ?>
                                        <?php if ($childMenu->id_parent === $menu->id) : ?>
                                            <li>
                                                <a class="dropdown-item" href="<?= $childMenu->slug ?>">
                                                    <?= $childMenu->title ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?= $this->partial('profile') ?>
    </div>
</nav>