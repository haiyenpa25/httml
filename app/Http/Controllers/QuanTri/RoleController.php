<?php

namespace App\Http\Controllers\QuanTri;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::select(['id', 'name', 'guard_name', 'created_at']);
            return DataTables::of($roles)
                ->addColumn('action', function ($role) {
                    return '
                        <button class="btn btn-sm btn-primary edit-role" data-id="' . $role->id . '">
                            <i class="fas fa-edit"></i> Sửa
                        </button>
                        <button class="btn btn-sm btn-danger delete-role" data-id="' . $role->id . '">
                            <i class="fas fa-trash"></i> Xóa
                        </button>';
                })
                ->editColumn('created_at', function ($role) {
                    return $role->created_at->format('d/m/Y H:i');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('quan-tri.roles.index');
    }

    public function store(RoleRequest $request)
    {
        Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name ?? 'web',
        ]);

        return response()->json(['message' => 'Thêm vai trò thành công!']);
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role);
    }

    public function update(RoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name ?? 'web',
        ]);

        return response()->json(['message' => 'Cập nhật vai trò thành công!']);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['message' => 'Xóa vai trò thành công!']);
    }
}
