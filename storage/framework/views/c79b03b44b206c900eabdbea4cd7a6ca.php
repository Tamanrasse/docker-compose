<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Bankai')); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.css" rel="stylesheet">

    <!-- Fonts & Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
<!-- Scripts -->
<script src="<?php echo e(asset('js/likes.js?v=42')); ?>"></script>
<?php echo $__env->yieldContent('scripts'); ?>
<div class="min-h-screen flex">

    <!-- Sidebar fixe -->
    <div class="w-1/5 bg-gray-900 text-white p-6 flex flex-col items-center shadow-lg fixed h-screen overflow-y-auto">
        <!-- Home (Accueil) -->
        <a href="<?php echo e(route('posts.index')); ?>" class="text-white p-4 mb-4 rounded-lg hover:bg-blue-500 flex items-center w-full">
            <img src="<?php echo e(asset('images/home.png')); ?>" alt="Home" class="w-6 h-6 mr-2"> Accueil
        </a>
        <!-- Explore -->
        <a href="<?php echo e(route('search')); ?>" class="text-white p-4 mb-4 rounded-lg hover:bg-blue-500 flex items-center w-full">
            <img src="<?php echo e(asset('images/search.png')); ?>" alt="Explore" class="w-6 h-6 mr-2"> Rechercher
        </a>
        <!-- Profile -->
        <a href="<?php echo e(Auth::check() ? route('profile.show', Auth::user()->username) : route('login')); ?>"
           class="text-white p-4 mb-4 rounded-lg hover:bg-blue-500 flex items-center w-full">
            <img src="<?php echo e(asset('images/profile.png')); ?>" alt="Profile" class="w-6 h-6 mr-2"> Profil
        </a>
        <!-- Poster (visible uniquement pour les utilisateurs connectés) -->
        <?php if(Auth::check()): ?>
            <a href="<?php echo e(route('posts.create')); ?>" class="text-white p-4 mb-4 rounded-lg hover:bg-blue-500 flex items-center w-full">
                <img src="<?php echo e(asset('images/posts.png')); ?>" alt="Profile" class="w-8 h-8"> Poster
            </a>
        <?php endif; ?>
    </div>

    <!-- Contenu principal avec marges pour les sidebars -->
    <div class="flex-1 mx-[20%] mr-[20%]"> <!-- Marge gauche 25% et droite 25% -->
        <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Page Heading -->
        <?php if(isset($header)): ?>
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <?php echo e($header); ?>

                </div>
            </header>
        <?php endif; ?>

        <!-- Page Content -->
        <main class="p-6">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <!-- Sidebar droite avec image Yamamoto -->
    <div class="w-1/5 bg-gray-900 fixed right-0 h-screen">

    </div>

    <!-- Image Yamamoto en position fixed en dehors de toute sidebar -->
    <img src="<?php echo e(asset('images/yamamoto.png')); ?>" alt="Yamamoto"
         class="fixed bottom-0 right-0 h-[55vh] w-auto object-contain z-10"
         style="transform: translateX(32%);">

</div>
<!-- Scripts externes -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/locales-all.min.js"></script>

<!-- Livewire Scripts -->
<?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /var/www/resources/views/layouts/app.blade.php ENDPATH**/ ?>