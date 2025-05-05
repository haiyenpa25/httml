<?php

namespace App\Http\Controllers\ThuQuy;

use App\Models\BanNganh;
use App\Models\BuoiNhom;
use App\Models\GiaoDichTaiChinh;
use App\Models\QuyTaiChinh;
use App\Models\ChiDinhKy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GiaoDichTaoController extends ThuQuyController
{
    /**
     * Hiển thị form tạo giao dịch mới
     */
    public function create()
    {
        $dsQuy = QuyTaiChinh::where('trang_thai', 'hoat_dong')->get();
        $dsBanNganh = BanNganh::orderBy('ten')->get();
        $dsBuoiNhom = BuoiNhom::where('trang_thai', '<>', 'huy')
            ->orderBy('ngay_dien_ra', 'desc')
            ->take(30)
            ->get();
        $dsChiDinhKy = ChiDinhKy::where('trang_thai', 'hoat_dong')->get();

        return view('_thu_quy.giao_dich.create', compact('dsQuy', 'dsBanNganh', 'dsBuoiNhom', 'dsChiDinhKy'));
    }

    /**
     * Lưu giao dịch mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quy_tai_chinh_id' => 'required|exists:quy_tai_chinh,id',
            'loai' => 'required|in:thu,chi',
            'hinh_thuc' => 'required|in:dang_hien,tai_tro,luong,hoa_don,sua_chua,khac',
            'so_tien' => 'required|numeric|min:1000',
            'mo_ta' => 'required|string',
            'ngay_giao_dich' => 'required|date',
            'phuong_thuc' => 'required|in:tien_mat,chuyen_khoan,the,khac',
            'nguoi_nhan' => 'nullable|required_if:loai,chi|string',
            'ban_nganh_id' => 'nullable|exists:ban_nganh,id',
            'buoi_nhom_id' => 'nullable|exists:buoi_nhom,id',
            'chi_dinh_ky_id' => 'nullable|exists:chi_dinh_ky,id',
            'hoa_don' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048'
        ]);

        // Xử lý tải lên hóa đơn
        if ($request->hasFile('hoa_don')) {
            $file = $request->file('hoa_don');
            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('hoa_don', $fileName, 'public');
            $validated['duong_dan_hoa_don'] = $filePath;
        }

        // Kiểm tra nếu là giao dịch chi lớn cần duyệt
        $quy = QuyTaiChinh::findOrFail($validated['quy_tai_chinh_id']);
        $validated['trang_thai'] = ($validated['loai'] == 'chi' && $validated['so_tien'] > 1000000) ? 'cho_duyet' : 'hoan_thanh';

        if ($validated['trang_thai'] === 'hoan_thanh') {
            $this->capNhatSoDuQuy($validated['quy_tai_chinh_id'], $validated['so_tien'], $validated['loai']);
        }

        $giaoDich = GiaoDichTaiChinh::create($validated);
        $giaoDich->ma_giao_dich = $this->taoMaGiaoDich($giaoDich->loai, $giaoDich->id);
        $giaoDich->save();

        $this->ghiLogThaoTac('Tạo giao dịch mới', 'giao_dich_tai_chinh', $giaoDich->id, null, $giaoDich->toArray());

        if ($giaoDich->trang_thai === 'cho_duyet') {
            $dsDuyet = $this->layDanhSachNguoiDuyet();
            foreach ($dsDuyet as $nguoiDuyet) {
                $this->guiThongBao(
                    'Yêu cầu duyệt giao dịch mới',
                    "Có giao dịch chi {$this->formatTien($giaoDich->so_tien)} cần được duyệt",
                    'yeu_cau_duyet',
                    $nguoiDuyet->id,
                    GiaoDichTaiChinh::class,
                    $giaoDich->id
                );
            }
            return redirect()->route('_thu_quy.giao_dich.index')->with('success', 'Tạo giao dịch thành công và đang chờ duyệt');
        }

        return redirect()->route('_thu_quy.giao_dich.index')->with('success', 'Tạo giao dịch thành công');
    }

    /**
     * Hiển thị form chỉnh sửa giao dịch
     */
    public function edit($id)
    {
        $giaoDich = GiaoDichTaiChinh::findOrFail($id);

        if ($this->user->vai_tro !== 'quan_tri' && $giaoDich->trang_thai !== 'cho_duyet') {
            return redirect()->route('_thu_quy.giao_dich.index')
                ->with('error', 'Bạn không có quyền sửa giao dịch này');
        }

        $dsQuy = QuyTaiChinh::where('trang_thai', 'hoat_dong')->get();
        $dsBanNganh = BanNganh::orderBy('ten')->get();
        $dsBuoiNhom = BuoiNhom::where('trang_thai', '<>', 'huy')
            ->orderBy('ngay_dien_ra', 'desc')
            ->take(30)
            ->get();
        $dsChiDinhKy = ChiDinhKy::where('trang_thai', 'hoat_dong')->get();

        return view('_thu_quy.giao_dich.edit', compact('giaoDich', 'dsQuy', 'dsBanNganh', 'dsBuoiNhom', 'dsChiDinhKy'));
    }

    /**
     * Cập nhật giao dịch
     */
    public function update(Request $request, $id)
    {
        $giaoDich = GiaoDichTaiChinh::findOrFail($id);

        if ($this->user->vai_tro !== 'quan_tri' && $giaoDich->trang_thai !== 'cho_duyet') {
            return redirect()->route('_thu_quy.giao_dich.index')
                ->with('error', 'Bạn không có quyền sửa giao dịch này');
        }

        $validated = $request->validate([
            'quy_tai_chinh_id' => 'required|exists:quy_tai_chinh,id',
            'loai' => 'required|in:thu,chi',
            'hinh_thuc' => 'required|in:dang_hien,tai_tro,luong,hoa_don,sua_chua,khac',
            'so_tien' => 'required|numeric|min:1000',
            'mo_ta' => 'required|string',
            'ngay_giao_dich' => 'required|date',
            'phuong_thuc' => 'required|in:tien_mat,chuyen_khoan,the,khac',
            'nguoi_nhan' => 'nullable|required_if:loai,chi|string',
            'ban_nganh_id' => 'nullable|exists:ban_nganh,id',
            'buoi_nhom_id' => 'nullable|exists:buoi_nhom,id',
            'chi_dinh_ky_id' => 'nullable|exists:chi_dinh_ky,id',
            'hoa_don' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048'
        ]);

        $duLieuCu = $giaoDich->toArray();

        // Xử lý tải lên hóa đơn
        if ($request->hasFile('hoa_don')) {
            if ($giaoDich->duong_dan_hoa_don) {
                Storage::disk('public')->delete($giaoDich->duong_dan_hoa_don);
            }
            $file = $request->file('hoa_don');
            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('hoa_don', $fileName, 'public');
            $validated['duong_dan_hoa_don'] = $filePath;
        }

        // Kiểm tra thay đổi quỹ, loại hoặc số tiền
        if (
            $giaoDich->quy_tai_chinh_id != $validated['quy_tai_chinh_id'] ||
            $giaoDich->loai != $validated['loai'] ||
            $giaoDich->so_tien != $validated['so_tien'] ||
            $giaoDich->trang_thai == 'cho_duyet'
        ) {
            $validated['trang_thai'] = ($validated['loai'] == 'chi' && $validated['so_tien'] > 1000000) ? 'cho_duyet' : 'hoan_thanh';

            if ($validated['trang_thai'] === 'hoan_thanh') {
                if ($giaoDich->trang_thai === 'hoan_thanh') {
                    // Hoàn lại số dư cũ
                    $quyCu = QuyTaiChinh::findOrFail($giaoDich->quy_tai_chinh_id);
                    $quyCu->so_du_hien_tai += ($giaoDich->loai == 'thu') ? -$giaoDich->so_tien : $giaoDich->so_tien;
                    $quyCu->save();
                }
                $this->capNhatSoDuQuy($validated['quy_tai_chinh_id'], $validated['so_tien'], $validated['loai']);
            } else {
                $validated['nguoi_duyet_id'] = null;
                $validated['ngay_duyet'] = null;
            }
        }

        $giaoDich->update($validated);
        $this->ghiLogThaoTac('Cập nhật giao dịch', 'giao_dich_tai_chinh', $giaoDich->id, $duLieuCu, $giaoDich->toArray());

        if ($giaoDich->trang_thai === 'cho_duyet') {
            $dsDuyet = $this->layDanhSachNguoiDuyet();
            foreach ($dsDuyet as $nguoiDuyet) {
                $this->guiThongBao(
                    'Yêu cầu duyệt giao dịch đã cập nhật',
                    "Có giao dịch chi {$this->formatTien($giaoDich->so_tien)} đã được cập nhật và cần duyệt lại",
                    'yeu_cau_duyet',
                    $nguoiDuyet->id,
                    GiaoDichTaiChinh::class,
                    $giaoDich->id
                );
            }
        }

        return redirect()->route('_thu_quy.giao_dich.index')->with('success', 'Cập nhật giao dịch thành công');
    }

    /**
     * Xóa giao dịch
     */
    public function destroy($id)
    {
        $giaoDich = GiaoDichTaiChinh::findOrFail($id);

        if ($this->user->vai_tro !== 'quan_tri' && $giaoDich->trang_thai !== 'cho_duyet') {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền xóa giao dịch này'
            ]);
        }

        $duLieuCu = $giaoDich->toArray();

        if ($giaoDich->trang_thai === 'hoan_thanh') {
            $quy = QuyTaiChinh::findOrFail($giaoDich->quy_tai_chinh_id);
            $quy->so_du_hien_tai += ($giaoDich->loai == 'thu') ? -$giaoDich->so_tien : $giaoDich->so_tien;
            $quy->save();
        }

        if ($giaoDich->duong_dan_hoa_don) {
            Storage::disk('public')->delete($giaoDich->duong_dan_hoa_don);
        }

        $giaoDich->delete();
        $this->ghiLogThaoTac('Xóa giao dịch', 'giao_dich_tai_chinh', $id, $duLieuCu, null);

        return response()->json(['success' => true]);
    }
}