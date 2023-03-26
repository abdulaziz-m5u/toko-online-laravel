<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
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
                    'title' => ['required', 'max:255', 'string'],
                    'url' => ['required', 'max:255', 'string'],
                    'path' => ['required','image','mimes:jpeg,png,jpg,gif','max:4096'],
                    'body' => ['required', 'string'],
                    'status' => ['required', 'string']
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title' => ['required', 'max:255', 'string'],
                    'url' => ['required', 'max:255', 'string'],
                    'path' => ['image','mimes:jpeg,png,jpg,gif','max:4096'],
                    'body' => ['required', 'string'],
                    'status' => ['required', 'string']
                ];
            }
            default: break;
        }
    }
}
