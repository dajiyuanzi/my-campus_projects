<?php $__env->startSection('content'); ?>
	<h1><?php echo e($article->title); ?></h1>
	<?php echo Form::model($article, ['method'=>'PATCH', 'url' => '/articles/'.$article->id]); ?> <!--method默认post请求，且自动带token,model binding-->
		<?php echo $__env->make('articles.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>	
	<?php echo Form::close(); ?>


	<?php echo $__env->make('errors.list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> <!--视图使用include默认根目录为view-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>