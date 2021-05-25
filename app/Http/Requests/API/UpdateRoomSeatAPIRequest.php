<?php

namespace App\Http\Requests\API;

use App\Models\RoomSeat;
use InfyOm\Generator\Request\APIRequest;

class UpdateRoomSeatAPIRequest extends APIRequest
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
        $rules = RoomSeat::$rules;
        
        return $rules;
    }
}
