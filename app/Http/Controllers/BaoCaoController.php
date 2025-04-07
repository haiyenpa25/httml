<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\View\View;


class BaoCaoController extends Controller
{
    public function baoCaoBanNganh(): View
    {
        return view('_bao_cao.ban_nganh');
    }

    public function baoCaoHoiThanh(): View
    {
        return view('_bao_cao.hoi_thanh');
    }
    public function baoCaoBanTrungLao(): View
    {
        return view('_bao_cao.ban_trung_lao');
    }

    public function baoCaoBanThanhNien(): View
    {
        return view('_bao_cao.ban_thanh_nien');
    }
    public function baoCaoBanCoDocGiaoDuc(): View
    {
        return view('_bao_cao.ban_co_doc_giao_duc');
    }
}
