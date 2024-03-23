<div class="bg-white rounded p-3 my-5 text-gray-200">
    <a href="/admin/configuration"
        class="text-lg mr-2 text-indigo-600 hover:text-indigo-500 font-semibold <?php if(isset($active) && $active == 'configuration'): ?> border-b-indigo-600 font-bold border-b-2 <?php endif; ?>">
        <?php echo e(__('General')); ?>

    </a>
    |
    <a href="/admin/configuration/payment"
        class="text-lg mx-2 text-indigo-600 hover:text-indigo-500 font-semibold <?php if(isset($active) && $active == 'payments'): ?> underline <?php endif; ?>">
        <?php echo e(__('Payment Gateways')); ?>

    </a>
    |
    <a href="/admin/configuration/streaming"
        class="text-lg mx-2 text-indigo-600 hover:text-indigo-500 font-semibold <?php if(isset($active) && $active == 'streaming'): ?> underline <?php endif; ?>">
        <?php echo e(__('Live Streaming')); ?>

    </a>
    |
    <a href="/admin/configuration/chat"
        class="text-lg ml-2 text-indigo-600 hover:text-indigo-500 font-semibold <?php if(isset($active) && $active == 'chat'): ?> underline <?php endif; ?>">
        <?php echo e(__('Live Chat')); ?>

    </a>
</div><?php /**PATH /Users/crivion/Sites/php-twitcher/resources/views/admin/configuration-navi.blade.php ENDPATH**/ ?>