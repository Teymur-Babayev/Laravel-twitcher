<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['disabled' => false, 'name' => '']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['disabled' => false, 'name' => '']); ?>
<?php foreach (array_filter((['disabled' => false, 'name' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<select name="<?php echo e($name); ?>" <?php echo e($disabled ? 'disabled' : ''); ?> <?php echo e($attributes->merge(['class' => 'appearance-none px-2 py-2 rounded-md shadow-sm border-2 border-indigo-200 outline-indigo-500 text-indigo-700 font-bold bg-white'])); ?>>
  <?php echo e($slot); ?>

</select>
<?php /**PATH /Users/crivion/Sites/php-twitcher/resources/views/components/select.blade.php ENDPATH**/ ?>