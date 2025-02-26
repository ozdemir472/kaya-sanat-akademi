<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Sistem Kayıtları | Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/css/css.php?file=vendor.min.css" rel="stylesheet">
        <link href="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/css/css.php?file=app.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
		<style>
			.filter-container .form-group {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

.filter-container .form-group .form-control {
    width: 300px;
    max-width: 100%; /* Genişliği belirleyebilirsiniz */
}

.filter-container .form-group .mr-2 {
    margin-right: 10px;
}

.filter-container .form-group .mb-2 {
    margin-bottom: 10px;
}

.filter-container .form-group button {
    width: 100%; /* Butonu altta ortalamak için */
}

		</style>
    </head>
    <body>
        <div id="app" class="app">
            <div id="header" class="app-header">
                <div class="desktop-toggler">
                    <button type="button" class="menu-toggler" data-toggle-class="app-sidebar-collapsed" data-toggle-target=".app">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    </button>
                </div>
                <div class="mobile-toggler">
                    <button type="button" class="menu-toggler" data-toggle-class="app-sidebar-mobile-toggled" data-toggle-target=".app">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    </button>
                </div>
                <div class="brand">
                    <a href="/dashboard" class="brand-logo">
                    Kaya Sanat Akademi
                    </a>
                </div>
                <div class="menu">
                    <div class="menu-item dropdown dropdown-mobile-full">
                        <a href="#" data-bs-toggle="dropdown" data-bs-display="static" class="menu-link">
                            <div class="menu-img online">
                                <span class="menu-img-bg" style="background-image: url(assets/images/user.png)"></span>
                            </div>
                            <div class="menu-text d d-none"><span class="__cf_email__" data-cfemail="dca9afb9aeb2bdb1b99cbdbfbfb3a9b2a8f2bfb3b1">[email&#160;protected]</span></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end me-lg-3 mt-1 w-200px">
                            <a class="dropdown-item d-flex align-items-center" href="#"><i class="far fa-user fa-fw fa-lg me-3"></i> Profil</a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i class="far fa-envelope fa-fw fa-lg me-3"></i> Derslerim</a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i class="fa fa-sliders fa-fw fa-lg me-3"></i> Ayarlar</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item d-flex align-items-center" href="/logout"><i class="fa fa-arrow-right-from-bracket fa-fw fa-lg me-3"></i> Çıkış Yap</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("./src/Views/Includes/sidebar.php"); ?>
            <button class="app-sidebar-mobile-backdrop" data-toggle-target=".app" data-toggle-class="app-sidebar-mobile-toggled"></button>
            <div id="content" class="app-content">
                <div class="d-lg-flex align-items-end mb-4">
                    <h3 class="page-header mb-lg-0">
                        Öğrenci Listesi Ekranı
                        <small class="d-block fs-12px mt-1">Bu sayfada sistem detaylarını öğrenci sayısını vs. görebilirsiniz.</small>
                    </h3>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-6">
                        <div class="card bg-size-cover mb-6 p-2">
                            <div class="card-body">
                                <div class="row table-responsive">
								<div class="filter-container">
    <form id="filterForm" class="form">
        <div class="form-group mb-2 d-flex flex-wrap">
            <div class="mr-2 mb-2">
                <label for="userId" class="mr-2">Kullanıcı ID:</label>
                <input type="text" class="form-control" id="userId" placeholder="Kullanıcı ID">
            </div>
            <div class="mr-2 mb-2">
                <label for="startDate" class="mr-2">Başlangıç Tarihi:</label>
                <input type="date" class="form-control" id="startDate">
            </div>
            <div class="mr-2 mb-2">
                <label for="endDate" class="mr-2">Bitiş Tarihi:</label>
                <input type="date" class="form-control" id="endDate">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Filtrele</button>
    </form>
</div>

                                    <table id="logTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>IP Adresi</th>
                                                <th>Kullanıcı ID</th>
                                                <th>User Agent</th>
                                                <th>İşletim Sistemi</th>
                                                <th>Tarayıcı</th>
                                                <th>Cihaz Türü</th>
                                                <th>Sayfa</th>
                                                <th>Yönlendiren</th>
                                                <th>Son Ziyaret</th>
                                                <th>Mesaj</th>
                                                <th>Durum</th>
                                                <th>Zaman</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                var table = $('#logTable').DataTable({
                    "ajax": "api/getAllLogs",
                    "columns": [
                        { "data": "id" },
                        { "data": "ip_address" },
                        { "data": "userId" },
                        { "data": "user_agent" },
                        { "data": "os" },
                        { "data": "browser" },
                        { "data": "device_type" },
                        { "data": "current_page" },
                        { "data": "referrer" },
                        { "data": "last_visit" },
                        { "data": "message" },
                        { "data": "status" },
                        { "data": "timestamp" }
                    ]
                });
            
                $('#filterForm').submit(function(e) {
                    e.preventDefault();

					var userId = $('#userId').val().toLowerCase();
                    var startDate = $('#startDate').val();
                    var endDate = $('#endDate').val();
            
                    table.rows().every(function() {
                        var row = this.data();
            
                        var match = true;
            
                        if (userId && row.userId && !row.userId.toString().toLowerCase().includes(userId)) {
                            match = false;
                        }
            
                        if (startDate && row.timestamp && new Date(row.timestamp) < new Date(startDate)) {
                            match = false;
                        }
                        if (endDate && row.timestamp && new Date(row.timestamp) > new Date(endDate)) {
                            match = false;
                        }
            
                        var rowNode = this.node();
                        if (match) {
                            $(rowNode).show();
                        } else {
                            $(rowNode).hide();
                        }
                    });
                });
            });
            
                
        </script>
    </body>
</html>