<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo $__env->yieldContent('title', 'La Buena Mesa · Gestión de Menú'); ?>
    </title>

    <link rel="stylesheet"
          href="<?php echo e(asset('css/app.css')); ?>">
</head>

<body>

    
    <nav class="navbar">

        <div class="navbar__brand">
            🍽️ La Buena Mesa
        </div>

        <div class="navbar__menu">

            <a href="<?php echo e(url('/')); ?>"
               class="navbar__link">
                🏠 Principal
            </a>

            <a href="<?php echo e(url('/docs')); ?>"
               class="navbar__link">
                📚 Documentación API
            </a>

        </div>

    </nav>


    
    <header class="topbar">

        <div class="topbar__brand">

            <span class="topbar__logo">
                🍽️
            </span>

            <div>

                <h1>
                    La Buena Mesa
                </h1>

                <p>
                    Panel de gestión del menú — consume la API RESTful interna
                </p>

            </div>

        </div>

    </header>


    
    <main class="container">

        <?php echo $__env->yieldContent('content'); ?>

    </main>


    
    <footer class="footer">

        <p>
            API base:
            <code>/api/menu-items</code>
            · Proyecto académico — Laravel 12 + Eloquent
        </p>

    </footer>


    
    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>

</html><?php /**PATH C:\xampp\htdocs\kodigo\la-buena-mesa-api\resources\views/layouts/app.blade.php ENDPATH**/ ?>