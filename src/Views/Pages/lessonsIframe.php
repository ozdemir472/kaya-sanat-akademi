<?php
    $today = new DateTime();
    $startOfWeek = clone $today;
    $startOfWeek->modify('Monday this week');
    
    $previousWeek = clone $startOfWeek;
    $previousWeek->modify('-1 week');
    
    $nextWeek = clone $startOfWeek;
    $nextWeek->modify('+1 week');
    
    $currentWeekStart = $startOfWeek->format('Y-m-d');
    $previousWeekStart = $previousWeek->format('Y-m-d');
    $nextWeekStart = $nextWeek->format('Y-m-d');
    
    $apiUrl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/listLessons?start_date=$currentWeekStart";
    
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
        <title>Dersler Iframe | Kaya Sanat Akademi</title>
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
        <div class="row">
            <div class="col-xl-12 col-lg-6">
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
        </div>
        <script data-cfasync="false" src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=email-decode.min.js"></script>
        <script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=vendor.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
        <script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=app.min.js" type="1b49a6b08b02b05104d24adc-text/javascript"></script>
        <script src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=rocket-loader.min.js" data-cf-settings="1b49a6b08b02b05104d24adc-|49" defer></script>
    </body>
</html>