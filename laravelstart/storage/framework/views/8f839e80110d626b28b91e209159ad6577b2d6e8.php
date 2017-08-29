<div class="form-group">
	<?php echo Form::label('title'); ?>

	<?php echo Form::text('title', null, ['class'=>'form-control']); ?>

</div>

<div class="form-group">
	<?php echo Form::label('content', 'Content:'); ?>

	<?php echo Form::textarea('content', null, ['class'=>'form-control']); ?>

</div>

<div class="form-group">
	<?php echo Form::label('published_at', 'Published_at:'); ?>

	<?php echo Form::input('date', 'published_at', date('Y-m-d'), ['class'=>'form-control']); ?>

</div>

<?php echo Form::submit('发表文章', ['class'=>'btn btn-primary form-control']); ?>