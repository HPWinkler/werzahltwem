<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTnRequest extends FormRequest
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
        /*return [
            'title'        => 'required|max:255',
        ];*/

        $rules = [
            'title' => 'required|max:255',
            'tv'    => 'array|min:1',
        ];
        foreach($this->request->get('tv') as $key => $val){
            $rules['tv.'.$key.'.tn_name'] = 'required|unique:groups';
            $rules['tv.'.$key.'.mussZahlen'] = 'required';
        }
        return $rules;
    }


}
