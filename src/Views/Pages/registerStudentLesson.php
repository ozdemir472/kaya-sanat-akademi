<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Öğrenci Ders Kayıt | Kaya Sanat Akademi</title>
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
                                        <h4><i class="far fa-user fa-fw text-body text-opacity-50 me-1"></i> Öğrenci Ders Kayıt</h4>
                                        <p>Öğrencinizin ders kaydını yapabilirsiniz.</p>
                                        <div class="card">
                                            <div class="card-body">
                                                <form id="studentForm" method="POST" action="/api/regis" enctype="multipart/form-data">
                                                    <div class="mb-3">
                                                        <label for="studentName" class="form-label">Öğrenci</label>
                                                        <select class="form-select" name="student" id="student">
                                                            <option value="" disabled selected>Öğrenci seçiniz</option>
                                                            <?php foreach (json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] ."://". $_SERVER['HTTP_HOST'] . "/api/listStudents"), true)['data'] as $student) :?>
                                                            <option value="<?php echo $student['id'];?>"> <?php echo $student['studentName'];?> </option>
                                                            <?php endforeach;?> 
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="registerDate" class="form-label">Ders Seçimi</label>
                                                        <select class="form-select" name="lesson" id="lesson">
                                                            <option value="" disabled selected>Ders seçiniz</option>
                                                            <?php foreach (json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] ."://". $_SERVER['HTTP_HOST'] . "/api/getLessons"), true)['data'] as $lesson) :?> 
                                                            <option value="<?php echo $lesson['id'];?>"> <?php echo $lesson['LessonName'];?> </option>
                                                            <?php endforeach;?> 
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="day" class="form-label">Gün Seçimi</label>
                                                        <select class="form-select" name="day" id="day">
                                                            <option value="" disabled selected>Gün seçiniz</option>
                                                            <?php 
                                                                $days = json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST']. "/api/getSystemOption?option=workingDays"),true)['data']['option']['array'];
                                                                foreach ($days as $key => $day) :
                                                                $key++;
                                                                ?> 
                                                            <option value="<?= $key; ?>"><?= $day; ?></option>
                                                            <?php endforeach; ?> 
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="hour" class="form-label">Saat Seçimi</label>
                                                        <select class="form-select" name="hour" id="hour">
                                                            <option value="" disabled selected>Saat seçiniz</option>
                                                            <?php 
                                                                $hours = json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST']. "/api/getSystemOption?option=workingHours"),true)['data']['option']['array'];

                                                                foreach ($hours as $key => $hour) :
                                                                ?> 
                                                            <option value="<?= $hour; ?>"><?= $hour; ?></option>
                                                            <?php endforeach; ?> 
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="timePeriod" class="form-label">Eğitim Süresi</label>
                                                        <select class="form-select" name="timePeriod" id="timePeriod">
                                                            <option value="" disabled selected>Süre seçiniz</option>
                                                            <option value="1">1 Ders (1 Hafta)</option>
                                                            <option value="2">4 Ders (1 Ay)</option>
                                                            <option value="3">8 Ders (2 Ay)</option>
                                                            <option value="4">12 Ders (3 Ay)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="paymentReceived">Ödeme peşin mi?</label>
                                                        <input type="checkbox" name="paymentReceived" id="paymentReceived" class="form-checkbox">
                                                    </div>
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#modalLg">Haftalık Ders Programını Görüntüle</button>
                                                        <button type="submit" id="" class="btn btn-green">Kaydet</button>
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
            <div class="modal fade" id="modalLg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title fs-5">Haftalık Ders Programı</div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <iframe src="/lessonsIframe" frameborder="0" style="width: 100%; height: 400px; overflow-x: hidden; overflow-y: hidden;"></iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="toast" class="toast position-fixed top-0 end-0 p-3" style="z-index: 1050; min-width: 350px;">
                <div class="toast-body">
                    <strong id="toastMessage" class="me-auto"></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <div id="errorModal" class="modal fade" tabindex="-1" aria-labelledby="errorModallLabel" aria-hidden="true" style="display: none; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(5px);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="text-align: center;">
                        <div class="modal-header" style="text-align: center;">
                            <h5 class="modal-title" id="errorModallLabel">Bilgilendirme</h5>
                        </div>
                        <div class="modal-body">
                            <div id="modalErrorBox"></div><br><br>
                            <a href="/registerStudent" id="errorModalButton" class="btn btn-theme"><= Öğrenci Kaydı Yap</a>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                if (window.lessonCheckInitialized) return;
                window.lessonCheckInitialized = true;
                
                fetch("/api/listStudents", {
    	            method: "GET"
    	        })
    	        .then(response => response.json())
    	        .then(data => {
    	            if (data.success == false) {
                        var modal = document.getElementById("errorModal");
                        var modalButton = document.getElementById("errorModalButton");
                        document.getElementById("modalErrorBox").innerText = "Öğrenci kaydı yapmadan öğrenci ders kaydı yapamazsınız.";
                        modalButton.innerText = "<= Öğrenci Oluştur";
                        modalButton.href = "/registerStudent";
                        modal.classList.add("show");
                        modal.style.display = "block";
    	            }
    	        })
    	        .catch(error => {
    	            console.error("Error:", error);
    	        });

                fetch("/api/getLessons", {
    	            method: "GET"
    	        })
    	        .then(response => response.json())
    	        .then(data => {
    	            if (data.success == false) {
                        var modal = document.getElementById("errorModal");
                        var modalButton = document.getElementById("errorModalButton");
                        document.getElementById("modalErrorBox").innerText = "Ders oluşturmadan öğrenci ders kaydı yapamazsınız.";
                        modalButton.innerText = "<= Ders Oluştur";
                        modalButton.href = "/createLesson";
                        modal.classList.add("show");
                        modal.style.display = "block";
    	            }
    	        })
    	        .catch(error => {
    	            console.error("Error:", error);
    	        });
                
                let allLessons = [];
                
                fetch("/api/listLessons")
                .then(response => response.json())
                .then(data => {
                if (data.success) {
                    allLessons = data.data;
                } else {
                    console.error("Ders listesi alınamadı!");
                }
                })
                .catch(error => console.error("API Hatası:", error));
                
                document.getElementById("day").addEventListener("change", checkAvailability);
                document.getElementById("hour").addEventListener("change", checkAvailability);
                
                function checkAvailability() {
                const selectedDay = document.getElementById("day").value;
                const selectedHour = document.getElementById("hour").value;
                const saveButton = document.querySelector("#studentForm button[type='submit']");
                
                if (!selectedDay || !selectedHour) return;
                
                const conflict = allLessons.some(lesson =>
                lesson.dayName === getDayName(selectedDay) && lesson.time_slot === selectedHour
                );
                
                if (conflict) {
                alert("Bu saatte başka bir ders var! Lütfen farklı bir saat seçin.");
                saveButton.disabled = true;
                } else {
                saveButton.disabled = false;
                }
                }
                
                function getDayName(dayNumber) {
                const days = {
                1: "Pazartesi",
                2: "Salı",
                3: "Çarşamba",
                4: "Perşembe",
                5: "Cuma",
                6: "Cumartesi"
                };
                return days[dayNumber] || "";
                }
                });

                const form = document.getElementById("studentForm");

                form.addEventListener("submit", function(event) {
                    event.preventDefault();
                
                    const formData = new FormData(form);
                
                    fetch('/api/registerLesson', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Kayıt başarılı!");
                        } else {
                            alert("Bir hata oluştu: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert("Bir hata oluştu.");
                    });
                });
                
            </script>
            <script data-cfasync="false" src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=email-decode.min.js"></script>
            <script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=vendor.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
            <script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=app.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
            <script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=rocket-loader.min.js" data-cf-settings="1b49a6b08b02b05104d24adc-|49" defer></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        </div>
    </body>
</html>