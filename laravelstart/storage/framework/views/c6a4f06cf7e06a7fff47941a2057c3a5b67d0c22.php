<?php $__env->startSection('content'); ?>
    <div class="col-md-4 col-md-offset-4">
        <?php echo Form::open(['url'=>'/auth/login']); ?>

        <!--Email Field-->
        <div class="form-group">
            <?php echo Form::label('email', 'Email:'); ?>

            <?php echo Form::email('email', null, ['class'=>'form-control']); ?>

        </div>
        <!--Password Field-->
        <div class="form-group">
            <?php echo Form::label('password', 'Password:'); ?>

            <?php echo Form::password('password', ['class'=>'form-control']); ?>

        </div>
        <?php echo Form::submit('Login', ['class'=>'btn btn-primary form-control']); ?>

        <?php echo Form::close(); ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>