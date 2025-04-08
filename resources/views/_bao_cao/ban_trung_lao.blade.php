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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title text-white">📌 Ban Điều Hành</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
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
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #4b545c; color: white;">
                        <h5 class="card-title">Biểu đồ tín hữu sinh hoạt | Chúa Nhật </h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
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
                                    <canvas id="barChart" height="180" style="height: 180px;"></canvas>
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
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                                    <h5 class="description-header">2</h5>
                                    <span class="description-text">Tín hữu</span><br>
                                    <small>Số người tham dự online</small>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <h5 class="description-header"></h5>
                                    <span class="description-text"></span><br>
                                    <small></small>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="description-block">
                                    <h5 class="description-header"></h5>
                                    <span class="description-text"></span><br>
                                    <small></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #4b545c; color: white;">
                        <h5 class="card-title">Biểu đồ tín hữu sinh hoạt Ban Ngành | Chiều Chúa Nhật |Vào lúc 14:00 |</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>BIỂU ĐỒ TÍN HỮU SINH HOẠT BAN NGÀNH</strong>
                                </p>
                                <div class="chart">
                                    <canvas id="barChart1" height="180" style="height: 180px;"></canvas>
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
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                                    <h5 class="description-header">2</h5>
                                    <span class="description-text">Tín hữu</span><br>
                                    <small>Số người tham dự online</small>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <h5 class="description-header"></h5>
                                    <span class="description-text"></span><br>
                                    <small></small>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="description-block">
                                    <h5 class="description-header"></h5>
                                    <span class="description-text"></span><br>
                                    <small></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #4b545c; color: white;">
                        <h3 class="card-title">Sinh Hoạt Chúa Nhật - Tháng 3</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ngày</th>
                                        <th>Số tín hữu tham dự</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
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
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #4b545c; color: white;">
                        <h3 class="card-title">Sinh Hoạt Ban (Thứ 7) - Tháng 3</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ngày</th>
                                        <th>Số tín hữu</th>
                                        <th>Đề tài</th>
                                        <th>Dâng hiến</th>
                                        <th>Diễn giả</th>
                                    </tr>
                                </thead>
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
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #4b545c; color: white;">
                        <h3 class="card-title">Tài chính - Tháng 3</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ngày</th>
                                        <th>Thu</th>
                                        <th>Chi</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>1</td><td>01/03/2024</td><td>1,000,000</td><td>500,000</td><td>Tiền thuê địa điểm</td></tr>
                                    <tr><td>2</td><td>08/03/2024</td><td>800,000</td><td>200,000</td><td>Chi phí âm nhạc</td></tr>
                                    <tr><td>3</td><td>15/03/2024</td><td>1,200,000</td><td>300,000</td><td>Hỗ trợ thăm viếng</td></tr>
                                    <tr><td>4</td><td>22/03/2024</td><td>900,000</td><td>100,000</td><td>In ấn tài liệu</td></tr>
                                    <tr><td>5</td><td>29/03/2024</td><td>1,500,000</td><td>400,000</td><td>Chi phí tổ chức sự kiện</td></tr>
                                    <tr><td colspan="2" class="font-weight-bold text-right">Tổng</td>
                                        <td class="font-weight-bold">5,400,000</td>
                                        <td class="font-weight-bold">1,500,000</td>
                                        <td></td>
                                    </tr>
                                    <tr><td colspan="2" class="font-weight-bold text-right">Tổng tồn</td>
                                        <td colspan="3" class="font-weight-bold">3,900,000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #4b545c; color: white;">
                        <h3 class="card-title">Thăm Viếng Trong Tháng 3</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên Tín Hữu</th>
                                        <th>Loại Thăm</th>
                                        <th>Ngày</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>1</td><td>Nguyễn Văn A</td><td>Bệnh</td><td>05/03/2024</td><td>Viện Tim</td></tr>
                                    <tr><td>2</td><td>Lê Thị B</td><td>Già yếu</td><td>11/03/2024</td><td>Thăm tại nhà</td></tr>
                                    <tr><td>3</td><td>Trần Văn C</td><td>Hỗ trợ tang lễ</td><td>18/03/2024</td><td>Gia đình mất người thân</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #4b545c; color: white;">
                        <h3 class="card-title">Ý kiến</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="accordionVanDe">
                            @foreach(['Tập hát cho chương trình Thương Khó Phục sinh', 'Chương trình thông công tháng 4'] as $i => $item)
                            <div class="card card-primary shadow-none">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100" data-toggle="collapse" href="#collapseVanDe{{ $i + 1 }}">
                                            {{ $i + 1 }}. {{ $item }}
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseVanDe{{ $i + 1 }}" class="collapse {{ $i === 0 ? 'show' : '' }}" data-parent="#accordionVanDe">
                                    <div class="card-body">Nội dung liên quan đến: {{ $item }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@section('scripts')
<script>
    $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //--------------
        //- BAR CHART -
        //--------------

        var areaChartData = {
            labels  : ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4', 'Tuần 5'],
            datasets: [
                {
                    label               : 'Tín hữu tại nhà thờ',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : [160, 310, 480, 250, 250]
                },
                {
                    label               : 'Tín hữu online',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius          : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : [10, 20, 30, 15, 18]
                },
            ]
        }

        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var barChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
        }

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })

        //-------------
        //- BAR CHART 1 -
        //-------------
        var areaChartData1 = {
            labels  : ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4', 'Tuần 5'],
            datasets: [
                {
                    label               : 'Số tín hữu',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : [25, 22, 20, 24, 27]
                },
            ]
        }

        var barChartCanvas1 = $('#barChart1').get(0).getContext('2d')
        var barChartData1 = $.extend(true, {}, areaChartData1)

        var barChartOptions1 = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
        }

        new Chart(barChartCanvas1, {
            type: 'bar',
            data: barChartData1,
            options: barChartOptions1
        })
    })
</script>
@endsection