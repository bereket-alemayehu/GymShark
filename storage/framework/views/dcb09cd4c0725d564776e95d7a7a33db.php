<div
    <?php echo e($attributes
            ->merge([
                'id' => $getId(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)); ?>

>
    <?php echo e($getChildComponentContainer()); ?>

</div>
<?php /**PATH C:\xampp\htdocs\Gymshark\vendor\filament\forms\src\/../resources/views/components/grid.blade.php ENDPATH**/ ?>