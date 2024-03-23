<?php $__env->startSection('title', __("Server Requirements Check")); ?>

<?php $__env->startSection('content'); ?>
<?php $__currentLoopData = $requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<div class="flex items-center justify-between">
    <p>
        <?php echo e($module); ?>

    </p>
    <p>
        <?php if($result): ?>
        <i class="fa-solid fa-check-circle text-green-600"></i>
        <?php else: ?>
        <i class="fa-solid fa-circle-xmark text-rose-600"></i>
        <?php endif; ?>
    </p>
</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if($canContinue): ?>
<a class="mt-5 inline-block bg-rose-600 text-white font-semibold p-3 rounded-lg" href="/install/database">
    <?php echo e(__("Continue >>")); ?>

</a>
<?php else: ?>
<div class="my-5 p-3 rounded-lg bg-rose-600 text-white font-semibold">
    <?php echo e(__("Please ask your host to enable the missing extensions to continue")); ?>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('install.install-base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/crivion/Sites/twitcher/resources/views/install/requirements.blade.php ENDPATH**/ ?>