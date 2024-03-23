<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto my-20 px-5">
    <div class="mt-5 py-5 px-4 text-center bg-white rounded-lg">
        <h3 class="text-3xl text-indigo-800 heading-gradient font-black mb-5"><?php echo e(__('403 Forbidden')); ?></h3>
        <center>
            <a href="<?php echo e(route('home')); ?>">
                <img src="<?php echo e(asset('images/403.png')); ?>" alt="403 image" class="rounded-lg" />
            </a>
        </center>

        <div class="text-2xl text-center text-stone-600 mt-10 font-bold">
            <?php echo e(__('Your access to this page is restricted')); ?>

            <br /><br />
            <a href="<?php echo e(route('home')); ?>" class="font-black text-3xl heading-gradient">
                <i class="fa-solid fa-arrow-left"></i>
                <?php echo e(__('HOME')); ?>

            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('errors::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/crivion/Sites/twitcher/resources/views/errors/403.blade.php ENDPATH**/ ?>