<?php

namespace Azuriom\Plugin\BlockClicker\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayersRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'block_id' => ['required', 'exists:blockclicker_block,id'],
            'amount' => ['required', 'integer']
        ];
    }
}