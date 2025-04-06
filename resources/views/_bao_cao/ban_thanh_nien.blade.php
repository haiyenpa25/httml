<!-- File: resources/views/bao_cao/_ban_thanh_nien.blade.php -->

@extends('layouts.app')
@section('title', 'Báo Cáo Ban Thanh Niên')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Báo Cáo Ban Thanh Niên</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Báo Cáo</a></li>
          <li class="breadcrumb-item active">Ban Thanh Niên</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-3">
        <div class="info-box bg-info">
          <span class="info-box-icon"><i class="fas fa-users"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Tổng Thành Viên</span>
            <span class="info-box-number">42</span>
            <small>Thành viên Ban Thanh Niên</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box bg-success">
          <span class="info-box-icon"><i class="fas fa-church"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Tham Dự Tại Nhà Thờ</span>
            <span class="info-box-number">36</span>
            <small>Trong tháng 3</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box bg-warning">
          <span class="info-box-icon"><i class="fas fa-layer-group"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Tham Dự Ban Ngành</span>
            <span class="info-box-number">30</span>
            <small>Trong tháng 3</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box bg-danger">
          <span class="info-box-icon"><i class="fas fa-hand-holding-heart"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Công Tác Thăm Viếng</span>
            <span class="info-box-number">6</span>
            <small>Hoạt động hỗ trợ</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Biểu đồ hoạt động và Ban điều hành -->
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Biểu đồ tín hữu sinh hoạt | Chúa Nhật</h5>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <div class="btn-group">
                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown"><i class="fas fa-wrench"></i></button>
                <div class="dropdown-menu dropdown-menu-right" role="menu">
                  <a href="#" class="dropdown-item">Action</a>
                  <a href="#" class="dropdown-item">Another action</a>
                  <a href="#" class="dropdown-item">Something else here</a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">Separated link</a>
                </div>
              </div>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-8">
                <p class="text-center">
                  <strong>BIỂU ĐỒ TÍN HỮU SINH HOẠT TẠI NHÀ THỜ</strong>
                </p>
                <div class="chart">
                  <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                </div>
              </div>
              <div class="col-md-4">
                <p class="text-center">
                  <strong>Chi tiết theo tuần </strong>
                </p>
                <div class="progress-group">Tuần 1 <span class="float-right"><b>33</b>/42</span><div class="progress progress-sm"><div class="progress-bar bg-primary" style="width: 78%"></div></div></div>
                <div class="progress-group">Tuần 2 <span class="float-right"><b>34</b>/42</span><div class="progress progress-sm"><div class="progress-bar bg-info" style="width: 81%"></div></div></div>
                <div class="progress-group">Tuần 3 <span class="float-right"><b>36</b>/42</span><div class="progress progress-sm"><div class="progress-bar bg-success" style="width: 85%"></div></div></div>
                <div class="progress-group">Tuần 4 <span class="float-right"><b>38</b>/42</span><div class="progress progress-sm"><div class="progress-bar bg-warning" style="width: 90%"></div></div></div>
                <div class="progress-group">Tuần 5 <span class="float-right"><b>41</b>/42</span><div class="progress progress-sm"><div class="progress-bar bg-danger" style="width: 97%"></div></div></div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-6">
                <div class="description-block border-right">
                  <h5 class="description-header">36</h5>
                  <span class="description-text">Tham dự tại nhà thờ</span>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="description-block">
                  <h5 class="description-header">30</h5>
                  <span class="description-text">Tham dự ban ngành</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header bg-primary">
            <h3 class="card-title text-white">📌 Ban Điều Hành</h3>
          </div>
          <div class="card-body p-3">
            <table class="table table-bordered table-sm mb-0">
              <thead class="thead-light">
                <tr><th>STT</th><th>Họ tên</th><th>Vai trò</th></tr>
              </thead>
              <tbody>
                <tr><td>1</td><td>Bà Ms Nguyễn Hùng Dũng</td><td>Đặc Trách Ban Thanh Niên</td></tr>
                <tr><td>2</td><td>Ns Nguyễn Đặng Thảo Nguyên</td><td>Công Tác</td></tr>
                <tr><td>3</td><td>Ns Bùi Lưu Mỹ Hương</td><td>Công Tác</td></tr>
                <tr><td>4</td><td>Ns Trương Hoài Dinh</td><td>Trưởng Ban Thanh Niên</td></tr>
                <tr><td>5</td><td>Ns Lê Hoàng Thanh Nhã</td><td>Phó Ban Thanh Niên</td></tr>
                <tr><td>6</td><td>Cs Lê Thị Thu Vân</td><td>Thủ Quỹ Ban Thanh Niên</td></tr>
                <tr><td>7</td><td>Ns Phan Trung Tín</td><td>Ủy viên Ban Thanh Niên</td></tr>
                <tr><td>8</td><td>Ns Nguyễn Huỳnh Cao Trí</td><td>Ủy viên Ban Thanh Niên</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Bảng Sinh Hoạt Chúa Nhật và Chiều Chủ Nhật -->
    <div class="row">
      <div class="col-md-5">
        <div class="card">
          <div class="card-header"><h3 class="card-title">Sinh Hoạt Chúa Nhật - Tháng 3</h3></div>
          <div class="card-body">
            <table class="table table-bordered table-hover">
              <thead><tr><th>ID</th><th>Ngày</th><th>Số tín hữu tham dự</th><th>Ghi chú</th></tr></thead>
              <tbody>
                <tr><td>1</td><td>03/03/2024</td><td>30</td><td></td></tr>
                <tr><td>2</td><td>10/03/2024</td><td>32</td><td></td></tr>
                <tr><td>3</td><td>17/03/2024</td><td>28</td><td>Có khách mời</td></tr>
                <tr><td>4</td><td>24/03/2024</td><td>35</td><td></td></tr>
                <tr><td>5</td><td>31/03/2024</td><td>40</td><td>Thánh lễ Phục Sinh</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-7">
        <div class="card">
          <div class="card-header"><h3 class="card-title">Sinh Hoạt Ban (Chiều Chủ Nhật) - Tháng 3</h3></div>
          <div class="card-body">
            <table class="table table-bordered table-hover">
              <thead><tr><th>ID</th><th>Ngày</th><th>Số tín hữu</th><th>Đề tài</th><th>Dâng hiến</th><th>Diễn giả</th></tr></thead>
              <tbody>
                <tr><td>1</td><td>03/03/2024</td><td>28</td><td>Tuổi trẻ và Đức tin</td><td>450,000</td><td>MS Trần Anh</td></tr>
                <tr><td>2</td><td>10/03/2024</td><td>26</td><td>Phục vụ qua hành động</td><td>400,000</td><td>Truyền đạo Lê Huy</td></tr>
                <tr><td>3</td><td>17/03/2024</td><td>30</td><td>Sống giữa thử thách</td><td>480,000</td><td>Cô Nguyễn Thảo</td></tr>
                <tr><td>4</td><td>24/03/2024</td><td>31</td><td>Thanh niên và cầu nguyện</td><td>500,000</td><td>Thầy Nguyễn Duy</td></tr>
                <tr><td>5</td><td>31/03/2024</td><td>33</td><td>Hy vọng Phục Sinh</td><td>550,000</td><td>MSNC Phạm Hùng</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Thăm viếng và Vấn đề liên quan -->
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header"><h3 class="card-title">Thăm Viếng Trong Tháng 3</h3></div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead><tr><th>ID</th><th>Tên Tín Hữu</th><th>Loại Thăm</th><th>Ngày</th><th>Ghi chú</th></tr></thead>
              <tbody>
                <tr><td>1</td><td>Trần Thanh Sơn</td><td>Bệnh</td><td>04/03/2024</td><td>Thăm tại nhà</td></tr>
                <tr><td>2</td><td>Lê Ngọc Mai</td><td>Tân tín hữu</td><td>12/03/2024</td><td>Chia sẻ Kinh Thánh</td></tr>
                <tr><td>3</td><td>Phạm Văn Dũng</td><td>Động viên</td><td>20/03/2024</td><td>Chuẩn bị thi đại học</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6" id="accordion">
        @foreach(['Tập hát chuẩn bị chương trình Phục Sinh', 'Tổ chức buổi thông công tháng 4 cho Thanh Niên'] as $i => $item)
        <div class="card card-warning card-outline">
          <a class="d-block w-100" data-toggle="collapse" href="#collapseVanDe{{ $i + 1 }}">
            <div class="card-header">
              <h4 class="card-title w-100">{{ $i + 1 }}. {{ $item }}</h4>
            </div>
          </a>
          <div id="collapseVanDe{{ $i + 1 }}" class="collapse {{ $i === 0 ? 'show' : '' }}" data-parent="#accordion">
            <div class="card-body">Nội dung liên quan đến: {{ $item }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

  </div>
</section>
@endsection
