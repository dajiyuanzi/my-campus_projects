<?php $__env->startSection('content'); ?>
	<h1>Articles</h1>
	<hr>
	<?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<!--<h2><a href="/articles/<?php echo e($article->id); ?>"><?php echo e($article->title); ?></a></h2>-->
		<!--<h2><a href="<?php echo e(url('articles', $article->id)); ?>"><?php echo e($article->title); ?></a></h2>-->
		<h2><a href="<?php echo e(action('ArticlesController@show', [$article->id])); ?>"><?php echo e($article->title); ?></a></h2>
		<article>
			<div class="body">
				<?php echo e($article->content); ?>

			</div>
		</article>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>