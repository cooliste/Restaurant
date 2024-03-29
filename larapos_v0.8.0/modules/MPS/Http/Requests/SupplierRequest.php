<?php

namespace Modules\MPS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize()
    {
        return true; // TODO:
    }

    public function rules()
    {
        return [
            'name'             => 'required',
            'phone'            => 'nullable',
            'company'          => 'nullable',
            'address'          => 'nullable',
            'extra_attributes' => 'nullable',
            'house_no'         => 'nullable',
            'street_no'        => 'nullable',
            'city'             => 'nullable',
            'postal_code'      => 'nullable',
            'email'            => 'nullable|email',
            'max_due_amount'   => 'nullable|numeric',
            'opening_balance'  => 'nullable|numeric',
            'due_limit'        => 'nullable|numeric',
            'state'            => session('require_country') == 1 ? 'required' : 'nullable',
            'country'          => session('require_country') == 1 ? 'required' : 'nullable',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = $this->validator->validated();
        if (!empty($data['country']) && !empty($data['state'])) {
            $cs                   = getCS($data['country'], $data['state']);
            $data['state_name']   = $cs['state']->name;
            $data['country_name'] = $cs['country']->name;
        }
        if (!$this->id) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }
}
