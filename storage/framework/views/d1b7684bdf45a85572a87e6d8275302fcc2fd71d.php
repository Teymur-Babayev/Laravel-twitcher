<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo e(asset(opt('favicon', 'favicon.png'))); ?>" sizes="128x128" />

    <title><?php echo e(config('app.name', '--')); ?></title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles & Scripts -->
    <link rel="stylesheet" href="<?php echo e(asset('css/style.min.css')); ?>" />
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        <?php echo e($slot); ?>

    </div>
</body>

</html><?php /**PATH /Users/crivion/Sites/twitcher/resources/views/components/guest-layout.blade.php ENDPATH**/ ?>