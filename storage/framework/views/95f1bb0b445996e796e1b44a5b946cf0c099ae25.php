<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia><?php echo e(config('reladmini.title', 'Reladmini')); ?></title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('fonts/nunito/fonts.css')); ?>" />
        

        <!-- Scripts -->
        <?php echo app('Tightenco\Ziggy\BladeRouteGenerator')->generate(); ?>
        <?php echo app('Illuminate\Foundation\Vite')->reactRefresh(); ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"]); ?>
        <?php if (!isset($__inertiaSsr)) { $__inertiaSsr = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsr instanceof \Inertia\Ssr\Response) { echo $__inertiaSsr->head; } ?>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col flex-auto flex-shrink-0">
            <?php if (isset($component)) { $__componentOriginalb013490f51a30cb3b5995d67d274073c1a17ea7b = $component; } ?>
<?php $component = App\View\Components\Translations::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('translations'); ?>
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
            <?php if (!isset($__inertiaSsr)) { $__inertiaSsr = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsr instanceof \Inertia\Ssr\Response) { echo $__inertiaSsr->body; } else { ?><div id="app" data-page="<?php echo e(json_encode($page)); ?>"></div><?php } ?>
            <div id="modal-root"></div>

            This is from reladmini-base.blade.php
        </div>
    </body>
</html>
<?php /**PATH /Users/crivion/Sites/twitcher/resources/views/vendor/reladmini/reladmini-base.blade.php ENDPATH**/ ?>