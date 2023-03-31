<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @bodyParam title string required 할일 제목 Example: 책 읽기
 * @bodyParam content longText 할일 내용. Example: 자기개발에 대한 책을 읽자
 * @bodyParam deadline date 마감기한 No-example
 * @bodyParam isDone boolean required 완료여부 Example: true
 */

class TodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //return false; 로그인 여부
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {

        #디비구조
        #할일:
        #제목 : string required
        #내용 : longtext optional
        #마감기한 : date optional
        #완료여부 : boolean default false

        return [
            'title' => 'required|max:50',
            'content' => 'max:255',
            'deadline' => 'date',
            'isDone' => 'required|boolean',
        ];
    }
}
