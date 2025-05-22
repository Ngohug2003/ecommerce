<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cho phép tất cả (nếu bạn không cần giới hạn)
    }

    public function rules()
    {
        $userId = $this->route('user'); // hoặc null nếu đang tạo mới

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email' . ($userId ? ',' . $userId : ''),
            'is_admin' => 'boolean',
        ];

        // Nếu là tạo mới (không có userId), yêu cầu password
        if (!$userId) {
            $rules['password'] = 'required|min:6|confirmed';
        }

        return $rules;
    }
}
