<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<!-- Select2 JS - PHẢI nằm sau jQuery -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<script src="{{ asset('dist/js/pages/dashboard2.js') }}"></script>

<!-- CSRF Setup for Ajax -->
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>

<!-- Các scripts khác -->
@stack('scripts')

<script>
  $(function () {
    // === Các hàm cũ nếu có ===
    function getSundaysInMonth(year, month) {
      const sundays = [];
      const date = new Date(year, month, 1);
      while (date.getMonth() === month) {
        if (date.getDay() === 0) {
          sundays.push(new Date(date));
        }
        date.setDate(date.getDate() + 1);
      }
      return sundays;
    }

    const today = new Date();
    const sundays = getSundaysInMonth(today.getFullYear(), today.getMonth());
    const sundaySelect = $('#sunday-select');
    sundays.forEach(sunday => {
      const option = new Option(
        sunday.toLocaleDateString('vi-VN', {
          weekday: 'long',
          day: '2-digit',
          month: '2-digit',
          year: 'numeric'
        }),
        sunday.toISOString().split('T')[0]
      );
      sundaySelect.append(option);
    });

    // Kích hoạt select2
    $('.select2').select2();
    $('.select2bs4').select2({ theme: 'bootstrap4' });

    console.log('Select2 loaded:', typeof $.fn.select2); // Kiểm tra đã load Select2 chưa

    // Kích hoạt datetimepicker
    $('#visit-date').datetimepicker({ format: 'L' });
  });
</script>




<script>
  var areaChartData = {
    labels  : ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4', 'Tuần 5'],
    datasets: [
      {
        label               : 'Chúa Nhật',
        backgroundColor     : 'rgba(210, 214, 222, 1)',
        borderColor         : 'rgba(210, 214, 222, 1)',
        data                : [45, 48, 42, 47, 43]
      },
      {
        label               : 'Ban Ngành',
        backgroundColor     : 'rgba(60,141,188,0.9)',
        borderColor         : 'rgba(60,141,188,0.8)',
        data                : [25, 30, 28, 20, 24]
      }
    ]
  }

  var barChartCanvas = $('#barChart').get(0).getContext('2d')
  var barChartData = $.extend(true, {}, areaChartData)
  var temp0 = areaChartData.datasets[0]
  var temp1 = areaChartData.datasets[1]
  barChartData.datasets[0] = temp1
  barChartData.datasets[1] = temp0

  var barChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    datasetFill: false,
    scales: {
      y: {
        beginAtZero: true,
        min: 0,
        max: 50,
        ticks: {
          stepSize: 10
        }
      }
    }
  }

  new Chart(barChartCanvas, {
    type: 'bar',
    data: barChartData,
    options: barChartOptions
  })
</script>



<script>
  var areaChartData = {
    labels  : ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4', 'Tuần 5'],
    datasets: [
      {
        label               : 'Chúa Nhật',
        backgroundColor     : 'rgba(210, 214, 222, 1)',
        borderColor         : 'rgba(210, 214, 222, 1)',
        data                : [45, 48, 42, 47, 43]
      },
      {
        label               : 'Ban Ngành',
        backgroundColor     : 'rgba(60,141,188,0.9)',
        borderColor         : 'rgba(60,141,188,0.8)',
        data                : [25, 30, 28, 20, 24]
      }
    ]
  }

  var barChartCanvas = $('#barChart').get(0).getContext('2d')
  var barChartData = $.extend(true, {}, areaChartData)
  var temp0 = areaChartData.datasets[0]
  var temp1 = areaChartData.datasets[1]
  barChartData.datasets[0] = temp1
  barChartData.datasets[1] = temp0

  var barChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    datasetFill: false,
    scales: {
      y: {
        beginAtZero: true,
        min: 0,
        max: 50,
        ticks: {
          stepSize: 10
        }
      }
    }
  }

  new Chart(barChartCanvas, {
    type: 'bar',
    data: barChartData,
    options: barChartOptions
  })
</script>

<script>
  var areaChartData1 = {
    labels  : ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4', 'Tuần 5'],
    datasets: [
      {
        label           : 'Chúa Nhật',
        backgroundColor : 'rgba(210, 214, 222, 1)',
        borderColor     : 'rgba(210, 214, 222, 1)',
        data            : [45, 48, 42, 47, 43]
      },
      {
        label           : 'Ban Ngành',
        backgroundColor : 'rgba(60,141,188,0.9)',
        borderColor     : 'rgba(60,141,188,0.8)',
        data            : [25, 30, 28, 20, 24]
      }
    ]
  }

  var barChartCanvas1 = $('#barChart1').get(0).getContext('2d')
  var barChartData1 = $.extend(true, {}, areaChartData1)
  var temp0_1 = areaChartData1.datasets[0]
  var temp1_1 = areaChartData1.datasets[1]
  barChartData1.datasets[0] = temp1_1
  barChartData1.datasets[1] = temp0_1

  var barChartOptions1 = {
    responsive: true,
    maintainAspectRatio: false,
    datasetFill: false,
    scales: {
      y: {
        beginAtZero: true,
        min: 0,
        max: 50,
        ticks: {
          stepSize: 10
        }
      }
    }
  }

  new Chart(barChartCanvas1, {
    type: 'bar',
    data: barChartData1,
    options: barChartOptions1
  })
</script>
