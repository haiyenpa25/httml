<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasPermissionTo('manage-permissions');
    }

    public function rules(): array
    {
        $id = $this->route('permission') ? $this->route('permission') : null;

        return [
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name' . ($id ? ",$id" : '')],
            'guard_name' => ['nullable', 'string', 'in:web'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên quyền là bắt buộc.',
            'name.unique' => 'Tên quyền đã tồn tại.',
            'guard_name.in' => 'Guard name phải là "web".',
        ];
    }
}
