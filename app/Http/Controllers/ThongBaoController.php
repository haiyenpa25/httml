<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThongBao;
use App\Models\NguoiDung;
use App\Models\BanNganh;
use App\Models\TinHuu;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ThongBao\NhanThongBaoController;
use App\Http\Controllers\ThongBao\GuiThongBaoController;
use App\Http\Controllers\ThongBao\QuanLyThongBaoController;
use App\Http\Middleware\QuyenGuiThongBao;
use App\Providers\RouteServiceProvider;



class ThongBaoController extends Controller
{
    protected $nhanThongBaoController;
    protected $guiThongBaoController;
    protected $quanLyThongBaoController;

    public function __construct(
        NhanThongBaoController $nhanThongBaoController,
        GuiThongBaoController $guiThongBaoController,
        QuanLyThongBaoController $quanLyThongBaoController
    ) {
        //$this->middleware('auth');
        $this->nhanThongBaoController = $nhanThongBaoController;
        $this->guiThongBaoController = $guiThongBaoController;
        $this->quanLyThongBaoController = $quanLyThongBaoController;
    }

    /**
     * Hiển thị trang chủ quản lý thông báo.
     */
    public function index()
    {
        $thongBaoChuaDoc = $this->nhanThongBaoController->demThongBaoChuaDoc();
        return view('_thong_bao.index', compact('thongBaoChuaDoc'));
    }

    /**
     * Hiển thị form soạn thông báo.
     */
    public function create()
    {
        $cacBanNganh = BanNganh::all();
        return $this->guiThongBaoController->showCreateForm($cacBanNganh);
    }

    /**
     * Lưu thông báo mới.
     */
    public function store(Request $request)
    {
        return $this->guiThongBaoController->store($request);
    }

    /**
     * Hiển thị hộp thư đến.
     */
    public function inbox()
    {
        return $this->nhanThongBaoController->inbox();
    }

    /**
     * Hiển thị chi tiết thông báo.
     */
    public function show($id)
    {
        return $this->nhanThongBaoController->show($id);
    }

    /**
     * Đánh dấu thông báo đã đọc.
     */
    public function markAsRead($id)
    {
        return $this->quanLyThongBaoController->markAsRead($id);
    }

    /**
     * Đánh dấu thông báo đã lưu trữ.
     */
    public function archive($id)
    {
        return $this->quanLyThongBaoController->archive($id);
    }

    /**
     * Xóa thông báo.
     */
    public function destroy($id)
    {
        return $this->quanLyThongBaoController->destroy($id);
    }

    /**
     * Hiển thị thông báo đã lưu trữ.
     */
    public function archived()
    {
        return $this->quanLyThongBaoController->archived();
    }

    /**
     * Đếm số thông báo chưa đọc (dùng cho AJAX).
     */
    public function countUnread()
    {
        return $this->nhanThongBaoController->countUnread();
    }

    /**
     * Lấy danh sách người dùng theo ban ngành.
     */
    public function getUsersByBanNganh($banNganhId)
    {
        return $this->guiThongBaoController->getUsersByBanNganh($banNganhId);
    }

    /**
     * Lấy trưởng ban của ban ngành.
     */
    public function getTruongBan($banNganhId)
    {
        return $this->guiThongBaoController->getTruongBan($banNganhId);
    }

    /**
     * Lấy danh sách tất cả người dùng.
     */
    public function getAllUsers()
    {
        return $this->guiThongBaoController->getAllUsers();
    }
}
