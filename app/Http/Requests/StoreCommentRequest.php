<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'post_id' => 'required|integer',
            'parent_id' => 'integer|exists:comments,id',
            'author_name' => 'required|string|min:1|max:50',
            'text' => 'string|min:1'
        ];
    }

    public function messages()
    {
        return [
            'post_id.required' => 'A date is required',
            'post_id.date_format'  => 'A date must be in format: Y-m-d',
            'post_id.unique'  => 'This date is already taken',
            'post_id.after_or_equal'  => 'A date must be after or equal today',
            'post_id.exists'  => 'This date doesn\'t exists',
        ];
    }
}
