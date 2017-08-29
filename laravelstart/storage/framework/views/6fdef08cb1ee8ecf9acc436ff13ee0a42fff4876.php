<?php $__env->startSection('content'); ?>
	<h1><?php echo e($article->title); ?></h1>
	<hr>
	<h2><a href="#"><?php echo e($article->title); ?></a></h2>
	<article>
		<div class="body">
			<?php echo e($article->content); ?>

		</div>
	</article>	
<?php $__env->stopSection(); ?>	
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>