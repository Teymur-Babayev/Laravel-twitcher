<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('fonts/nunito/fonts.css')); ?>" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.jsx']); ?>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col flex-auto flex-shrink-0">
        <?php echo $__env->yieldContent('content', ''); ?>
    </div>
</body>

</html><?php /**PATH /Users/crivion/Sites/twitcher/resources/views/errors/layout.blade.php ENDPATH**/ ?>