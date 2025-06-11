<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto mt-10 p-4">
        <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-6">Mon Calendrier</h1>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('calendar', []);

$__html = app('livewire')->mount($__name, $__params, 'calendar', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/calendar.blade.php ENDPATH**/ ?>