<?php $__env->startSection('section_title'); ?>
<strong><?php echo e(__('Live Streaming Configuration')); ?></strong>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('section_body'); ?>

<?php echo $__env->make('admin.configuration-navi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="my-5 bg-gray-200 text-gray-500 font-semibold border-2 border-gray-300 p-3 rounded">
    <?php echo e(__('In order for Live Streaming to work, as described in documentation you need an NGINX-RTMP Server')); ?>

    <br />
    If you followed the docs, the url should be in format <strong
        class="font-black">rtmp://your-site-url.tld/live</strong>
    <br /><br />
    You can get a cheap VPS from <a href="https://www.linode.com/lp/free-credit-100/" target="_blank"
        class="underline">Linode (Free $100
        credit)</a>, <a href="https://m.do.co/c/833110c66c2c" class="underline">DigitalOcean (Free $200 Credit)</a> or
    your preferred
    VPS/Dedicated hosting provider.
</div>

<div class="bg-white rounded p-3 text-stone-600">

    <form method="POST">
        <?php echo csrf_field(); ?>

        <div class="mt-5 flex md:flex-row flex-col md:space-x-5 space-y-10 md:space-y-0">
            <div class="md:w-2/3 w-full">
                <dl>
                    <dt class="font-semibold text-stone-600"><?php echo e(__('RTMP URL')); ?></dt>
                    <dd>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'text','name' => 'RTMP_URL','value' => ''.e(env('RTMP_URL')).'','class' => 'md:w-2/3 w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','name' => 'RTMP_URL','value' => ''.e(env('RTMP_URL')).'','class' => 'md:w-2/3 w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </dd>

                    <br>
                </dl>
            </div>

            <div class="md:w-2/3 w-full">
                <p class="mt-3 text-gray-600">
                    <strong class="font-bold block text-lg">
                        Your Nginx Publish URL:
                    </strong>
                    <?php echo e(route('streaming.validateKey')); ?>

                </p>
            </div>


        </div>

        <div class="flex w-full my-3">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e(__('Save Settings')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
    </form>


</div><!-- ./row -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/crivion/Sites/twitcher/resources/views/admin/streaming-config.blade.php ENDPATH**/ ?>