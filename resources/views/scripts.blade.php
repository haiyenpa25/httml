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