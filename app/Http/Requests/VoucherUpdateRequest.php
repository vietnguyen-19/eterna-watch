<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VoucherUpdateRequest extends FormRequest
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
        $voucherId = $this->route('voucher') ? $this->route('voucher')->id : null;

        return [
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('vouchers')->ignore($voucherId)
            ],
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0|max:99999999.99',
            'min_order' => 'nullable|numeric|min:0|max:99999999.99',
            'max_uses' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'expires_at' => 'nullable|date|after:start_date',
            'status' => 'sometimes|in:active,expired',
            'used_count' => 'sometimes|integer|min:0'
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
            'name.required' => 'Tên voucher là bắt buộc.',
            'name.max' => 'Tên voucher không được vượt quá 255 ký tự.',

            'code.required' => 'Mã voucher là bắt buộc.',
            'code.max' => 'Mã voucher không được vượt quá 50 ký tự.',
            'code.unique' => 'Mã voucher đã tồn tại.',

            'discount_type.required' => 'Loại giảm giá là bắt buộc.',
            'discount_type.in' => 'Loại giảm giá không hợp lệ (chỉ chấp nhận percent hoặc fixed).',

            'discount_value.required' => 'Giá trị giảm giá là bắt buộc.',
            'discount_value.numeric' => 'Giá trị giảm giá phải là số.',
            'discount_value.min' => 'Giá trị giảm giá không được nhỏ hơn 0.',
            'discount_value.max' => 'Giá trị giảm giá không được vượt quá 99,999,999.99.',

            'min_order.numeric' => 'Đơn hàng tối thiểu phải là số.',
            'min_order.min' => 'Đơn hàng tối thiểu không được nhỏ hơn 0.',
            'min_order.max' => 'Đơn hàng tối đa không được vượt quá 99,999,999.99.',

            'max_uses.integer' => 'Số lần sử dụng tối đa phải là số nguyên.',
            'max_uses.min' => 'Số lần sử dụng tối đa không được nhỏ hơn 1.',

            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',

            'expires_at.date' => 'Ngày hết hạn không hợp lệ.',
            'expires_at.after' => 'Ngày hết hạn phải sau ngày bắt đầu.',

            'status.in' => 'Trạng thái không hợp lệ (chỉ chấp nhận active hoặc expired).',

            'used_count.integer' => 'Số lần đã sử dụng phải là số nguyên.',
            'used_count.min' => 'Số lần đã sử dụng không được nhỏ hơn 0.'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Chuẩn hóa dữ liệu trước khi validate
        if ($this->has('code')) {
            $this->merge([
                'code' => strtoupper(trim($this->code))
            ]);
        }
    }
}
