<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <div class="container-fluid">
        <a class="navbar-brand text-primary font-weight-bold" href="/">BLUE BIRD <sup>©</sup></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                        if ($hasChildMenu) :
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle<?= $menu->id_parent == '' ? ' dropdown-closed' : '' ?>"
                        href="<?= $menu->slug ?>" id="navbarDropdown<?= $menu->id ?>"
                        role="button" <?= $hasChildMenu ? 'data-bs-toggle="dropdown" aria-expanded="false"' : '' ?>>
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
                                <?php if ($childMenu->status == 1) :?>
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

<style>
    .navbar-brand {
        font-size: 24px;
    }

    .nav-item {
        position: relative;
    }

    .nav-link {
        padding: 10px 15px;
    }

    .nav-link:hover {
        background-color: #f8f9fa;
    }

    .dropdown-toggle::after {
        content: none !important;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        min-width: 200px;
        padding: 0;
        margin-top: 5px;
        background-color: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.15);
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .dropdown-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown-item {
        padding: 10px 20px;
        color: #333333;
        transition: background-color 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .dropdown-chevron::after {
        content: "\25BE";
        display: inline-block;
        margin-left: 5px;
        transform: rotate(-90deg);
        transition: transform 0.3s ease;
    }

    .dropdown-toggle.dropdown-opened .dropdown-chevron::after {
        transform: rotate(0deg);
    }
</style>

<script>
    const dropdownMenus = document.querySelectorAll('.dropdown');

    dropdownMenus.forEach((dropdownMenu) => {
        const dropdownToggle = dropdownMenu.querySelector('.dropdown-toggle');
        const dropdownMenuList = dropdownMenu.querySelector('.dropdown-menu');

        dropdownToggle.addEventListener('click', (event) => {
            event.preventDefault();
            dropdownMenuList.classList.toggle('show');
            dropdownToggle.classList.toggle('dropdown-opened');
            dropdownToggle.classList.toggle('dropdown-closed');
        });

        document.addEventListener('click', (event) => {
            if (!dropdownMenu.contains(event.target)) {
                dropdownMenuList.classList.remove('show');
                dropdownToggle.classList.remove('dropdown-opened');
                dropdownToggle.classList.add('dropdown-closed');
            }
        });
    });
</script>