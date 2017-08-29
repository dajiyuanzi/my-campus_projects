<!--使用 composer require laravelcollective/html，在config/app.php下，provider数组加“Collective\Html\HtmlServiceProvider::class,” aliases数组加“'Form'=>Collective\Html\FormFacade::class,
'Html'=>Collective\Html\HtmlFacade::class,” -->



<?php $__env->startSection('content'); ?>
	<h1>撰写新文章</h1>
	<?php echo Form::open(['url' => '/articles']); ?> <!--默认post请求，且自动带token-->
		<?php echo $__env->make('articles.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo Form::close(); ?>

	
	<!--<?php if($errors->any()): ?>
		<ul class="list-group">
			<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<li class="list-group-item list-group-item-danger"><?php echo e($error); ?></li>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ul>
	<?php endif; ?>-->
	<?php echo $__env->make('errors.list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>