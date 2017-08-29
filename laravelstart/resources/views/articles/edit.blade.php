@extends('app')

@section('content')
	<h1>{{ $article->title }}</h1>
	{!! Form::model($article, ['method'=>'PATCH', 'url' => '/articles/'.$article->id]) !!} <!--method默认post请求，且自动带token,model binding-->
		@include('articles.form')	
	{!! Form::close() !!}

	@include('errors.list') <!--视图使用include默认根目录为view-->

@stop