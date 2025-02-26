<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Ayarlar | Kaya Sanat Akademi</title>
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
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-xl-10">
						<div class="row">
							<div class="col-xl-9">
								<div id="admin" class="mb-5">
									<h4><i class="far fa-user fa-fw text-body text-opacity-50 me-1"></i>Çalışma Saatleri/Günleri</h4>
									<p>Çalışma saatlerinizi ve günlerinizi ayarlayabilirsiniz.</p>
									<div class="card">
										<div class="list-group list-group-flush">
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>Çalışma Saatleri</div>
													<div class="text-body text-opacity-50"></div>
												</div>
												<div class="w-100px">
													<a href="#workingHours" data-bs-toggle="modal" class="btn btn-default w-100px">Ayarla</a>
												</div>
											</div>
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>Çalışma Günleri</div>
													<div class="text-body text-opacity-50"></div>
												</div>
												<div class="w-100px">
													<a href="#workingDays" data-bs-toggle="modal" class="btn btn-default w-100px">Ayarla</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="users" class="mb-5">
									<h4><i class="far fa-user fa-fw text-body text-opacity-50 me-1"></i>Kullanıcı Ayarları</h4>
									<p>Yetkili kullanıcı oluşturabilir veya silebilirsiniz.</p>
									<div class="card">
										<div class="list-group list-group-flush">
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>Kulanıcı Oluştur</div>
													<div class="text-body text-opacity-50"></div>
												</div>
												<div class="w-100px">
													<a href="#createUser" data-bs-toggle="modal" class="btn btn-default w-100px">Oluştur</a>
												</div>
											</div>
											<div class="list-group-item d-flex align-items-center">
												<div class="flex-1 text-break">
													<div>Kulanıcı Sil</div>
													<div class="text-body text-opacity-50"></div>
												</div>
												<div class="w-100px">
													<a href="#removeUser" data-bs-toggle="modal" class="btn btn-default w-100px">Sil</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3">
								<nav id="sidebar-bootstrap" class="navbar navbar-sticky d-none d-xl-block">
									<nav class="nav">
										<a class="nav-link" href="#admin" data-toggle="scroll-to">Yetkili Kullanıcı Ayarları</a>
									</nav>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="workingHours">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Çalışma Saatlerini Düzenle</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<div class="list-group" id="hour-group">
								<!-- dynamic data -->
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-theme" id="save-hours">Save changes</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="workingDays">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Çalışma Saatlerini Düzenle</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<div class="list-group" id="day-group">
								<!-- dynamic data -->
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-theme" id="save-days">Save changes</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="createUser">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Kullanıcı Oluştur</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<input type="text" class="form-control" placeholder="Kullanıcı Adı" name="username" id="username">
                        </div>
						<div class="mb-3">
							<input type="text" class="form-control" placeholder="İsim" name="longname" id="longname">
                        </div>
						<div class="mb-3">
							<input type="password" class="form-control" placeholder="Şifre" name="password" id="password">
                        </div>
						<div class="mb-3">
							<input type="email" class="form-control" placeholder="E-Mail giriniz" name="email" id="email">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-bs-dismiss="modal">Kapat</button>
						<button type="button" class="btn btn-theme" id="save-user">Kaydet</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="removeUser">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Kullanıcı Sil</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<select class="form-select" id="remove-user-select">
								<?php 
								$users = json_decode(file_get_contents( $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/getUsers"), true)['data'];
								foreach($users as $user):
								?> 
								<option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
								<?php
								endforeach;
								?> 
							</select>
                        </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-bs-dismiss="modal">Kapat</button>
						<button type="button" class="btn btn-theme" id="remove-user">Sil</button>
					</div>
				</div>
			</div>
		</div>
		<script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=settings.js"></script>
		<script data-cfasync="false" src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=email-decode.min.js"></script>
		<script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=vendor.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
		<script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=app.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
		<script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=rocket-loader.min.js" data-cf-settings="1b49a6b08b02b05104d24adc-|49" defer></script>
	</body>
</html>