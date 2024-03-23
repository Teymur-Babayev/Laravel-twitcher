<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?php echo e(asset(opt('favicon', 'favicon.png'))); ?>" sizes="128x128" />

    <title inertia><?php echo e(opt('seo_title')); ?></title>

    <?php if(request()->route() && request()->route()->getName() == 'home'): ?>
    <meta name="description" content="<?php echo e(opt('seo_desc')); ?>" />
    <meta name="keywords" content="<?php echo e(opt('seo_keys')); ?>" />
    <?php endif; ?>

    <?php if(request()->route() && request()->route()->getName() == 'channel'): ?>
    <?php
    $streamUser = \App\Models\User::whereUsername(request()->user)->firstOrFail();
    ?>
    <meta property="og:title" content="<?php echo e(__(" :channelName channel (:handle)", ['channelName'=> $streamUser->name,
    'handle' => '@' . $streamUser->username])); ?>" />
    <meta property="og:url" content="<?php echo e(route('channel', ['user' => $streamUser->username])); ?>" />
    <meta property="og:image" content="<?php echo e($streamUser->cover_picture); ?>" />
    <?php endif; ?>

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('fonts/nunito/fonts.css')); ?>" />

    <script>
        window.PUSHER_KEY = '<?php echo e(env('PUSHER_APP_KEY')); ?>';
        window.PUSHER_CLUSTER = '<?php echo e(env('PUSHER_APP_CLUSTER')); ?>';
    </script>

    <!-- Scripts -->
    <?php echo app('Tightenco\Ziggy\BladeRouteGenerator')->generate(); ?>
    <?php echo app('Illuminate\Foundation\Vite')->reactRefresh(); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"]); ?>
    <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->head; } ?>

</head>

<body class="font-sans antialiased ">
    <div class="min-h-screen flex flex-col flex-auto flex-shrink-0">
        <?php if (isset($component)) { $__componentOriginalb013490f51a30cb3b5995d67d274073c1a17ea7b = $component; } ?>
<?php $component = App\View\Components\Translations::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('Translations'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Translations::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb013490f51a30cb3b5995d67d274073c1a17ea7b)): ?>
<?php $component = $__componentOriginalb013490f51a30cb3b5995d67d274073c1a17ea7b; ?>
<?php unset($__componentOriginalb013490f51a30cb3b5995d67d274073c1a17ea7b); ?>
<?php endif; ?>
        <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->body; } else { ?><div id="app" data-page="<?php echo e(json_encode($page)); ?>"></div><?php } ?>
        <div id="modal-root"></div>
    </div>
</body>

</html><?php /**PATH /Users/crivion/Sites/twitcher/resources/views/app.blade.php ENDPATH**/ ?>