<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasPermissionTo('manage-roles');
    }

    public function rules(): array
    {
        $id = $this->route('role') ? $this->route('role') : null;

        return [
            'name' => ['required', 'string', 'max:255', 'unique:roles,name' . ($id ? ",$id" : '')],
            'guard_name' => ['nullable', 'string', 'in:web'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên vai trò là bắt buộc.',
            'name.unique' => 'Tên vai trò đã tồn tại.',
            'guard_name.in' => 'Guard name phải là "web".',
        ];
    }
}
