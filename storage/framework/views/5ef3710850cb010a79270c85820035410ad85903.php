<?php $__env->startSection('title', __("Installation Successful")); ?>

<?php $__env->startSection('content'); ?>

<div class="my-5 p-3 rounded-lg bg-green-500 text-white font-semibold">
    <?php echo e(__("You may now login with the default admin user and update it's user/password")); ?>

</div>

<div class="my-5">
    <strong class="block font-semibold text-lg">
        Default Admin Username
    </strong>
    <span class="block mt-2">
        admin@example.org
    </span>

    <strong class="block font-semibold text-lg mt-5">
        Default Admin Password
    </strong>
    <span class="block mt-2">
        adminer
    </span>
</div>

<a class="mt-5 inline-block bg-green-500 text-white font-semibold p-3 rounded-lg" href=<?php echo e(route('admin.login')); ?>>
    <?php echo e(__("Admin Panel >>")); ?>

</a>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('install.install-base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/crivion/Sites/php-twitcher/resources/views/install/finished.blade.php ENDPATH**/ ?>