<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Article extends Model
{
    //laravel默认保护数据表，不允许直接填充数据或批量赋值  $article=App\Article::create(['title'=>'Second Title', 'content'=>'Second Content', 'published_at'=>Carbon\Carbon::n
	//ow()]); 如下语句让此3个列可以直接填充数据
    protected $fillable=['title', 'content', 'published_at'];

    //protected $dates['published_at']; //自动将赋值属性作为carbon对象处理

    //类似于Eloquent修改器，驼峰命名法，将数据存入库前，进行如下的处理，作用：setAttribute数据在存入数据库的时候需要进行预先处理，queryScope优化查询语句，方便使用会重复的语句
    public function SetPublishedAtAttribute($date){
    	$this->attributes['published_at']=Carbon::createFromFormat('Y-m-d', $date);
    }

    public function scopePublished($query){
    	$query->where('published_at', '<=', Carbon::now())->get();
    }

    public function user(){
        return $this->belongsTo('App\User'); //$article->user; 不要有括号，否则会认为下接方法->func()->func();
    }

}

 