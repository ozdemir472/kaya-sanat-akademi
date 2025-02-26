<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>droplet | Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link href="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/css/css.php?file=vendor.min.css" rel="stylesheet">
	<link href="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/css/css.php?file=app.min.css" rel="stylesheet">
    <style>
        .personel-card {
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 15px;
        }

        .personel-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .personel-card:hover .card-title {
            color: #007bff;
            transition: color 0.3s ease;
        }

        .personel-card:hover .btn {
            background-color: #0056b3;
            color: #fff;
            transition: background-color 0.3s ease, color 0.3s ease;
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
                        <div class="row">
                            <?php
                            foreach(json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/listStudents"), true)['data'] as $student):
                            ?>
                                <div class="col-md-3 col-sm-6 card-container" onclick="selectStudent(this, '<?= $student['identity'] ?>')">
                                    <div class="card personel-card">
                                        <img src="assets/images/user.png" class="card-img-top personel-photo" alt="Öğrenci Fotoğrafı">
                                        <div class="card-body text-center">
                                            <h5 class="card-title"><?= $student['studentName'] ?></h5>
                                            <p class="card-text"><?= $student['department'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
    <script>
    function selectStudent(personel, identity) {
        window.location.href = `/studentDetails?identity=${identity}`;
    }
</script>


	<script data-cfasync="false" src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=email-decode.min.js"></script>
	<script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=vendor.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
	<script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=app.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
	<script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=rocket-loader.min.js" data-cf-settings="1b49a6b08b02b05104d24adc-|49" defer></script>
</body>
</html>
