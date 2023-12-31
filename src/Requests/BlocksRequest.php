<?php

namespace Azuriom\Plugin\BlockClicker\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlocksRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'minecraft_id' => ['required', 'string', 'max:100'],
            'image' => ['required', 'string'],
            'required_click' => ['required', 'integer'],
            'luck' => ['required', 'integer'],
            'size' => ['required', 'integer']
        ];
    }
}