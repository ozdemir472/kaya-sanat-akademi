<?php

function getSanitizedParam($paramName) {
    return filter_input(INPUT_GET, $paramName, FILTER_SANITIZE_STRING) ?? '';
}

function fetchDataFromApi($endpoint) {
    $apiUrl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/" . $endpoint;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ($httpCode == 200) ? json_decode($response, true)['data'] ?? [] : [];
}

$id = getSanitizedParam('lessonId');
$identity = getSanitizedParam('identity');
$student = fetchDataFromApi("getStudentByIdentity?identity=" . urlencode($identity));
$teachers = fetchDataFromApi("listTeachers");
$lessonDetails = fetchDataFromApi("getWeeklyTimetableById?id=".  urlencode($id));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Öğrenci İmza | Kaya Sanat Akademi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/css/css.php?file=vendor.min.css" rel="stylesheet">
    <link href="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/css/css.php?file=app.min.css" rel="stylesheet">
    <style>
        .signature-wrapper {
            text-align: center;
            margin-top: 20px;
        }
        .signature-pad {
            border: 2px dashed #ccc;
            border-radius: 10px;
            background: #fff;
            transition: all 0.3s ease-in-out;
        }
        .signature-pad:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        #clearSignature {
            transition: background 0.3s, transform 0.2s;
        }
        #clearSignature:hover {
            background: #ff4d4d;
            transform: scale(1.05);
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

        <?php include("./src/Views/Includes/sidebar.php");  ?>

        <button class="app-sidebar-mobile-backdrop" data-toggle-target=".app" data-toggle-class="app-sidebar-mobile-toggled"></button>
        <div id="content" class="app-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <div class="row">
                            <div class="col-xl-12">
                                <h4><i class="far fa-user fa-fw text-body text-opacity-50 me-1"></i> Dijital İmza </h4>
                                <p>Öğretmen Ekranındasınız.</p>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="teacher-section">
                                            <h1 class="text-center">Öğretmen Paneli</h1>
                                            <form id="teacherForm">
                                                <div class="mb-3">
                                                    <label for="courseName" class="form-label">Ders Adı</label>
                                                    <input type="text" class="form-control" id="courseName" value="<?= $student['department'] ?>" disabled>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="teacherSelection" class="form-label">Öğretmen Seçimi</label>
                                                    <div class="input-group">
                                                        <select class="form-select" name="teacherName" id="teacherName">
                                                            <?php foreach($teachers as $teacher): ?>
                                                            <option value="<?= $teacher['id'] ?>"><?= $teacher['name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="lessonTime" class="form-label">Ders Saati</label>
                                                    <input type="text" name="lessonTime" class="form-control" id="lessonTime" value="<?= $lessonDetails['time_slot'] ?>">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="date" class="form-label">Tarih</label>
                                                    <input type="text" name="date" class="form-control" id="date" value="<?= $lessonDetails['week_number'] ?>">
                                                </div>

                                                <div class="text-center mt-4">
                                                    <a id="showStudentButton"  href="#" onclick="showStudentSection()" class="btn btn-info">Öğrenci Ekranını Göster</a>
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
        <div id="errorModal" class="modal fade" tabindex="-1" aria-labelledby="errorModallLabel" aria-hidden="true" style="display: none; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(5px);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="text-align: center;">
                    <div class="modal-header" style="text-align: center;">
                        <h5 class="modal-title" id="errorModallLabel">Bilgilendirme</h5>
                    </div>
                    <div class="modal-body">
                        <strong>Öğretmen oluşturmadan ders imzalayamazsınız.</strong><br><br>
                        <p><a href="/registerTeacher" class="btn btn-theme"><= Öğretmen Oluştur</a></p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function (){
                fetch("/api/listTeachers", {
    	            method: "GET"
    	        })
    	        .then(response => response.json())
    	        .then(data => {
    	            if (data.success == false) {
                        var modal = document.getElementById("errorModal");
                        modal.classList.add("show");
                        modal.style.display = "block";
    	            }
    	        })
    	        .catch(error => {
    	            console.error("Error:", error);
    	            showToast("Bir hata meydana geldi!", "danger");
    	        });

            });
            function getURL(){
                const identity = "<?= $student['identity'] ?>";
                const lessonName = document.getElementById("courseName").value;
                const teacherName = document.getElementById("teacherName").value;
                const lessonTime = document.getElementById("lessonTime").value;
                const lessonDate = document.getElementById("date").value;
                const url = `signatureStudent?identity=${identity}&lessonName=${lessonName}&lessonDate=${lessonDate}&teacherName=${teacherName}&lessonTime=${lessonTime}`;
                return url;
            }
            function showStudentSection(){
                window.open(getURL(), '_blank', 'width=' + screen.width + ',height=' + screen.height + ',top=0,left=0,resizable=no,scrollbars=no,status=no'); return false;
            }
            
        </script>
        <script data-cfasync="false" src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=email-decode.min.js"></script>
        <script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=vendor.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
        <script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=app.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
        <script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=rocket-loader.min.js" data-cf-settings="1b49a6b08b02b05104d24adc-|49" defer></script>
        
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>


        
</body>
</html>