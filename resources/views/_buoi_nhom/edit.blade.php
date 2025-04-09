@extends('layouts.app')
@section('title', 'Chỉnh Sửa Buổi Nhóm')

@section('content')
    <div class="container">
        <h2>Chỉnh Sửa Buổi Nhóm</h2>
        <form action="{{ route('buoi_nhom.update', $buoiNhom->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Phần 1: Nhập liệu</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Chọn Chúa nhật ngày</label>
                        <select class="form-control select2" id="sunday-select" name="ngay_dien_ra" style="width: 100%;" required>
                            <option value="">-- Chọn ngày --</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <label>Đề tài</label>
                        <input type="text" class="form-control" name="chu_de" value="{{ $buoiNhom->chu_de }}" placeholder="Nhập đề tài">
                    </div>
                    <div class="form-group">
                        <label>Diễn giả</label>
                        <select class="form-control select2" name="dien_gia_id" style="width: 100%;">
                            <option value="">-- Chọn diễn giả --</option>
                            @foreach ($dienGias as $dienGia)
                                <option value="{{ $dienGia->id }}" {{ $buoiNhom->dien_gia_id == $dienGia->id ? 'selected' : '' }}>{{ $dienGia->ho_ten }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Hướng dẫn chương trình</label>
                        <select class="form-control select2" name="id_tin_huu_hdct" style="width: 100%;">
                            <option value="">-- Chọn người hướng dẫn --</option>
                            @foreach ($nguoiHuongDans as $nguoiHuongDan)
                                <option value="{{ $nguoiHuongDan->id }}" {{ $buoiNhom->id_tin_huu_hdct == $nguoiHuongDan->id ? 'selected' : '' }}>{{ $nguoiHuongDan->ho_ten }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Số lượng thành viên tham dự</label>
                        <input type="number" class="form-control" name="so_luong_tin_huu" value="{{ $buoiNhom->so_luong_tin_huu }}" placeholder="Nhập số lượng người">
                    </div>
                    <div class="form-group">
                        <label>Dâng hiến (VNĐ)</label>
                        <input type="number" class="form-control" name="dang_hien" value="{{ $buoiNhom->dang_hien }}" placeholder="Nhập số tiền">
                    </div>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Phần 2: Thăm viếng</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Người thăm viếng</label>
                        <select class="form-control select2" name="nguoi_tham_vieng_id" style="width: 100%;">
                            <option value="">-- Chọn người thăm viếng --</option>
                            @foreach ($nguoiThamViengs as $nguoiThamVieng)
                                <option value="{{ $nguoiThamVieng->id }}" {{ $buoiNhom->nguoi_tham_vieng_id == $nguoiThamVieng->id ? 'selected' : '' }}>{{ $nguoiThamVieng->ho_ten }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Lý do</label>
                        <input type="text" class="form-control" name="ly_do_tham_vieng" value="{{ $buoiNhom->ly_do_tham_vieng }}" placeholder="Lý do thăm viếng">
                    </div>
                    <div class="form-group">
                        <label>Ngày thăm viếng</label>
                        <div class="input-group date" id="visit-date" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" name="ngay_tham_vieng" value="{{ $buoiNhom->ngay_tham_vieng }}" data-target="#visit-date"/>
                            <div class="input-group-append" data-target="#visit-date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Phần 3: Ý kiến</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Hiện trạng</label>
                        <textarea class="form-control" rows="3" name="hien_trang" value="{{ $buoiNhom->hien_trang }}" placeholder="Ghi chú hiện trạng..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Đề xuất</label>
                        <textarea class="form-control" rows="3" name="de_xuat" value="{{ $buoiNhom->de_xuat }}" placeholder="Ghi chú đề xuất..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Lưu ý</label>
                        <textarea class="form-control" rows="2" name="luu_y" value="{{ $buoiNhom->luu_y }}" placeholder="Ghi chú lưu ý..."></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Cập Nhật Báo Cáo</button>
            <a href="{{ route('buoi_nhom.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            //Initialize Select2 Elements
            $('.select2').select2();

            //Date picker
            $('#visit-date').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            // Logic để thêm các ngày Chúa Nhật vào select (cần điều chỉnh theo logic của bạn)
            function populateSundays() {
                let sundaySelect = $('#sunday-select');
                let today = new Date();
                let currentDay = today.getDay();
                let diff = today.getDate() - currentDay + (currentDay == 0 ? 0 : 7); // Calculate the previous Sunday
                let previousSunday = new Date(today.setDate(diff));

                for (let i = 0; i < 5; i++) { // Lấy 5 Chúa Nhật gần nhất
                    let dateString = previousSunday.toISOString().split('T')[0];
                    sundaySelect.append(`<option value="${dateString}">${dateString}</option>`);
                    previousSunday.setDate(previousSunday.getDate() - 7);
                }
                sundaySelect.val("{{ old('ngay_dien_ra', $buoiNhom->ngay_dien_ra) }}"); // Set selected value if old input exists or from the model
            }

            populateSundays();
        });
    </script>
@endsection