<?php


namespace App\Http\Requests\API;


use App\Models\Product;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use InfyOm\Generator\Request\APIRequest;

class CreateProductAPIRequest extends APIRequest
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
        return Product::$rules;
    }

    public function messages()
    {
        return
            [
                'poster.required' => 'cần gửi ảnh lên',
                'poster.image' => 'file gửi lên cần là ảnh',
                'poster.mimes' => 'ảnh gửi lên cần thuộc các định dạng jpeg,png,jpg,gif,svg.'
            ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json($validator->errors()->toArray(), Response::HTTP_BAD_REQUEST)
        );
    }

}
