<?php
// Este archivo solo debe contener el HTML de la barra de navegación superior.
// Las variables como $d, $usuario, $admin, etc., deben ser definidas en las páginas
// que incluyan este archivo (por ejemplo, fc.php o board.php).

// Se asume que las variables $d, $usuario, $admin ya están definidas.
// Si el usuario no está logueado, la redirección ya se maneja en el archivo principal.
?>
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="board.php">INICIO</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 ms-auto me-4 me-lg-0" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    <a style="color:FFF" href="#"></a>
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"
               id="navbarDropdown" href="#"
               role="button" data-bs-toggle="dropdown"
               aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
                <?php echo ucwords(strtolower($d->nombres)) . " " . ucwords(strtolower($d->apellidos)); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">Configuración</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="logout.php">Salir</a></li>
            </ul>
        </li>
    </ul>
</nav>
