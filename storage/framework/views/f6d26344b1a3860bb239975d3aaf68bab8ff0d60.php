<?php $__env->startPush('adminExtraCSS'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/morris.css')); ?>" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('extra_top'); ?>
<div class="md:flex items-center">

    <div class="rounded-lg bg-yellow-400 text-white px-10 py-3 border-2 border-white shadow-md">
        <h1 class="text-2xl font-bold text-center"><?php echo e($allUsers); ?></h1>
        <h2 class="text-xl text-center">
            <?php if($allUsers == 1): ?>
            <?php echo e(__('User')); ?>

            <?php else: ?>
            <?php echo e(__('Users')); ?>

            <?php endif; ?>
        </h2>
    </div>

    <div class="rounded-lg md:ml-5 bg-blue-400 text-white px-10 py-3 border-2 border-white shadow-md">
        <h1 class="text-2xl font-bold text-center"><?php echo e($allStreamers); ?></h1>
        <h2 class="text-xl text-center">
            <?php echo e(__('Streamers')); ?>

        </h2>
    </div>

    <div class="rounded-lg md:ml-5 bg-green-500 text-white px-10 py-3 border-2 border-white shadow-md">
        <h1 class="text-2xl font-bold text-center"><?php echo e(__('Tokens Sold')); ?></h1>
        <h2 class="text-xl text-center">
            <?php echo e($tokensSold); ?>

        </h2>
    </div>

    <div class="rounded-lg md:ml-5 bg-rose-500 text-white px-10 py-3 border-2 border-white shadow-md">
        <h1 class="text-2xl font-bold text-center"><?php echo e(__('Earnings')); ?></h1>
        <h2 class="text-xl text-center">
            <?php echo e(opt('payment-settings.currency_symbol') . $tokensAmount); ?>

        </h2>
    </div>

</div>

<div class="w-full bg-white mt-10 rounded p-3">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border"><strong><?php echo e(__('Past 30 Days')); ?></strong></div>
            <div class="box-body">
                <!-- LINE CHART -->
                <div class="chart-responsive">
                    <div class="chart" id="past-30-days"></div>

                </div><!-- subscription earnings -->
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('section_title'); ?>
    <strong><?php echo e(__('Dashboard Stats')); ?></strong>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('section_body'); ?>
    <?php $__env->stopSection(); ?>

    <?php $__env->startPush('adminExtraJS'); ?>
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/morris.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/raphael-min.js')); ?>"></script>

    
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
                new Morris.Line({
                    // ID of the element in which to draw the chart.
                    element: 'past-30-days',
                    // Chart data records -- each entry in this array corresponds to a point on
                    // the chart.
                    data: [
                        <?php if(isset($earnings) and count($earnings)): ?>
                            <?php $__currentLoopData = $earnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                {
                                    date: '<?php echo e($d['date']); ?>',
                                    amount: '<?php echo e($d['amount']); ?>',
                                    tokens: '<?php echo e($d['tokens']); ?>',
                                },
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            {
                                date: '<?php echo e(date('jS F Y')); ?>',
                                amount: 0,
                                tokens: 0,
                            }
                        <?php endif; ?>
                    ],
                    // The name of the data record attribute that contains x-values.
                    xkey: 'date',
                    // A list of names of data record attributes that contain y-values.
                    ykeys: ['tokens', 'amount'],
                    // Labels for the ykeys -- will be displayed when you hover over the
                    // chart.
                    labels: ['<?php echo e(__("Amount")); ?>', '<?php echo e(__("Tokens")); ?>']
                });
            });
    </script>
    <?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/crivion/Sites/php-twitcher/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>