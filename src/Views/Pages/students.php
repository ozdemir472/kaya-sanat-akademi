<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Öğrenciler | Kaya Sanat Akademi</title>
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
					Öğrenci Listesi Ekranı
					<small class="d-block fs-12px mt-1">Bu sayfada sistem detaylarını öğrenci sayısını vs. görebilirsiniz.</small>
				</h3>
			</div>
			<div class="row">
				<div class="col-xl-12 col-lg-6">
					<div class="card bg-size-cover mb-6 p-2">
						<div class="card-body">
    						<div class="row">
							<table class="table">
							    <thead>
							        <tr>
							            <th>ID</th>
							            <th>Adı Soyadı</th>
							            <th>Kayıt Tarihi</th>
							            <th>Yaş</th>
							            <th>Alanı</th>
							            <th>Kimlik ID</th>
							            <th>Ayarlar</th>
							        </tr>
							    </thead>
							    <tbody>
							        <?php foreach (json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/listStudents"), true)['data'] as $student) : ?>
							        <tr>
							            <td><?= $student['id'] ?></td>
							            <td><?= $student['studentName'] ?></td>
							            <td><?= $student['registerDate'] ?></td>
							            <td><?= $student['age'] ?></td>
							            <td><?= $student['department'] ?></td>
							            <td><?= $student['identity'] ?></td>
							            <td>
							                <button 
							                    class="btn btn-sm btn-primary edit-btn" 
							                    data-id="<?= $student['id'] ?>" 
							                    data-name="<?= $student['studentName'] ?>" 
							                    data-date="<?= $student['registerDate'] ?>" 
							                    data-age="<?= $student['age'] ?>" 
							                    data-department="<?= $student['department'] ?>" 
							                    data-identity="<?= $student['identity'] ?>"
							                    data-bs-toggle="modal" 
							                    data-bs-target="#editStudentModal">
							                    Düzenle
							                </button>
							            </td>
							        </tr>
							        <?php endforeach; ?>
							    </tbody>
							</table>
 
    						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <form id="editStudentForm" method="POST" action="/api/editStudent">
	                <div class="modal-header">
	                    <h5 class="modal-title" id="editStudentModalLabel">Öğrenci Bilgilerini Düzenle</h5>
	                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	                </div>
	                <div class="modal-body">
	                    <input type="hidden" name="id" id="editStudentId">
	                    <div class="mb-3">
	                        <label for="editStudentName" class="form-label">Adı Soyadı</label>
	                        <input type="text" class="form-control" name="studentName" id="editStudentName" required>
	                    </div>
	                    <div class="mb-3">
	                        <label for="editRegisterDate" class="form-label">Kayıt Tarihi</label>
	                        <input type="date" disabled class="form-control" name="registerDate" id="editRegisterDate" required>
	                    </div>
	                    <div class="mb-3">
	                        <label for="editStudentAge" class="form-label">Yaş</label>
	                        <input type="number" class="form-control" name="age" id="editStudentAge" required>
	                    </div>
	                    <div class="mb-3">
	                        <label for="editStudentDepartment" class="form-label">Alanı</label>
	                        <input type="text" disabled class="form-control" name="department" id="editStudentDepartment" required>
	                    </div>
	                    <div class="mb-3">
	                        <label for="editStudentIdentity" class="form-label">Kimlik ID</label>
	                        <input type="text" disabled class="form-control readd" name="identity" id="editStudentIdentity" required>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
	                    <button type="submit" class="btn btn-primary">Kaydet</button>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>

	<script>
document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".edit-btn");
    const editForm = document.getElementById("editStudentForm");

    // "Düzenle" butonlarının her biri için olay dinleyicisi
    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            // Verileri butonun data-* özelliklerinden al ve formdaki inputlara ata
            document.getElementById("editStudentId").value = this.getAttribute("data-id");
            document.getElementById("editStudentName").value = this.getAttribute("data-name");
            document.getElementById("editRegisterDate").value = this.getAttribute("data-date");
            document.getElementById("editStudentAge").value = this.getAttribute("data-age");
            document.getElementById("editStudentDepartment").value = this.getAttribute("data-department");
            document.getElementById("editStudentIdentity").value = this.getAttribute("data-identity");
        });
    });

    // Form gönderiminde istek atma işlemi
    editForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Formun varsayılan gönderimini durdur
        const formData = new FormData(this);

        // Butonu kilitle (tekrar tıklamayı engellemek için)
        const submitButton = this.querySelector("button[type='submit']");
        if (submitButton.disabled) {
            return; // Eğer buton zaten devre dışı ise, işlemden çık
        }

        submitButton.disabled = true; // Tekrar gönderimi engelle

        fetch(this.action, {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Öğrenci bilgileri başarıyla güncellendi!");
                location.reload(); // Sayfayı yenile
            } else {
                alert("Bir hata oluştu: " + data.message);
            }
        })
        .catch(error => {
            console.error("Hata:", error);
        })
        .finally(() => {
            // Butonu tekrar aktif et
            submitButton.disabled = false;
        });
    });
});
</script>

	<script data-cfasync="false" src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=email-decode.min.js"></script>
	<script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=vendor.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
	<script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=app.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
	<script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=rocket-loader.min.js" data-cf-settings="1b49a6b08b02b05104d24adc-|49" defer></script>
</body>
</html>
