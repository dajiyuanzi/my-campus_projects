<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Article; //不要忘记使用，否则无法实例化使用article model
use Carbon\Carbon;

use App\Http\Requests\CreateArticleRequest; //一定要写，否则会和namespace混淆path

class ArticlesController extends Controller
{
    //return artilces
    public function index(){
    	//$articles=Article::latest()->where('published_at', '<=', Carbon::now())->get(); //最新创建的数据放在前面，且只显示定时发送早于当前。但这样太长太丑。
    	//dd(Auth::user()->name);//输出用户信息
    	$articles = Article::latest()->published()->get(); //scopePublished的使用
    	return view('articles.index')->with('articles', $articles);
    }

    public function show($id){
    	$article=Article::findOrFail($id);
    	//dd($article);//调试用dd();
    	/*if (is_null($article)) {
    		abort(404);// .env的APP_DEBUG=false才显示404页面
    	}*/
    	return view('articles.show')->with('article', $article);
    }

    public function create(){
    	return view('articles.create');
    }

    public function store(CreateArticleRequest $request){ //Request中的自定义的类在此作依赖注入(reateArticleRequest $request, 不用new一个)，如果对象内的rules方法的验证未通过，store方法不会执行
    	//public function store(Request $request){方法二
    	//this->validate($request, ['title'=>'required|min:3', 'content'=>'required', 'published_at'=>'required']);//不需要article类的rule方法
    	
    	//dd($request->all());
    	//$request->get('title'); //获得单条数据
    	//接收post过来的数据
    	//存入数据库
    	//重定向
    	$input=$request->all();
    	//$input['published_at']=Carbon::now();

    	Article::create($input); // create自动过滤掉token

    	return redirect('/articles');
    }

    public function edit($id){
    	$article=Article::findOrFail($id);
    	return view('articles.edit')->with('article', $article);
    }

    public function update(CreateArticleRequest $request){ //实现表单验证
    	$article=Article::findOrFail($id);
    	$article->update($request->all());

    	return redirect('/articles');
    }

}

