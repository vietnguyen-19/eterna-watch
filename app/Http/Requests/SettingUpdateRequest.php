<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'key' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('settings')->ignore($this->route('setting')),
            ],
            'value' => 'sometimes|required|string|max:255',
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'key.required' => 'Vui lòng nhập tên khóa cài đặt.',
            'key.string' => 'Tên khóa cài đặt phải là chuỗi ký tự.',
            'key.max' => 'Tên khóa cài đặt không được vượt quá 255 ký tự.',
            'key.unique' => 'Tên khóa cài đặt đã tồn tại.',
            'value.required' => 'Vui lòng nhập giá trị cài đặt.',
            'value.string' => 'Giá trị cài đặt phải là chuỗi ký tự.',
            'value.max' => 'Giá trị cài đặt không được vượt quá 255 ký tự.',
        ];
    }


}
