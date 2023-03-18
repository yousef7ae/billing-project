<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Section;

class SectionRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            
            'section_name'=>'required|unique:Section|string',
            'description'=>'required|string'
        ];
    }

    public function messages(){
        
        return[

        'section_name.required' =>'section name is required',
        'section_name.unique' => 'section exists already',
        'section_name.string' =>' section name type is string',
        'description.string' =>'description type is string'
        
         ];
    }
}
