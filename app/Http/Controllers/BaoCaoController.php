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
}
