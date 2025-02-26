<?php
$user = json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/getUserBySession?session_id=". session_id()), true)['data'];
?>
<div id="sidebar" class="app-sidebar">
	<div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
		<div class="menu">
			<div class="menu-profile">
				<a href="javascript:;" class="menu-profile-link" data-bs-toggle="dropdown">
					<div class="menu-profile-cover with-shadow"></div>
					<div class="menu-profile-image">
						<div class="menu-profile-img" style="background-image: url(assets/images/user.png)"></div>
					</div>
					<div class="menu-profile-info">
						<div class="d-flex align-items-center">
							<div class="flex-grow-1 fw-bold">
								<?= $user['name'] ?>
							</div>
							<div class="ms-auto"><i class="fa fa-chevron-down"></i></div>
						</div>
						<small><?= $user['email'] ?></small>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-end me-lg-3 mt-1 w-200px">
					<a class="dropdown-item d-flex align-items-center" href="profile.html"><i class="far fa-user fa-fw fa-lg me-3"></i> Profile</a>
					<a class="dropdown-item d-flex align-items-center" href="email_inbox.html"><i class="far fa-envelope fa-fw fa-lg me-3"></i> Inbox</a>
					<a class="dropdown-item d-flex align-items-center" href="calendar.html"><i class="far fa-calendar fa-fw fa-lg me-3"></i> Calendar</a>
					<a class="dropdown-item d-flex align-items-center" href="settings.html"><i class="fa fa-sliders fa-fw fa-lg me-3"></i> Settings</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item d-flex align-items-center" href="page_login.html"><i class="fa fa-arrow-right-from-bracket fa-fw fa-lg me-3"></i> Logout</a>
				</div>
			</div>
			<div class="menu-header">Genel</div>
			<div class="menu-item <?php if($_SERVER['REQUEST_URI'] == "/dashboard"){ echo "active"; } ?>">
				<a href="/dashboard" class="menu-link">
					<span class="menu-icon"><i class="fa fa-qrcode"></i></span>
					<span class="menu-text">Anasayfa</span>
				</a>
			</div>
			<div class="menu-item <?php if($_SERVER['REQUEST_URI'] == "/students"){ echo "active"; } ?>">
				<a href="/students" class="menu-link">
					<span class="menu-icon"><i class="fa-solid fa-graduation-cap"></i></span>
					<span class="menu-text">Öğrenciler</span>
				</a>
			</div>
			<div class="menu-item <?php if($_SERVER['REQUEST_URI'] == "/lessons"){ echo "active"; } ?>">
				<a href="/lessons" class="menu-link">
					<span class="menu-icon"><i class="fa-solid fa-book-open"></i></span>
					<span class="menu-text">Dersler</span>
				</a>
			</div>
			<div class="menu-item <?php if($_SERVER['REQUEST_URI'] == "/studentSelection"){ echo "active"; } ?>">
				<a href="/studentSelection" class="menu-link">
					<span class="menu-icon"><i class="fa-solid fa-signature"></i></span>
					<span class="menu-text">Dijital İmza</span>
				</a>
			</div>
			<div class="menu-header">Sistem</div>
			<div class="menu-item <?php if($_SERVER['REQUEST_URI'] == "/registerStudent"){ echo "active"; } ?>">
				<a href="/registerStudent" class="menu-link">
					<span class="menu-icon"><i class="fa-solid fa-signature"></i></span>
					<span class="menu-text">Öğrenci Kayıt</span>
				</a>
			</div>
            
			<div class="menu-item <?php if($_SERVER['REQUEST_URI'] == "/registerStudentLesson"){ echo "active"; } ?>">
				<a href="/registerStudentLesson" class="menu-link">
					<span class="menu-icon"><i class="fa-solid fa-signature"></i></span>
					<span class="menu-text">Öğrenci Ders Kayıt</span>
				</a>
			</div>
            
			<div class="menu-item <?php if($_SERVER['REQUEST_URI'] == "/registerTeacher"){ echo "active"; } ?>">
				<a href="/registerTeacher" class="menu-link">
					<span class="menu-icon"><i class="fa-solid fa-signature"></i></span>
					<span class="menu-text">Öğretmen Kayıt</span>
				</a>
			</div>
            
			<div class="menu-item <?php if($_SERVER['REQUEST_URI'] == "/settings"){ echo "active"; } ?>">
				<a href="/settings" class="menu-link">
					<span class="menu-icon"><i class="fa-solid fa-signature"></i></span>
					<span class="menu-text">Sistem Ayarları</span>
				</a>
			</div>
			<div class="menu-item <?php if($_SERVER['REQUEST_URI'] == "/systemLogs"){ echo "active"; } ?>">
				<a href="/systemLogs" class="menu-link">
					<span class="menu-icon"><i class="fa-solid fa-signature"></i></span>
					<span class="menu-text">Sistem Kayıtları</span>
				</a>
			</div>
		</div>
		<div class="p-3 mt-auto">
			<a href="https://wa.me/905389223508" target="_blank" class="btn d-block btn-theme fs-13px fw-semibold rounded-pill">
				<i class="fa fa-code-branch me-2 ms-n2 opacity-5"></i> İletişim
			</a>
		</div>
	</div>
</div>