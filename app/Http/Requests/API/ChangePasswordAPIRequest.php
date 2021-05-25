<?php


namespace App\Http\Requests\API;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use InfyOm\Generator\Request\APIRequest;

class ChangePasswordAPIRequest extends APIRequest
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
            'current_password' => 'required|max:255',
            'new_password' => 'required|between:8,20',
            'new_confirm_password' => 'required|max:255',
        ];
    }


    public function messages()
    {
        return
            [
                'current_password.required' => 'mật khẩu cũ không đúng',
                'new_password.required' => 'cần nhập mật khẩu mới',
                'new_password.between' => 'độ dài password cần nhập từ 8 - 20 kí tự',
                'new_confirm_password.required' => 'cần xác nhận password mới',
            ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json($validator->errors()->toArray(), Response::HTTP_BAD_REQUEST)
        );
    }
}
