<?php
namespace App\Http\Controllers;
use App\Models\NguoiDung;
use App\Models\TinHuu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // Thêm Log

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = NguoiDung::with('tinHuu')->get();
        return view('_nguoi_dung.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tinHuuList = TinHuu::all();
        return view('_nguoi_dung.create', compact('tinHuuList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'email' => 'required|string|email|max:255|unique:nguoi_dung',
            'mat_khau' => 'required|string|min:8|confirmed',
            'vai_tro' => 'required|in:quan_tri,truong_ban,thanh_vien',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            NguoiDung::create([
                'tin_huu_id' => $request->tin_huu_id,
                'email' => $request->email,
                'mat_khau' => Hash::make($request->mat_khau),
                'vai_tro' => $request->vai_tro,
            ]);

            return redirect()->route('nguoi-dung.index')->with('success', 'Người dùng đã được tạo thành công.');
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo người dùng: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi tạo người dùng. Vui lòng thử lại.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NguoiDung  $nguoiDung
     * @return \Illuminate\Http\Response
     */
    public function show(NguoiDung $nguoiDung)
    {
        return view('_nguoi_dung.show', compact('nguoiDung'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NguoiDung  $nguoiDung
     * @return \Illuminate\Http\Response
     */
    public function edit(NguoiDung $nguoiDung)
    {
        $tinHuuList = TinHuu::all();
        return view('_nguoi_dung.edit', compact('nguoiDung', 'tinHuuList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NguoiDung  $nguoiDung
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NguoiDung $nguoiDung)
    {
        $validator = Validator::make($request->all(), [
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'email' => 'required|string|email|max:255|unique:nguoi_dung,email,' . $nguoiDung->id,
            'mat_khau' => 'nullable|string|min:8|confirmed',
            'vai_tro' => 'required|in:quan_tri,truong_ban,thanh_vien',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $nguoiDung->update([
                'tin_huu_id' => $request->tin_huu_id,
                'email' => $request->email,
                'mat_khau' => $request->mat_khau ? Hash::make($request->mat_khau) : $nguoiDung->mat_khau,
                'vai_tro' => $request->vai_tro,
            ]);

            return redirect()->route('nguoi-dung.index')->with('success', 'Người dùng đã được cập nhật thành công.');
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật người dùng: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật người dùng. Vui lòng thử lại.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NguoiDung  $nguoiDung
     * @return \Illuminate\Http\Response
     */
    public function destroy(NguoiDung $nguoiDung)
    {
        try {
            $nguoiDung->delete();
            return redirect()->route('nguoi-dung.index')->with('success', 'Người dùng đã được xóa thành công.');
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa người dùng: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi xóa người dùng. Vui lòng thử lại.');
        }
    }
}