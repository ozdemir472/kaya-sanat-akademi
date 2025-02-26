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
					Anasayfa
					<small class="d-block fs-12px mt-1">Bu sayfada sistem detaylarını öğrenci sayısını vs. görebilirsiniz.</small>
				</h3>
			</div>

			<div class="row">
				<div class="col-xl-3 col-lg-6">
					<div class="card bg-size-cover mb-3 border-dark" data-bs-theme="dark">
						<div class="card-body">
							<div class="mb-3 fw-semibold d-flex align-items-center">
								<div class="flex-fill">Aktif Öğrenci Sayısı</div>
								<div>
									<a href="#" data-bs-toggle="dropdown" class="text-body"><i class="bi bi-three-dots-vertical"></i></a>
									<div class="dropdown-menu dropdown-menu-end" data-bs-theme="light">
										<a href="#" class="dropdown-item">Öğrenci Listesini Gör</a>
									</div>
								</div>
							</div>
							<div class="row mb-1">
								<div class="col-lg-12 position-relative">
									<h3>
										<div id="studentsCount">0</div>
									</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-6">
					<div class="card mb-3">
						<div class="card-body">
							<div class="mb-3 fw-semibold d-flex align-items-center">
								<div class="flex-fill">Toplam Öğretmen</div>
								<div>
									<a href="#" data-bs-toggle="dropdown" class="text-body"><i class="bi bi-three-dots-vertical"></i></a>
									<div class="dropdown-menu dropdown-menu-end" data-bs-theme="light">
										<a href="#" class="dropdown-item">Öğretmen Listesini Gör</a>
									</div>
								</div>
							</div>
							<div class="row mb-1">
								<div class="col-lg-12 position-relative">
									<h3 class="mb-0 d-flex">
										<div id="teachersCount">0</div>
									</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6">
					<div class="card mb-3">
						<div class="card-body">
							<div class="mb-3 fw-semibold d-flex align-items-center">
								<div class="flex-fill">Toplam İmza Sayısı</div>
								<div>
									<a href="#" data-bs-toggle="dropdown" class="text-body"><i class="bi bi-three-dots-vertical"></i></a>
									<div class="dropdown-menu dropdown-menu-end" data-bs-theme="light">
										<a href="#" class="dropdown-item">İmza Kayıtlarını Gör</a>
									</div>
								</div>
							</div>
							<div class="row mb-1">
								<div class="col-lg-12 position-relative">
									<h3>
										<div id="signaturesCount">0</div>
									</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-6 pb-3">
					<div class="card mb-3">
						<div class="card-body">
							<div class="mb-3 fw-semibold d-flex align-items-center">
								<div class="flex-fill">Son İmza Atan Öğrenciler</div>
								<div>
									<a href="#" data-bs-toggle="dropdown" class="text-body"><i class="bi bi-three-dots-vertical"></i></a>
									<div class="dropdown-menu dropdown-menu-end" data-bs-theme="light">
										<a href="/systemLogs" class="dropdown-item">Sistem Kayıtlarını Gör</a>
									</div>
								</div>
							</div>
							<hr class="opacity-1">
							<?php 
							$apiURL = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/getLastSignatures";
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, $apiURL);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							$response = json_decode(curl_exec($ch), true);
							curl_close($ch);
							foreach ($response['data'] as $log):
							$user = json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/getStudentById?id=". $log['userId']), true)['data'];
							?> 
							<div class="d-flex align-items-center">
								<div>
									<div class="w-40px h-40px fs-20px my-n1 rounded-pill d-flex align-items-center justify-content-center bg-danger-subtle text-danger">
										<i class="fa-solid fa-signature"></i>
									</div>
								</div>
								<div class="flex-1 px-3">
									<h6 class="mb-0 fw-semibold"><?= $user['studentName'] ?> adlı öğrenci derse girdiğini imzaladı. </h6>
									<div class="text-muted small">az önce</div>
								</div>
								<div class="fs-20px">
									<a href="#" class="text-body text-opacity-30"><i class="bi bi-search"></i></a>
								</div>
							</div>
							<?php endforeach; ?> 
						</div>
					</div>
				</div>
				<div class="col-xl-6 pb-3">
					<div class="card mb-3">
						<div class="card-body">
							<div class="mb-3 fw-semibold d-flex align-items-center">
								<div class="flex-fill">Son Giriş Yapan Öğretmenler</div>
								<div>
									<a href="#" data-bs-toggle="dropdown" class="text-body"><i class="bi bi-three-dots-vertical"></i></a>
									<div class="dropdown-menu dropdown-menu-end" data-bs-theme="light">
										<a href="/systemLogs" class="dropdown-item">Sistem Kayıtlarını Gör</a>
									</div>
								</div>
							</div>
							<?php 
							$apiURL = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/getLastLogins";
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, $apiURL);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							$response = json_decode(curl_exec($ch), true);
							curl_close($ch);
							foreach ($response['data'] as $log):
							$user = json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/getUserById?id=". $log['userId']), true)['data'];
							?> 
							<hr class="opacity-1">
							<div class="d-flex align-items-center">
								<div>
									<div class="w-40px h-40px fs-20px my-n1 rounded-pill d-flex align-items-center justify-content-center bg-theme-subtle text-theme">
										<i class="bi bi-key-fill"></i>
									</div>
								</div>
								<div class="flex-1 px-3">
									<h6 class="mb-0 fw-semibold"><?= $user['name'] ?> adlı öğretmen giriş yaptı.</h6>
									<div class="text-muted small"><?= $log['timestamp'] ?></div>
								</div>
							</div>
							<?php endforeach; ?> 
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<script>
		async function fetchDataAndRender() {
		    try {
		        const [studentsResponse, teachersResponse, signaturesResponse] = await Promise.all([
		            fetch('/api/getStudentsCount'),
		            fetch('/api/getTeachersCount'),
		            fetch('/api/getSignaturesCount')
		        ]);
			
		        const students = await studentsResponse.json();
		        const teachers = await teachersResponse.json();
		        const signatures = await signaturesResponse.json();
			
		        document.querySelector('#studentsCount').textContent = students.data || 0;
		        document.querySelector('#teachersCount').textContent = teachers.data || 0;
		        document.querySelector('#signaturesCount').textContent = signatures.data || 0;
		    } catch (error) {
		        console.error('Veri çekerken bir hata oluştu:', error);
		    }
		}

		document.addEventListener("DOMContentLoaded", () => {
		    fetchDataAndRender();
		});

	</script>
	
	<script data-cfasync="false" src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=email-decode.min.js"></script>
	<script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=vendor.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
	<script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=app.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
	<script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=rocket-loader.min.js" data-cf-settings="1b49a6b08b02b05104d24adc-|49" defer></script>
</body>
</html>
