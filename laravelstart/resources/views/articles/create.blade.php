<!--使用 composer require laravelcollective/html，在config/app.php下，provider数组加“Collective\Html\HtmlServiceProvider::class,” aliases数组加“'Form'=>Collective\Html\FormFacade::class,
'Html'=>Collective\Html\HtmlFacade::class,” -->

@extends('app')

@section('content')
	<h1>撰写新文章</h1>
	{!! Form::open(['url' => '/articles']) !!} <!--默认post请求，且自动带token-->
		@include('articles.form')
	{!! Form::close() !!}
	
	<!--@if($errors->any())
		<ul class="list-group">
			@foreach($errors->all() as $error)
				<li class="list-group-item list-group-item-danger">{{ $error }}</li>
			@endforeach
		</ul>
	@endif-->
	@include('errors.list')

@stop