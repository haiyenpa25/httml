@extends('layouts.app')
@section('title', 'Thêm Diễn Giả')

@section('content')
            <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard v2</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v2</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Tổng số tín hữu</span>
                <small>Tháng 3</small>
                <span class="info-box-number">
                  10
                  <small>Tin hữu</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Số tín hữu trực tuyến</span>
                <small>Tháng 3</small>
                <span class="info-box-number">200 <small>Tin hữu</small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Tổng số tín hữu</span>
                <small>Tháng 4</small>
                <span class="info-box-number">
                  10
                  <small>Tin hữu</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Số tín hữu trực tuyến</span>
                <small>Tháng 4</small>
                <span class="info-box-number">200 <small>Tin hữu</small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Biểu đồ tín hữu sinh hoạt | Chúa Nhật</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="#" class="dropdown-item">Action</a>
                      <a href="#" class="dropdown-item">Another action</a>
                      <a href="#" class="dropdown-item">Something else here</a>
                      <a class="dropdown-divider"></a>
                      <a href="#" class="dropdown-item">Separated link</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <p class="text-center">
                      <strong>BIỂU ĐỒ TÍN HỮU SINH HOẠT TẠI NHÀ THỜ</strong>
                    </p>

                    <div class="chart">
                      <!-- Sales Chart Canvas -->
                      <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->

                    


                  </div>

                  
                  <!-- /.col -->
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
                    <!-- /.progress-group -->

                    <div class="progress-group">
                      Tuần 2
                      <span class="float-right"><b>310</b>/400</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" style="width: 75%"></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      <span class="progress-text">Tuần 3</span>
                      <span class="float-right"><b>480</b>/800</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: 60%"></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      Tuần 4
                      <span class="float-right"><b>250</b>/500</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: 50%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->
                    <!-- /.progress-group -->
                    <div class="progress-group">
                      Tuần 5
                      <span class="float-right"><b>250</b>/500</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: 50%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
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
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thống Kê Buổi Nhóm - Tháng 3</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="bang-thong-ke" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Ngày</th>
                      <th>Người lớn</th>
                      <th>Thiếu nhi</th>
                      <th>Online</th>
                      <th>Chủ đề</th>
                      <th>Diễn giả</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $data = [
                            ['id' => 1, 'ngay' => '03/03/2024', 'lon' => 80, 'tre' => 30, 'online' => 15, 'chu_de' => 'Đức Tin Sống Động', 'dien_gia' => 'Mục sư Nguyễn Văn A'],
                            ['id' => 2, 'ngay' => '10/03/2024', 'lon' => 85, 'tre' => 28, 'online' => 20, 'chu_de' => 'Tình Yêu Thương', 'dien_gia' => 'Truyền Đạo Trần B'],
                            ['id' => 3, 'ngay' => '17/03/2024', 'lon' => 78, 'tre' => 35, 'online' => 18, 'chu_de' => 'Sự Bình An Trong Chúa', 'dien_gia' => 'Mục sư nhiệm chức Phạm C'],
                            ['id' => 4, 'ngay' => '24/03/2024', 'lon' => 82, 'tre' => 32, 'online' => 22, 'chu_de' => 'Phục Vụ Với Tấm Lòng', 'dien_gia' => 'Cô Lê D'],
                            ['id' => 5, 'ngay' => '31/03/2024', 'lon' => 90, 'tre' => 25, 'online' => 19, 'chu_de' => 'Phục Sinh & Hy Vọng', 'dien_gia' => 'Thầy Nguyễn E'],
                        ];
                    @endphp
                    @foreach ($data as $row)
                      <tr>
                        <td>{{ $row['id'] }}</td>
                        <td>{{ $row['ngay'] }}</td>
                        <td>{{ $row['lon'] }}</td>
                        <td>{{ $row['tre'] }}</td>
                        <td>{{ $row['online'] }}</td>
                        <td>{{ $row['chu_de'] }}</td>
                        <td>{{ $row['dien_gia'] }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Ngày</th>
                      <th>Người lớn</th>
                      <th>Thiếu nhi</th>
                      <th>Online</th>
                      <th>Chủ đề</th>
                      <th>Diễn giả</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
        

       
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection
