<script>
    $(document).ready(function () {
        // Thu Chi Chart
        const thuChiChart = new Chart(document.getElementById('thuChiChart'), {
            type: 'line',
            data: {
                labels: @json($dataChart['labels']),
                datasets: [
                    {
                        label: 'Thu',
                        data: @json($dataChart['thu']),
                        borderColor: '#28a745',
                        fill: false
                    },
                    {
                        label: 'Chi',
                        data: @json($dataChart['chi']),
                        borderColor: '#dc3545',
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return value.toLocaleString('vi-VN') + ' VNĐ';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed.y.toLocaleString('vi-VN') + ' VNĐ';
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Pie Chart
        const pieChart = new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: @json($dataPieChart->pluck('name')),
                datasets: [{
                    data: @json($dataPieChart->pluck('y')),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed.toLocaleString('vi-VN') + ' VNĐ';
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Mark notification as read
        $('.mark-as-read').click(function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            const $notificationItem = $(this).closest('.notification-item, li');

            $.ajax({
                url: '{{ route("_thu_quy.thong_bao.danh_dau_da_doc", ":id") }}'.replace(':id', id),
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        $notificationItem.fadeOut(300, function () {
                            $(this).remove();
                            updateNotificationCount();
                        });
                        toastr.success('Đã đánh dấu thông báo là đã đọc.');
                    } else {
                        toastr.error('Không thể đánh dấu thông báo đã đọc.');
                    }
                },
                error: function (xhr) {
                    toastr.error('Đã xảy ra lỗi khi đánh dấu thông báo: ' + (xhr.responseJSON?.message || 'Lỗi không xác định'));
                }
            });
        });

        // Function to update notification count
        function updateNotificationCount() {
            $.ajax({
                url: '{{ route("_thu_quy.thong_bao.so_luong") }}',
                method: 'GET',
                success: function (response) {
                    const count = response.count || 0;
                    $('#notification-count').text(count);
                    if (count == 0) {
                        $('#notification-count').hide();
                    } else {
                        $('#notification-count').show();
                    }
                },
                error: function () {
                    toastr.error('Không thể cập nhật số lượng thông báo.');
                }
            });
        }

        // Initialize notification count on page load
        updateNotificationCount();
    });
</script>