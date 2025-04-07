<!-- File: resources/views/bao_cao/_ban_trung_lao.blade.php -->

@extends('layouts.app')
@section('title', 'Báo Cáo Ban Trung Lão')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Báo Cáo Ban Trung Lão</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Báo Cáo</a></li>
          <li class="breadcrumb-item active">Ban Trung Lão</li>
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
            <span class="info-box-number">35</span>
            <small>Thành viên Ban Trung Lão</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box bg-success">
          <span class="info-box-icon"><i class="fas fa-church"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Tham Dự Tại Nhà Thờ</span>
            <span class="info-box-number">28</span>
            <small>Trong tháng 3</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box bg-warning">
          <span class="info-box-icon"><i class="fas fa-video"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Tham Dự Online</span>
            <span class="info-box-number">12</span>
            <small>Trong tháng 3</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="info-box bg-danger">
          <span class="info-box-icon"><i class="fas fa-hand-holding-heart"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Công Tác Thăm viếng</span>
            <span class="info-box-number">5</span>
            <small>Hoạt động thăm viếng</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Biểu đồ sinh hoạt -->
           <!-- Biểu đồ và thành viên ban điều hành -->
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
            <div class="chart">
              <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
                <div class="progress-group">
                  Tuần 1
                  <span class="float-right"><b>160</b>/200</span>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-primary" style="width: 80%"></div>
                  </div>
                </div>
                <div class="progress-group">
                  Tuần 2
                  <span class="float-right"><b>310</b>/400</span>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-danger" style="width: 75%"></div>
                  </div>
                </div>
                <div class="progress-group">
                  <span class="progress-text">Tuần 3</span>
                  <span class="float-right"><b>480</b>/800</span>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-success" style="width: 60%"></div>
                  </div>
                </div>
                <div class="progress-group">
                  Tuần 4
                  <span class="float-right"><b>250</b>/500</span>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-warning" style="width: 50%"></div>
                  </div>
                </div>
                <div class="progress-group">
                  Tuần 5
                  <span class="float-right"><b>250</b>/500</span>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-warning" style="width: 50%"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                  <h5 class="description-header">10</h5>
                  <span class="description-text">Tín hữu</span><br>
                  <small>Số người tham dự tại nhà thờ</small>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                  <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                  <h5 class="description-header">2</h5>
                  <span class="description-text">Tín hữu</span><br>
                  <small>Số người tham dự online</small>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                  
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-3 col-6">
                <div class="description-block">
                  
                </div>
                <!-- /.description-block -->
              </div>
            </div>
            <!-- /.row -->
          </div>


        </div>
      </div>



      
      <div class="col-md-4">
        <div class="card">
          <div class="card-header bg-primary">
            <h3 class="card-title text-white">📌 Ban Điều Hành</h3>
            <div class="card-tools">
              <span title="3 New Messages" class="badge bg-light text-primary">3</span>
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                <i class="fas fa-comments"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body p-3">
            <table class="table table-bordered table-sm mb-0">
              <thead class="thead-light">
                <tr>
                  <th>STT</th>
                  <th>Vai trò</th>
                  <th>Họ tên</th>
                </tr>
              </thead>
              <tbody>
                <tr><td>1</td><td>Cố Vấn Linh Vụ</td><td>Ms Nguyễn Hùng Dũng</td></tr>
                <tr><td>2</td><td>Trưởng Ban Trung Lão Niên</td><td>Ns Nguyễn Đặng Tường</td></tr>
                <tr><td>3</td><td>Thư Ký Ban Trung Lão Niên</td><td>Ns Phan Văn Be</td></tr>
                <tr><td>4</td><td>Thủ Quỹ Ban Trung Lão Niên</td><td>Ns Hồ Thị Ngọc Mai</td></tr>
                <tr><td>5</td><td>Ủy Viên Ban Trung Lão Niên</td><td>Ns Huỳnh Thị Xuân Hà</td></tr>
                <tr><td>6</td><td>Ủy Viên Ban Trung Lão Niên</td><td>Ns Nguyễn Thị Phương Dung</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Bảng sinh hoạt Chúa Nhật và Ban Thứ 7 -->
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
          <div class="card-header"><h3 class="card-title">Sinh Hoạt Ban (Thứ 7) - Tháng 3</h3></div>
          <div class="card-body">
            <table class="table table-bordered table-hover">
              <thead><tr><th>ID</th><th>Ngày</th><th>Số tín hữu</th><th>Đề tài</th><th>Dâng hiến</th><th>Diễn giả</th></tr></thead>
              <tbody>
                <tr><td>1</td><td>02/03/2024</td><td>25</td><td>Đức Tin Sống Động</td><td>500,000</td><td>MS Nguyễn Văn A</td></tr>
                <tr><td>2</td><td>09/03/2024</td><td>22</td><td>Tình Yêu Thương</td><td>400,000</td><td>Cô Trần Thị B</td></tr>
                <tr><td>3</td><td>16/03/2024</td><td>20</td><td>Hy Vọng Mới</td><td>450,000</td><td>Thầy Lê Văn C</td></tr>
                <tr><td>4</td><td>23/03/2024</td><td>24</td><td>Phục Vụ Trong Yêu Thương</td><td>600,000</td><td>MSNC Phạm D</td></tr>
                <tr><td>5</td><td>30/03/2024</td><td>27</td><td>Thập Tự Và Sự Phục Sinh</td><td>700,000</td><td>Truyền Đạo Lê E</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Bảng thăm viếng và vấn đề liên quan -->
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header"><h3 class="card-title">Thăm Viếng Trong Tháng 3</h3></div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead><tr><th>ID</th><th>Tên Tín Hữu</th><th>Loại Thăm</th><th>Ngày</th><th>Ghi chú</th></tr></thead>
              <tbody>
                <tr><td>1</td><td>Nguyễn Văn A</td><td>Bệnh</td><td>05/03/2024</td><td>Viện Tim</td></tr>
                <tr><td>2</td><td>Lê Thị B</td><td>Già yếu</td><td>11/03/2024</td><td>Thăm tại nhà</td></tr>
                <tr><td>3</td><td>Trần Văn C</td><td>Hỗ trợ tang lễ</td><td>18/03/2024</td><td>Gia đình mất người thân</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6" id="accordion">
        @foreach(['Tập hát cho chương trình Thương Khó Phục sinh', 'Chương trình thông công tháng 4'] as $i => $item)
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