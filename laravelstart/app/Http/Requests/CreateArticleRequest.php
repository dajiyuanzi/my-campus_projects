<?php
//php artisan make:request CreateArticleRequest 实现表单验证

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //false时用户A发布的文章不能由用户B发布，当前未便携用户系统，所以暂时改为true，所有用户都可以随便改别人的文章
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //各种验证规则：皆不为空
            'title'=>'required|min:3', //最少长度为3
            'content'=>'required',
            'published_at'=>'required'
        ];

        /*也可以设定不一样的验证规则，如下：
        $rules=[
            //各种验证规则：皆不为空
            'title'=>'required|min:3', //最少长度为3
            'content'=>'required',
            'published_at'=>'required'
        ];

        if(isEdit()){
            $rules['something']='required';
        }

        return $rules;
         */
        }
    }
}
