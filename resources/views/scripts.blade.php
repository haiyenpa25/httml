<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<!-- jQuery UI -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script> $.widget.bridge('uibutton', $.ui.button) </script>

<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>

<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.world.js') }}"></script>

<!-- jQuery Knob -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>

<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

<!-- Tempusdominus -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<!-- AdminLTE -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<script src="{{ asset('dist/js/demo.js') }}"></script>

<!-- CSRF setup -->
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>

<!-- Custom Scripts -->
<script>
  $(function () {
    // ===== Select2 =====
    $('.select2').select2()
    $('.select2bs4').select2({ theme: 'bootstrap4' })

    // ===== DateTimePicker =====
    $('#visit-date').datetimepicker({ format: 'L' })

    // ===== Populate Sundays =====
    function getSundaysInMonth(year, month) {
      const sundays = []
      const date = new Date(year, month, 1)
      while (date.getMonth() === month) {
        if (date.getDay() === 0) sundays.push(new Date(date))
        date.setDate(date.getDate() + 1)
      }
      return sundays
    }

    const today = new Date()
    const sundays = getSundaysInMonth(today.getFullYear(), today.getMonth())
    const sundaySelect = $('#sunday-select')
    sundays.forEach(sunday => {
      const option = new Option(
        sunday.toLocaleDateString('vi-VN', {
          weekday: 'long', day: '2-digit', month: '2-digit', year: 'numeric'
        }),
        sunday.toISOString().split('T')[0]
      )
      sundaySelect.append(option)
    })
  })
</script>

<!-- ChartJS - Bar Chart -->
<script>
  function renderBarChart(canvasId, data) {
    const ctx = document.getElementById(canvasId)
    if (!ctx) return console.warn(`Canvas ${canvasId} not found.`)
    const chart = new Chart(ctx.getContext('2d'), {
      type: 'bar',
      data: data,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            max: 50,
            ticks: { stepSize: 10 }
          }
        }
      }
    })
  }

  const areaChartData = {
    labels: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4', 'Tuần 5'],
    datasets: [
      {
        label: 'Chúa Nhật',
        backgroundColor: 'rgba(210, 214, 222, 1)',
        borderColor: 'rgba(210, 214, 222, 1)',
        data: [45, 48, 42, 47, 43]
      },
      {
        label: 'Ban Ngành',
        backgroundColor: 'rgba(60,141,188,0.9)',
        borderColor: 'rgba(60,141,188,0.8)',
        data: [25, 30, 28, 20, 24]
      }
    ]
  }

  document.addEventListener('DOMContentLoaded', function () {
    renderBarChart('barChart', areaChartData)
    renderBarChart('barChart1', areaChartData)
  })
</script>

<!-- JQVMap -->
<script>
  $(function () {
    if ($('#map').length > 0) {
      $('#map').vectorMap({
        map: 'world_en',
        backgroundColor: '#f4f3f0',
        color: '#ffffff',
        hoverOpacity: 0.7,
        selectedColor: '#666666',
        enableZoom: true,
        showTooltip: true
      })
    }
  })
</script>

<!-- Allow pushing custom scripts -->
@stack('scripts')
