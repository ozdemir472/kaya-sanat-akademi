<?php
// Haftanın başlangıcı (Pazartesi)
$today = new DateTime();
$startOfWeek = clone $today;
$startOfWeek->modify('Monday this week');

// Önceki ve sonraki haftanın başlangıcı
$previousWeek = clone $startOfWeek;
$previousWeek->modify('-1 week');

$nextWeek = clone $startOfWeek;
$nextWeek->modify('+1 week');

// Haftaların başlangıç tarihlerini formatla
$currentWeekStart = $startOfWeek->format('Y-m-d');
$previousWeekStart = $previousWeek->format('Y-m-d');
$nextWeekStart = $nextWeek->format('Y-m-d');

// API'yi çağırmak için tarihleri URL'ye ekle
$apiUrl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/listLessons?start_date=$currentWeekStart";

// API'den veri al
function getLessons($apiUrl) {
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

$lessons = getLessons($apiUrl);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Dersler | Kaya Sanat Akademi</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/css/css.php?file=vendor.min.css" rel="stylesheet">
        <link href="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/css/css.php?file=app.min.css" rel="stylesheet">
        <style>
            .lesson-cell {
            transition: background-color 0.3s ease;
            }
            .lesson-cell.waiting-confirmation {
            background-color: #ffeb3b !important;
            position: relative;
            }
            .lesson-cell.waiting-confirmation .confirmation-bubble {
            position: absolute;
            top: -80px;
            left: 0;
            width: 100%;
            background-color: #f44336;
            color: white;
            padding: 8px;
            text-align: center;
            font-size: 12px;
            border-radius: 5px;
            opacity: 0;
            transform: translateY(-30px);
            animation: bubble-appear 0.3s forwards;
            }
            @keyframes bubble-appear {
            0% {
            opacity: 0;
            transform: translateY(-10px);
            }
            100% {
            opacity: 1;
            transform: translateY(0);
            }
            }
            .lesson-cell.waiting-confirmation .confirmation-bubble.fade-out {
            animation: bubble-fade-out 0.3s forwards;
            }
            @keyframes bubble-fade-out {
            0% {
            opacity: 1;
            transform: translateY(0);
            }
            100% {
            opacity: 0;
            transform: translateY(-10px);
            }
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
                        Ders Listesi Ekranı
                        <small class="d-block fs-12px mt-1">Ödemesi alınan dersler yeşil ödemesi alınmayan dersler kırmızı olarak gözükmektedir. Ödeme sonradan alındıysa dersin üstüne 2 kere basmanız yeterlidir.</small>
                        <small class="d-block fs-12px mt-1"><?= (new DateTime())->modify('Monday this week')->format('Y-m-d') ?> - <?= (new DateTime())->modify('Sunday this week')->format('Y-m-d') ?> Arasındaki dersleri görüntülüyorsunuz.</small>
                    </h3>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-6">
                    <button id="signLessonButton" class="btn btn-primary mb-3">Ders İmzala Modu</button>
                        <div class="card bg-size-cover mb-6 p-2">
                            <div class="card-body">
                                <div class="row">
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
                                                $api_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/listLessons";
                                                
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
                                                                        style='$bgColor; cursor: pointer;'>
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
                </div>
            </div>
        </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
            	const lessonCells = document.querySelectorAll('.lesson-cell');
            
            	lessonCells.forEach(cell => {
            		cell.removeEventListener('click', handleLessonClick);
            		cell.addEventListener('click', handleLessonClick);
            	});
            
            	document.addEventListener('click', handleOutsideClick);
            });
            
            async function handleLessonClick(event) {
            	event.stopPropagation();
            
            	const cell = event.currentTarget;
            	const lessonId = cell.getAttribute('data-id');
            	let paymentStatus = cell.getAttribute('data-payment-status');
            
            	if (!cell.classList.contains('waiting-confirmation')) {
            		cell.classList.add('waiting-confirmation');
            		cell.innerHTML += `<div class="confirmation-bubble">Ödeme durumunu değiştirmek istiyor musunuz?</div>`;
            		return;
            	}
            
            	try {
            		const bubble = cell.querySelector('.confirmation-bubble');
            		bubble.classList.add('fade-out');
            
            		await new Promise(resolve => setTimeout(resolve, 300));
            
            		const formData = new FormData();
                	formData.append('lessonId', lessonId);
            		
                	const response = await fetch('/api/changePaymentStatus', {
                	    method: 'POST',
                	    body: formData,
                	});
            
            		const result = await response.json();
            
            		if (result.success) {
            			paymentStatus = paymentStatus == 1 ? 0 : 1;
            			cell.setAttribute('data-payment-status', paymentStatus);
            
            			cell.style.backgroundColor = paymentStatus == 1 ? '#d4edda' : '#f8d7da';
            
            			cell.classList.remove('waiting-confirmation');
            			bubble.remove();
            		} else {
            			alert('Durum güncellenirken bir hata oluştu.');
            		}
            	} catch (error) {
            		alert('Sunucu ile iletişim sırasında bir hata oluştu.');
            	}
            }
            
            function handleOutsideClick(event) {
            	const lessonCells = document.querySelectorAll('.lesson-cell');
            	lessonCells.forEach(cell => {
            		const bubble = cell.querySelector('.confirmation-bubble');
            		if (bubble && !cell.contains(event.target)) {
            			cell.classList.remove('waiting-confirmation');
            			bubble.remove();
            		}
            	});
            }
            document.addEventListener('DOMContentLoaded', function () {
            let signMode = false;
                    
            const signButton = document.getElementById('signLessonButton');
            const lessonCells = document.querySelectorAll('.lesson-cell');
                    
            signButton.addEventListener('click', function () {
                signMode = !signMode;
                signButton.classList.toggle('btn-danger', signMode);
                signButton.textContent = signMode ? "İmzalama Modu Açık - Ders Seçin" : "Ders İmzala Modu";
            });
        
            lessonCells.forEach(cell => {
                cell.addEventListener('click', function () {
                    if (signMode) {
                        const identity = cell.getAttribute('data-identity');
                        const id = cell.getAttribute('data-id');
                        if (identity) {
                            window.location.href = `/signature?identity=${identity}&lessonId=${id}`;
                        }
                    }
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