@extends('layouts.app')
@section('title', 'Báo Cáo Ban Trung Lão')

@section('content')
<!-- Custom Input Form -->
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Phần 1: Nhập liệu</h3>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label>Chọn Chúa nhật ngày</label>
        <select class="form-control select2" id="sunday-select" style="width: 100%;">
          <!-- JavaScript sẽ thêm các ngày Chúa Nhật -->
        </select>
      </div>
      <div class="form-group">
        <label>Đề tài</label>
        <input type="text" class="form-control" placeholder="Nhập đề tài">
      </div>
      <div class="form-group">
        <label>Diễn giả</label>
        <select class="form-control select2" style="width: 100%;">
          <option>Ms. A</option>
          <option>Ms. B</option>
          <option>Ms. C</option>
        </select>
      </div>
      <div class="form-group">
        <label>Hướng dẫn chương trình</label>
        <select class="form-control select2" style="width: 100%;">
          <option>Mr. X</option>
          <option>Mr. Y</option>
          <option>Mr. Z</option>
        </select>
      </div>
      <div class="form-group">
        <label>Số lượng thành viên tham dự</label>
        <input type="number" class="form-control" placeholder="Nhập số lượng người">
      </div>
      <div class="form-group">
        <label>Dâng hiến (VNĐ)</label>
        <input type="number" class="form-control" placeholder="Nhập số tiền">
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
        <select class="form-control select2" style="width: 100%;">
          <option>Anh A</option>
          <option>Chị B</option>
          <option>Em C</option>
        </select>
      </div>
      <div class="form-group">
        <label>Lý do</label>
        <input type="text" class="form-control" placeholder="Lý do thăm viếng">
      </div>
      <div class="form-group">
        <label>Ngày thăm viếng</label>
        <div class="input-group date" id="visit-date" data-target-input="nearest">
          <input type="text" class="form-control datetimepicker-input" data-target="#visit-date"/>
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
        <textarea class="form-control" rows="3" placeholder="Ghi chú hiện trạng..."></textarea>
      </div>
      <div class="form-group">
        <label>Đề xuất</label>
        <textarea class="form-control" rows="3" placeholder="Ghi chú đề xuất..."></textarea>
      </div>
      <div class="form-group">
        <label>Lưu ý</label>
        <textarea class="form-control" rows="2" placeholder="Ghi chú lưu ý..."></textarea>
      </div>
    </div>
  </div>
  
@endsection