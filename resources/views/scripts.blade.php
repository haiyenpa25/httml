<!-- CSRF setup cho Ajax -->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<!-- Helper functions -->
<script>
    // Format date using moment.js
    function formatDate(dateString) {
        return dateString ? moment(dateString).format('DD/MM/YYYY') : 'N/A';
    }

    // Debounce function to prevent multiple rapid calls
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }

    // Initialize date pickers if they exist
    $(document).ready(function () {
        if ($('.date-picker').length) {
            $('.date-picker').datetimepicker({
                format: 'L'
            });
        }
    });
</script>