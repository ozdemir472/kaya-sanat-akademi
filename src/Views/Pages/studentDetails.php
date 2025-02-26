<?php
	$student = json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/getStudentByIdentity?identity=". urlencode($_GET['identity'])), true)['data'];
	?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Öğrenci Detayları | Kaya Sanat Akademi</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link href="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/css/css.php?file=vendor.min.css" rel="stylesheet">
		<link href="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/css/css.php?file=app.min.css" rel="stylesheet">
		<style>
			.signature-img {
			max-width: 100%;
			height: auto;
			border: 3px solid #007bff;
			border-radius: 10px;
			box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
			padding: 10px;
			background: #f8f9fa;
			}
			.operation-box {
			display: flex;
			flex-direction: column;
			align-items: center;
			}
			.number-box {
			padding: 10px;
			margin: 5px;
			background-color: #f1f1f1;
			border: 1px solid #ddd;
			border-radius: 4px;
			text-align: center;
			}
			.operator {
			font-size: 20px;
			margin: 0 10px;
			}
			.line {
			margin: 10px 0;
			width: 80%;
			border-top: 2px solid #000;
			}
			.total-box {
			margin-top: 15px;
			padding: 10px;
			background-color: #e7e7e7;
			border: 1px solid #ccc;
			border-radius: 4px;
			text-align: center;
			font-weight: bold;
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
		<div id="content" class="app-content p-0">
		<div class="profile">
		<div class="profile-container">
		<div class="profile-sidebar">
			<div class="desktop-sticky-top">
				<div class="profile-img">
					<img src="/assets/images/user.png" alt="">
				</div>
				<h4><?= $student['studentName'] ?></h4>
				<p>Belirlenmiş öğrenci bilgilerini bu sayfadan görebilirsiniz.</p>
			</div>
		</div>
		<div class="profile-content">
			<ul class="profile-tab nav nav-tabs nav-tabs-v2">
				<li class="nav-item">
					<a href="#lesson-info" class="nav-link active" data-bs-toggle="tab">
						<div class="nav-field">Ders Bilgileri</div>
						<div class="nav-value">-0-</div>
					</a>
				</li>
				<li class="nav-item">
					<a href="#signature-logs" class="nav-link" data-bs-toggle="tab">
						<div class="nav-field">İmza Kayıtları</div>
						<div class="nav-value">-0-</div>
					</a>
				</li>
				<li class="nav-item">
					<a href="#payment-information" class="nav-link" data-bs-toggle="tab">
						<div class="nav-field">Ücret Hesaplaması</div>
						<div class="nav-value">-0-</div>
					</a>
				</li>
			</ul>
			<div class="profile-content-container">
				<div class="row gx-4">
					<div class="col-xl-8">
						<div class="tab-content p-0">
							<div class="tab-pane fade show active" id="lesson-info">
								<div class="list-group">
									<div class="list-group-item d-flex align-items-center">
										<div class="flex-fill px-3 table-responsive">
											<table class="table table-bordered table-striped">
												<thead>
													<tr>
														<th>Zaman</th>
														<th>Pazartesi</th>
														<th>Salı</th>
														<th>Çarşamba</th>
														<th>Perşembe</th>
														<th>Cuma</th>
														<th>Cumartesi</th>
														<th>Pazar</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$api_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/getWeeklyTimetableByIdentity?identity=". urlencode($_GET['identity']);
														
														$ch = curl_init($api_url);
														curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
														$response = curl_exec($ch);
														curl_close($ch);
														
														$data = json_decode($response, true);
														
														if ($data['success'] === true) {
															$lessons = $data['data'];
														} else {
															$lessons = [];
														}
														function isDateInCurrentWeek($date) {
														    $givenDate = DateTime::createFromFormat('Y-m-d', $date);
														    if (!$givenDate) {
														        return false;
														    }
														
														    $now = new DateTime();
														
														    $startOfWeek = (clone $now)->modify('Monday this week');
														    $endOfWeek = (clone $startOfWeek)->modify('+6 days');
														
														    return ($givenDate >= $startOfWeek && $givenDate <= $endOfWeek);
														}
														
														foreach ($lessons as $lesson) {
														    if (isDateInCurrentWeek($lesson['week_number'])) {
														        echo "<tr>";
														        echo "<td>" . $lesson['time_slot'] . "</td>";
														    
														        $days = ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'];
														    
														        foreach ($days as $day) {
														            if ($lesson['dayName'] == $day) {
														                $bgColor = $lesson['paymentStatus'] == 1 ? 'background-color: #d4edda;' : 'background-color: #f8d7da;';
														                echo "<td 
														                        class='lesson-cell' 
														                        data-id='{$lesson['timetableId']}' 
														                        data-payment-status='{$lesson['paymentStatus']}' 
														                        data-identity='{$lesson['identity']}' 
														                        style='$bgColor;'>
														                        " . $lesson['studentName'] . "<br>" . $lesson['LessonName'] . "
														                      </td>";
														            } else {
														                echo "<td>-</td>";
														            }
														        }
														    
														        echo "</tr>";
														    }
														}
														?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="signature-logs">
								<div class="card">
									<div class="card-body">
										<div class="d-flex align-items-center mb-3">
											<div class="flex-fill ps-2">
												<table class="table table-bordered">
													<thead>
														<tr>
															<th>Ders</th>
															<th>Öğretmen</th>
															<th>Tarih</th>
															<th>Saat</th>
															<th>İmza</th>
														</tr>
													</thead>
													<tbody id="lessonTable">
														<?php
															$lessons = json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST']. "/api/getSignaturesByIdentity?identity=". htmlspecialchars($_GET['identity'])), true)['data'];
															
															foreach($lessons as $lesson):
															?> 
														<tr>
															<td><?= $lesson['lessonName'] ?></td>
															<td><?= $lesson['teacherName'] ?></td>
															<td><?= $lesson['lessonDate'] ?></td>
															<td><?= $lesson['lessonTime'] ?></td>
															<td><button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#signatureModal_<?= $lesson['id'] ?>">Gör</button></td>
															<div class="modal fade" id="signatureModal_<?= $lesson['id'] ?>">
																<div class="modal-dialog">
																	<div class="modal-content">
																		<div class="modal-body">
																			<img src="<?= $lesson['signature'] ?>" alt="signatureBase64" class="signature-img" style="max-width: 100%; height: auto;">
																		</div>
																	</div>
																</div>
															</div>
														</tr>
														<?php endforeach;?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="payment-information">
								<div class="list-group">
									<div class="list-group-item d-flex align-items-center">
										<div class="flex-fill px-3 table-responsive">
											<div class="operation-box">
												<?php 
												$lessons = json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/calculateTotalPriceByStudentIdentity?id=". $student['id']), true)['data'];
												for($i=0; $i<$lessons['lessonCount']; $i++):
												?> 
												<div class="number-box">1 Ders (<?= $lessons['payPerLesson'] ?>₺)</div>
												<span class="operator">+</span> 
												<?php 
												endfor;
												?> 
												<div class="line" style="text-align: center;">Katılınılan toplam ders = <?= $lessons['lessonCount'] ?></div>
												<div class="total-box">
													<strong>Toplam:</strong> <?= $lessons['totalPrice'] ?>₺
												</div>
												<div class="end-button">
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4">
						<div class="desktop-sticky-top d-none d-lg-block">
							<div class="card mb-3">
								<div class="card-header fw-bold bg-none d-flex">
									<span class="flex-fill">Öğrenci Bilgileri</span> 
									<a href="#" class="text-body text-opacity-50"><i class="fa fa-cog"></i></a>
								</div>
								<div class="list-group list-group-flush">
									<div class="list-group-item px-3">
										<a href="#" class="card text-body text-decoration-none mb-1">
											<div class="card-body">
												<div class="row no-gutters">
													<div class="col-auto">
														<span class="ml-2">Kullanıcı Adı : <?= $student['studentName'] ?></span><br>
														<span class="ml-2">Kayıt Tarihi : <?= $student['registerDate'] ?></span><br>
														<span class="ml-2">Yaş : <?= $student['age'] ?></span><br>
														<span class="ml-2">Kayıt Bölümü : <?= $student['department'] ?></span><br>
														<span class="ml-2">Kimlik No : <?= $student['identity'] ?></span><br>
													</div>
												</div>
											</div>
										</a>
									</div>
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