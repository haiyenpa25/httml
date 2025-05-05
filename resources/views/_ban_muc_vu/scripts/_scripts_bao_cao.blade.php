@section('page-scripts')
<script>
  $(function() {
    // Xử lý nút in báo cáo
    $('#print-report').click(function() {
      window.print();
    });

    // Xử lý nút xuất Excel
    $('#export-excel').click(function() {
      toastr.info('Chức năng xuất Excel đang được phát triển');
    });

    // ChartJS - Biểu đồ tín hữu sinh hoạt với Hội Thánh
    var barChartCanvasHT = $('#barChartHT').get(0).getContext('2d');

    // Chuẩn bị dữ liệu cho biểu đồ Hội Thánh
    var htLabels = [];
    var htData = [];

    @foreach($buoiNhomHT as $index => $buoiNhom)
    htLabels.push('Tuần {{ $index + 1 }} ({{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m') }})');
    htData.push({{ $buoiNhom->so_luong_trung_lao }});
    @endforeach

    // Nếu không có dữ liệu, tạo dữ liệu mẫu
    if (htLabels.length === 0) {
      htLabels = ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4', 'Tuần 5'];
      htData = [30, 32, 28, 35, 40];
    }

    var barDataHT = {
      labels: htLabels,
      datasets: [{
        label: 'Số lượng tín hữu',
        backgroundColor: 'rgba(60,141,188,0.9)',
        borderColor: 'rgba(60,141,188,0.8)',
        pointRadius: false,
        pointColor: '#3b8bba',
        pointStrokeColor: 'rgba(60,141,188,1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data: htData
      }]
    };

    var barOptionsHT = {
      responsive: true,
      maintainAspectRatio: false,
      datasetFill: false,
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    };

    new Chart(barChartCanvasHT, {
      type: 'bar',
      data: barDataHT,
      options: barOptionsHT
    });

    // ChartJS - Biểu đồ tín hữu sinh hoạt Ban Ngành
    var barChartCanvasBN = $('#barChartBN').get(0).getContext('2d');

    // Chuẩn bị dữ liệu cho biểu đồ Ban Ngành
    var bnLabels = [];
    var bnData = [];

    @foreach($buoiNhomBN as $index => $buoiNhom)
    bnLabels.push('Tuần {{ $index + 1 }} ({{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m') }})');
    bnData.push({{ $buoiNhom->so_luong_trung_lao }});
    @endforeach

    // Nếu không có dữ liệu, tạo dữ liệu mẫu
    if (bnLabels.length === 0) {
      bnLabels = ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4', 'Tuần 5'];
      bnData = [25, 22, 20, 24, 27];
    }

    var barDataBN = {
      labels: bnLabels,
      datasets: [{
        label: 'Số lượng tín hữu',
        backgroundColor: 'rgba(40, 167, 69, 0.9)',
        borderColor: 'rgba(40, 167, 69, 0.8)',
        pointRadius: false,
        pointColor: '#28a745',
        pointStrokeColor: 'rgba(40, 167, 69, 1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(40, 167, 69, 1)',
        data: bnData
      }]
    };

    var barOptionsBN = {
      responsive: true,
      maintainAspectRatio: false,
      datasetFill: false,
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    };

    new Chart(barChartCanvasBN, {
      type: 'bar',
      data: barDataBN,
      options: barOptionsBN
    });
  });
</script>

<style>
  @media print {
    .no-print {
      display: none !important;
    }

    .card-header {
      background-color: #4b545c !important;
      color: #fff !important;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .main-header,
    .main-sidebar,
    .main-footer,
    .card-tools,
    .breadcrumb,
    .btn {
      display: none !important;
    }

    .content-wrapper {
      margin-left: 0 !important;
      padding-top: 0 !important;
    }

    .card {
      break-inside: avoid;
    }

    .chart {
      page-break-inside: avoid;
    }
  }
</style>
@endsection