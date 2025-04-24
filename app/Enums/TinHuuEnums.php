<?php

namespace App\Enums;

enum LoaiTinHuu: string
{
    case CHINH_THUC = 'tin_huu_chinh_thuc';
    case TAN = 'tan_tin_huu';
    case KHAC = 'tin_huu_ht_khac';
}

enum GioiTinh: string
{
    case NAM = 'nam';
    case NU = 'nu';
}

enum TinhTrangHonNhan: string
{
    case DOC_THAN = 'doc_than';
    case KET_HON = 'ket_hon';
}
