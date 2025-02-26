<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Öğretmen Kayıt | Kaya Sanat Akademi</title>
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
                        <div class="menu-text d d-none"><span class="__cf_email__" data-cfemail="[email&#160;protected]">[email&#160;protected]</span></div>
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
                            <div class="col-xl-12">
                                <div id="student" class="mb-5">
                                    <h4><i class="far fa-user fa-fw text-body text-opacity-50 me-1"></i> Öğretmen Kayıt</h4>
                                    <p>Öğretmen bilgilerini girerek kaydedebilirsiniz.</p>
                                    <div class="card">
                                        <div class="card-body">
                                            <form id="teacherForm" method="POST" action="/api/regis" enctype="multipart/form-data">
                                                <div class="mb-3">
                                                    <label for="teacherName" class="form-label">Öğretmen Adı</label>
                                                    <input type="text" class="form-control" id="teacherName" name="teacherName" placeholder="Öğretmen adını giriniz" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="registerDate" class="form-label">Kayıt Tarihi</label>
                                                    <input type="date" class="form-control" id="registerDate" name="registerDate" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="department" class="form-label">Bölüm</label>
                                                    <select class="form-select" id="department" name="department" required>
                                                        <option value="" disabled selected>Bölüm seçiniz</option>
                                                        <?php
                                                            $data = json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/getLessons"), true)['data'];
                                                            foreach($data as $departments):
                                                        ?> 
                                                        <option value="<?= $departments['id'] ?>"><?= $departments['LessonName'] ?></option>
                                                        <?php endforeach;?> 
                                                    </select>
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit" id="submit" class="btn btn-theme">Kaydet</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<script>
    	    document.getElementById("teacherForm").addEventListener("submit", function (e) {
    	        e.preventDefault();

    	        const form = document.getElementById("teacherForm");

    	        const formData = new FormData(form);

    	        fetch("/api/registerTeacher", {
    	            method: "POST",
    	            body: formData 
    	        })
    	        .then(response => response.json())
    	        .then(data => {
    	            if (data.success == true) {
    	                showToast("Öğretmen kaydı başarıyla yapıldı!", "success");
    	                window.location.reload;
    	            } else {
    	                showToast("Bir hata meydana geldi!", "danger");
    	            }
    	        })
    	        .catch(error => {
    	            console.error("Error:", error);
    	            showToast("Bir hata meydana geldi!", "danger");
    	        });
    	    });

            document.getElementById("registerDate").value = getCurrentDate();

    	    function showToast(message, type) {
    	        const toastMessage = document.getElementById("toastMessage");
    	        const toast = new bootstrap.Toast(document.getElementById("toast"));

    	        toastMessage.innerText = message;
    	        document.getElementById("toast").classList.remove("bg-success", "bg-danger");
    	        document.getElementById("toast").classList.add(`bg-${type}`);

    	        toast.show();
    	    }

            function getCurrentDate() {
                const now = new Date();
                const year = now.getFullYear();
                const month = (now.getMonth() + 1).toString().padStart(2, '0');
                const day = now.getDate().toString().padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

    	</script>
		    <div id="toast" class="toast position-fixed top-0 end-0 p-3" style="z-index: 1050; min-width: 350px;">
    		    <div class="toast-body">
    		        <strong id="toastMessage" class="me-auto"></strong>
    		        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    		    </div>
    		</div>

        <script data-cfasync="false" src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=email-decode.min.js"></script>
        <script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=vendor.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
        <script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=app.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
        <script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=rocket-loader.min.js" data-cf-settings="1b49a6b08b02b05104d24adc-|49" defer></script>
        
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    </div>
</body>
</html>
