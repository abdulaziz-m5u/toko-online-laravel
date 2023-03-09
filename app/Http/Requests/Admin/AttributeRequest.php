<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'name' => ['required', 'max:255', 'unique:attributes,code'],
                    'code' => ['required', 'max:255', 'unique:attributes,name'],
                    'type' => 'required',
                    'is_required' => 'required',
                    'is_unique' => 'required',
                    'is_configurable' => 'required',
                    'is_filterable' => 'required',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => ['required', 'max:255', 'unique:attributes,name,'.$this->route()->attribute->id],
                    'code' => ['required', 'max:255', 'unique:attributes,code,'.$this->route()->attribute->id],
                    'type' => 'required',
                    'is_required' => 'required',
                    'is_unique' => 'required',
                    'is_configurable' => 'required',
                    'is_filterable' => 'required',
                ];
            }
            default: break;
        }
    }
}
