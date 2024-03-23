<?php $__env->startSection('section_title'); ?>
<strong><?php echo e(__('Mail Configuration')); ?></strong>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('section_body'); ?>
<form method="POST">
    <?php echo csrf_field(); ?>
    <div class="rounded p-3 bg-white">
        <dl>
            <dt class="font-semibold text-stone-600"><?php echo e(__('Mail Driver')); ?></dt>
            <dd>
                <input type="radio" name="MAIL_MAILER" value="log" <?php if(env('MAIL_MAILER')=='log' ): ?> checked <?php endif; ?> />
                <?php echo e(__('Log')); ?>

                <input type="radio" name="MAIL_MAILER" value="smtp" <?php if(env('MAIL_MAILER')=='smtp' ): ?> checked <?php endif; ?> />
                <?php echo e(__('SMTP')); ?>

            </dd>
            <br>
            <dt class="font-semibold text-stone-600"><?php echo e(__('SMTP Mail Server')); ?></dt>
            <dd>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'text','name' => 'MAIL_HOST','value' => ''.e(env('MAIL_HOST')).'','class' => 'lg:w-2/3 w-full','placeholder' => 'smtp.example.com']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','name' => 'MAIL_HOST','value' => ''.e(env('MAIL_HOST')).'','class' => 'lg:w-2/3 w-full','placeholder' => 'smtp.example.com']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </dd>
            <dt class="font-semibold text-stone-600 mt-3"><?php echo e(__('SMTP Mail Port')); ?></dt>
            <dd>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'number','name' => 'MAIL_PORT','value' => ''.e(env('MAIL_PORT')).'','class' => 'lg:w-2/3 w-full','placeholder' => '465']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','name' => 'MAIL_PORT','value' => ''.e(env('MAIL_PORT')).'','class' => 'lg:w-2/3 w-full','placeholder' => '465']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </dd>
            <dt class="font-semibold text-stone-600 mt-3"><?php echo e(__('SMTP Mail Username')); ?></dt>
            <dd>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'text','name' => 'MAIL_USERNAME','value' => ''.e(env('MAIL_USERNAME')).'','class' => 'lg:w-2/3 w-full','placeholder' => 'you@example.com']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','name' => 'MAIL_USERNAME','value' => ''.e(env('MAIL_USERNAME')).'','class' => 'lg:w-2/3 w-full','placeholder' => 'you@example.com']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </dd>
            <dt class="font-semibold text-stone-600 mt-3"><?php echo e(__('SMTP Mail Password')); ?></dt>
            <dd>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'password','name' => 'MAIL_PASSWORD','value' => ''.e(env('MAIL_PASSWORD')).'','class' => 'lg:w-2/3 w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'password','name' => 'MAIL_PASSWORD','value' => ''.e(env('MAIL_PASSWORD')).'','class' => 'lg:w-2/3 w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </dd>
            <dt class="font-semibold text-stone-600 mt-3"><?php echo e(__('SMTP Mail Encryption')); ?></dt>
            <dd>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.select','data' => ['class' => 'lg:w-2/3 w-full','name' => 'MAIL_ENCRYPTION']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'lg:w-2/3 w-full','name' => 'MAIL_ENCRYPTION']); ?>
                    <option value="null" <?php if(env('MAIL_ENCRYPTION')=='null' ): ?> selected <?php endif; ?>><?php echo e(__('None')); ?></option>
                    <option value="ssl" <?php if(env('MAIL_ENCRYPTION')=='ssl' ): ?> selected <?php endif; ?>><?php echo e(__('SSL')); ?></option>
                    <option value="tls" <?php if(env('MAIL_ENCRYPTION')=='tls' ): ?> selected <?php endif; ?>><?php echo e(__('TLS')); ?></option>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </dd>
            <dt class="font-semibold text-stone-600 mt-3"><?php echo e(__('SMTP Mail From: (username@domain.com)')); ?></dt>
            <dd>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input','data' => ['type' => 'text','name' => 'MAIL_FROM_ADDRESS','value' => ''.e(env('MAIL_FROM_ADDRESS')).'','class' => 'lg:w-2/3 w-full','placeholder' => 'you@example.com']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','name' => 'MAIL_FROM_ADDRESS','value' => ''.e(env('MAIL_FROM_ADDRESS')).'','class' => 'lg:w-2/3 w-full','placeholder' => 'you@example.com']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </dd>
            <dt class="font-semibold text-stone-600">&nbsp;</dt>
            <dd>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e(__('Save Mail Settings')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <hr class="my-5" />
                <a href="/admin/mailtest" class="text-orange-600 hover:underline"><?php echo e(__('Send Test Email (use after
                    hitting Save first)')); ?></a>
            </dd>
        </dl>
    </div><!-- ./row -->
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/crivion/Sites/twitcher/resources/views/admin/mail-configuration.blade.php ENDPATH**/ ?>