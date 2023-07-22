<div class="nav-item dropdown no-arrow">
    <?php if (isConnected()): ?>
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Random</span>
            <img class="img-profile rounded-circle"
                src="/img/undraw_profile.svg">
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="userDropdown">
            <a class="dropdown-item" href="/account/profile">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Profil
            </a>
            <a class="dropdown-item" href="/account/setting">
                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                Paramètres
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/logout" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Déconnexion
            </a>
        </div>
    <?php else: ?>
        <a class="nav-link" href="/login">
            <i class="fas fa-lg fa-user text-gray-400"></i>
        </a>
    <?php endif; ?>
</div>