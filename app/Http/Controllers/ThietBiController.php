<?php

namespace App\Http\Controllers;

use App\Models\ThietBi;
use App\Models\BanNganh;
use App\Models\TinHuu;
use App\Models\NhaCungCap;
use App\Models\LichSuBaoTri;
use App\Models\GiaoDichTaiChinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ThietBiController extends Controller
{
    /**
     * Hiển thị danh sách thiết bị
     */
    public function index()
    {
        $banNganhs = BanNganh::all();
        return view('_thiet_bi.index', compact('banNganhs'));
    }

    /**
     * Lấy danh sách thiết bị dạng JSON cho DataTables
     */
    public function getThietBis(Request $request)
    {
        try {
            $query = ThietBi::with(['banNganh', 'nguoiQuanLy', 'nhaCungCap']);

            // Lọc theo loại thiết bị
            if ($request->has('loai') && $request->loai) {
                $query->where('loai', $request->loai);
            }

            // Lọc theo tình trạng
            if ($request->has('tinh_trang') && $request->tinh_trang) {
                $query->where('tinh_trang', $request->tinh_trang);
            }

            // Lọc theo ban ngành
            if ($request->has('ban_nganh_id') && $request->ban_nganh_id) {
                $query->where('id_ban', $request->ban_nganh_id);
            }

            // Lọc theo vị trí
            if ($request->has('vi_tri') && $request->vi_tri) {
                $query->where('vi_tri_hien_tai', 'like', '%' . $request->vi_tri . '%');
            }

            $thietBis = $query->get();

            return response()->json($thietBis);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy danh sách thiết bị: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể lấy danh sách thiết bị'], 500);
        }
    }

    /**
     * Hiển thị form tạo thiết bị mới
     */
    public function create()
    {
        $banNganhs = BanNganh::all();
        $tinHuus = TinHuu::all();
        $nhaCungCaps = NhaCungCap::all();
        $loaiThietBis = ThietBi::LOAI_THIET_BI;
        $tinhTrangs = ThietBi::TINH_TRANG;
        dd($banNganhs, $tinHuus, $nhaCungCaps, $loaiThietBis, $tinhTrangs);

        return view('_thiet_bi.create', compact('banNganhs', 'tinHuus', 'nhaCungCaps', 'loaiThietBis', 'tinhTrangs'));
    }

    /**
     * Lưu thiết bị mới
     */
    public function store(Request $request)
    {
        Log::info('Bắt đầu xử lý yêu cầu thêm thiết bị', ['request' => $request->all()]);

        try {
            $validated = $request->validate([
                'ten' => 'required|string|max:255',
                'loai' => ['required', Rule::in(array_keys(ThietBi::LOAI_THIET_BI))],
                'tinh_trang' => ['required', Rule::in(array_keys(ThietBi::TINH_TRANG))],
                'nha_cung_cap_id' => 'nullable|exists:nha_cung_cap,id',
                'ngay_mua' => 'nullable|date',
                'gia_tri' => 'nullable|numeric|min:0',
                'nguoi_quan_ly_id' => 'nullable|exists:tin_huu,id',
                'id_ban' => 'nullable|exists:ban_nganh,id',
                'vi_tri_hien_tai' => 'nullable|string|max:255',
                'thoi_gian_bao_hanh' => 'nullable|date',
                'chu_ky_bao_tri' => 'nullable|integer|min:1',
                'ngay_het_han_su_dung' => 'nullable|date',
                'ma_tai_san' => 'nullable|string|max:50',
                'hinh_anh' => 'nullable|image|max:2048',
                'mo_ta' => 'nullable|string'
            ]);

            Log::info('Dữ liệu sau khi validate:', ['validated' => $validated]);

            // Xử lý upload hình ảnh
            if ($request->hasFile('hinh_anh')) {
                $path = $request->file('hinh_anh')->store('thiet_bi', 'public');
                $validated['hinh_anh'] = $path;
                Log::info('Hình ảnh đã được upload:', ['path' => $path]);
            }

            $thietBi = ThietBi::create($validated);

            Log::info('Thiết bị đã được tạo:', ['thietBi' => $thietBi->toArray()]);

            // Tạo giao dịch tài chính nếu có giá trị
            if ($thietBi->gia_tri && $thietBi->ngay_mua) {
                GiaoDichTaiChinh::create([
                    'loai' => 'chi',
                    'so_tien' => $thietBi->gia_tri,
                    'mo_ta' => 'Mua thiết bị: ' . $thietBi->ten,
                    'ngay_giao_dich' => $thietBi->ngay_mua,
                    'ban_nganh_id' => $thietBi->id_ban
                ]);
                Log::info('Giao dịch tài chính đã được tạo:', ['thietBi' => $thietBi->id]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Thêm thiết bị thành công',
                'data' => $thietBi
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Lỗi validation khi thêm thiết bị:', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm thiết bị: ' . $e->getMessage(), ['exception' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Không thể thêm thiết bị: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hiển thị chi tiết thiết bị
     */
    public function show(ThietBi $thietBi)
    {
        $thietBi->load(['banNganh', 'nguoiQuanLy', 'nhaCungCap', 'lichSuBaoTris']);
        return response()->json($thietBi);
    }

    /**
     * Lấy thông tin thiết bị để chỉnh sửa
     */
    public function edit(ThietBi $thietBi)
    {
        $thietBi->load(['banNganh', 'nguoiQuanLy', 'nhaCungCap']);
        return response()->json($thietBi);
    }

    /**
     * Cập nhật thông tin thiết bị
     */
    public function update(Request $request, ThietBi $thietBi)
    {
        try {
            $validated = $request->validate([
                'ten' => 'required|string|max:255',
                'loai' => ['required', Rule::in(array_keys(ThietBi::LOAI_THIET_BI))],
                'tinh_trang' => ['required', Rule::in(array_keys(ThietBi::TINH_TRANG))],
                'nha_cung_cap_id' => 'nullable|exists:nha_cung_cap,id',
                'ngay_mua' => 'nullable|date',
                'gia_tri' => 'nullable|numeric|min:0',
                'nguoi_quan_ly_id' => 'nullable|exists:tin_huu,id',
                'id_ban' => 'nullable|exists:ban_nganh,id',
                'vi_tri_hien_tai' => 'nullable|string|max:255',
                'thoi_gian_bao_hanh' => 'nullable|date',
                'chu_ky_bao_tri' => 'nullable|integer|min:1',
                'ngay_het_han_su_dung' => 'nullable|date',
                'ma_tai_san' => 'nullable|string|max:50',
                'hinh_anh' => 'nullable|image|max:2048',
                'mo_ta' => 'nullable|string'
            ]);

            // Xử lý upload hình ảnh mới
            if ($request->hasFile('hinh_anh')) {
                // Xóa hình ảnh cũ nếu có
                if ($thietBi->hinh_anh) {
                    Storage::disk('public')->delete($thietBi->hinh_anh);
                }
                $path = $request->file('hinh_anh')->store('thiet_bi', 'public');
                $validated['hinh_anh'] = $path;
            }

            $thietBi->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thiết bị thành công',
                'data' => $thietBi
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật thiết bị: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể cập nhật thiết bị: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa thiết bị
     */
    public function destroy(ThietBi $thietBi)
    {
        try {
            // Xóa hình ảnh nếu có
            if ($thietBi->hinh_anh) {
                Storage::disk('public')->delete($thietBi->hinh_anh);
            }

            $thietBi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa thiết bị thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa thiết bị: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa thiết bị: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hiển thị danh sách thiết bị cần bảo trì, sắp hết hạn
     */
    public function danhSachCanhBao()
    {
        $thietBiCanBaoTri = ThietBi::whereHas('lichSuBaoTris', function ($query) {
            $query->orderBy('ngay_bao_tri', 'desc');
        })
            ->orWhere('chu_ky_bao_tri', '>', 0)
            ->get()
            ->filter(function ($thietBi) {
                return $thietBi->canBaoTri();
            });

        $thietBiSapHetHanBaoHanh = ThietBi::whereNotNull('thoi_gian_bao_hanh')
            ->get()
            ->filter(function ($thietBi) {
                return $thietBi->sapHetHanBaoHanh();
            });

        $thietBiSapHetHanSuDung = ThietBi::whereNotNull('ngay_het_han_su_dung')
            ->get()
            ->filter(function ($thietBi) {
                return $thietBi->sapHetHanSuDung();
            });

        return view('_thiet_bi.canh_bao', compact('thietBiCanBaoTri', 'thietBiSapHetHanBaoHanh', 'thietBiSapHetHanSuDung'));
    }

    /**
     * Hiển thị báo cáo thống kê
     */
    public function baoCao()
    {
        // Thống kê theo trạng thái
        $thongKeTheoTrangThai = [];
        foreach (ThietBi::TINH_TRANG as $key => $label) {
            $thongKeTheoTrangThai[$key] = [
                'label' => $label,
                'count' => ThietBi::where('tinh_trang', $key)->count()
            ];
        }

        // Thống kê theo loại
        $thongKeTheoLoai = [];
        foreach (ThietBi::LOAI_THIET_BI as $key => $label) {
            $thongKeTheoLoai[$key] = [
                'label' => $label,
                'count' => ThietBi::where('loai', $key)->count()
            ];
        }

        // Thống kê theo ban ngành
        $thongKeTheoBanNganh = BanNganh::withCount('thietBis')->get();

        // Thống kê chi phí bảo trì theo tháng/năm
        $chiPhiBaoTri = LichSuBaoTri::selectRaw('YEAR(ngay_bao_tri) as nam, MONTH(ngay_bao_tri) as thang, SUM(chi_phi) as tong_chi_phi')
            ->groupBy('nam', 'thang')
            ->orderBy('nam')
            ->orderBy('thang')
            ->get();

        return view('_thiet_bi.bao_cao', compact('thongKeTheoTrangThai', 'thongKeTheoLoai', 'thongKeTheoBanNganh', 'chiPhiBaoTri'));
    }
}
