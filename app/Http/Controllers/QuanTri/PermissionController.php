<?php

namespace App\Http\Controllers\QuanTri;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = Permission::select(['id', 'name', 'guard_name', 'created_at']);
            return DataTables::of($permissions)
                ->addColumn('action', function ($permission) {
                    return '
                        <button class="btn btn-sm btn-primary edit-permission" data-id="' . $permission->id . '">
                            <i class="fas fa-edit"></i> Sửa
                        </button>
                        <button class="btn btn-sm btn-danger delete-permission" data-id="' . $permission->id . '">
                            <i class="fas fa-trash"></i> Xóa
                        </button>';
                })
                ->editColumn('created_at', function ($permission) {
                    return $permission->created_at->format('d/m/Y H:i');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('quan-tri.permissions.index');
    }

    public function store(PermissionRequest $request)
    {
        Permission::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name ?? 'web',
        ]);

        return response()->json(['message' => 'Thêm quyền thành công!']);
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return response()->json($permission);
    }

    public function update(PermissionRequest $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name ?? 'web',
        ]);

        return response()->json(['message' => 'Cập nhật quyền thành công!']);
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response()->json(['message' => 'Xóa quyền thành công!']);
    }
}
