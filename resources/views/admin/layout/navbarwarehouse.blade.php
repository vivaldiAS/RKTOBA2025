<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge" id="notification-count">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header" id="notification-header">0 Notifications</span>
                <div id="notification-items">
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.notifikasiwarehouse.warehouse') }}" class="dropdown-item dropdown-footer">Lihat Semua</a>
            </div>
        </li>
    </ul>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function loadNotifications() {
        $.ajax({
            url: '{{ route('admin.getNotificationsCount.warehouse') }}',
            type: 'GET',
            success: function(data) {
                $('#notification-count').text(data.count);
                $('#notification-header').text(data.count + ' Notifications');

                var notificationItems = $('#notification-items');
                notificationItems.empty();

                if (data.count > 0) {
                    var newProductsItem = '<a href="#" class="dropdown-item">' +
                        '<i class="fas fa-box-open mr-2"></i> ' +
                        data.newProductsCount + ' Produk Baru' +
                        '</a>';
                    notificationItems.append(newProductsItem);

                    var expiringProductsItem = '<a href="#" class="dropdown-item">' +
                        '<i class="fas fa-exclamation-triangle mr-2"></i> ' +
                        data.expiringProductsCount + ' Stok akan Expired' +
                        '</a>';
                    notificationItems.append(expiringProductsItem);
                } else {
                    var emptyMessage = '<span class="dropdown-item"> Tidak ada Notifikasi </span>';
                    notificationItems.append(emptyMessage);
                }
            }
        });
    }

    $(document).ready(function() {
        loadNotifications();
        setInterval(loadNotifications, 60000); // Refresh every 1 minute
    });
</script>

