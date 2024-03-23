<?php $__env->startSection('title', __("Database Configuration")); ?>

<?php $__env->startSection('content'); ?>

<form method="POST" action=<?php echo e(route('installer.saveDB')); ?>>
    <?php echo csrf_field(); ?>
    <label class="text-gray-500 block mb-1 font-semibold"><?php echo e(__("Database Host")); ?></label>
    <input type="text" class="border-2 p-2 block w-full rounded-lg" name="DB_HOST"
        value="<?php echo e(old('DB_HOST', 'localhost')); ?>" required />

    <label class="text-gray-500 block mt-3 font-semibold"><?php echo e(__("Database Name")); ?></label>
    <input type="text" class="border-2 p-2 block w-full rounded-lg" name="DB_DATABASE" value="<?php echo e(old('DB_DATABASE')); ?>"
        required />

    <label class="text-gray-500 block mt-3 font-semibold"><?php echo e(__("Database User")); ?></label>
    <input type="text" class="border-2 p-2 block w-full rounded-lg" name="DB_USERNAME" value="<?php echo e(old('DB_USERNAME')); ?>"
        required />

    <label class="text-gray-500 block mt-3 font-semibold"><?php echo e(__("Database Password")); ?></label>
    <input type="text" class="border-2 mb-3 p-2 block w-full rounded-lg" name="DB_PASSWORD"
        value="<?php echo e(old('DB_PASSWORD')); ?>" />

    <button class="bg-rose-600 text-white font-semibold block p-3 rounded-lg" type="submit" name="sb">
        <?php echo e(__("Continue>>")); ?>

    </button>

</form>

<?php if($errors->any()): ?>
<div class="my-5 p-3 rounded-lg bg-rose-600 text-white font-semibold">
    <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<?php if(session()->has('message')): ?>
<div class="my-5 p-3 rounded-lg bg-rose-600 text-white font-semibold">
    <?php echo e(session('message')); ?>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('install.install-base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/crivion/Sites/twitcher/resources/views/install/database.blade.php ENDPATH**/ ?>