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

$data = [
    'lessonName' => getSanitizedParam("lessonName"),
    'teacherName' => json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/getTeacherById?id=". getSanitizedParam("teacherName")), true)['data']['name'],
    'lessonDate' => getSanitizedParam("lessonDate"),
    'lessonTime' => getSanitizedParam("lessonTime"),
    'studentId' => json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/getStudentByIdentity?identity=". getSanitizedParam("identity")), true)['data']['id'],
    'identity' => getSanitizedParam("identity"),
];

$identity = getSanitizedParam('identity');
$student = fetchDataFromApi("getStudentByIdentity?identity=" . urlencode($identity));
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
        <div class="container" id="student-section">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-12">
                            <h4><i class="far fa-user fa-fw text-body text-opacity-50 me-1"></i> Dijital İmza </h4>
                            <p>Öğrenci Ekranındasınız.</p>
                            <div class="card">
                                <div class="card-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="student-section">
                                                <h1 class="text-center">Öğrenci İmza Alanı</h1>
                                                <form id="signatureForm">
                                                    <div class="mb-3">
                                                        <label for="studentName" class="form-label">Öğrenci Adı</label>
                                                        <input type="text" class="form-control" id="studentName" value="<?= $student['studentName'] ?>" disabled>
                                                    </div>
                                                    <div class="signature-wrapper">
                                                        <h3 class="text-center">İmza Alanı</h3>
                                                        <canvas id="signatureCanvas" class="signature-pad" width="700" height="250"></canvas>
                                                    </div>
                                                    <div class="text-center mt-3">
                                                        <button type="button" class="btn btn-secondary" id="clearSignature">İmza Temizle</button>
                                                    </div>
                                                    <div class="hidden-inputs">
                                                        <input type="hidden" name="identity" value="<?= $data['identity'] ?>">
                                                        <input type="hidden" name="lessonName" value="<?= $data['lessonName'] ?>">
                                                        <input type="hidden" name="lessonDate" value="<?= $data['lessonDate'] ?>">
                                                        <input type="hidden" name="teacherName" value="<?= $data['teacherName'] ?>">
                                                        <input type="hidden" name="lessonTime" value="<?= $data['lessonTime'] ?>">
                                                        <input type="hidden" name="studentId" value="<?= $data['studentId'] ?>">
                                                        <input type="hidden" name="signature" id="signatureInput">

                                                    </div>
                                                    <div class="text-center mt-4">
                                                        <button type="submit" class="btn btn-primary">İmza ile Katıldım</button>
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
        </div>
    </div>
    


        <script data-cfasync="false" src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=email-decode.min.js"></script>
        <script data-cfasync="false" src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=vendor.min.js" type="1b49a6b08b02b05104d24adc-text/javascript" defer></script>
        <script data-cfasync="false" src="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/js/js.php?file=app.min.js" type="1b49a6b08b02b05104d24adc-text/javascript" defer></script>
        
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js" defer></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" defer></script>
        <script>
    if (!window.signatureScriptLoaded) {
        window.signatureScriptLoaded = true;
        document.addEventListener("DOMContentLoaded", function() {
            console.log("✅ JavaScript yüklendi - Tek sefer çalışacak");

            const form = document.getElementById("signatureForm");
            if (!form) {
                console.error("❌ Form bulunamadı!");
                return;
            }

            const canvas = document.getElementById("signatureCanvas");
            if (!canvas) {
                console.error("❌ Canvas bulunamadı!");
                return;
            }

            const signaturePad = new SignaturePad(canvas);
            let isSubmitting = false; // Çift istek kontrolü

            form.addEventListener("submit", function(event) {
                event.preventDefault();

                if (isSubmitting) {
                    console.warn("⚠️ İstek zaten gönderiliyor, tekrar gönderilmeyecek.");
                    return;
                }

                if (signaturePad.isEmpty()) {
                    alert("⚠️ Lütfen imzanızı ekleyin.");
                    return;
                }

                isSubmitting = true;
                const submitButton = form.querySelector("button[type='submit']");
                submitButton.disabled = true;

                const formData = new FormData(form);
                formData.set("signature", signaturePad.toDataURL("image/png"));

                console.log("🚀 Tek istek gönderiliyor...");

                fetch("/api/signatureLesson", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("✅ Yanıt alındı:", data);
                    if (data.success) {
                        window.close();
                    } else {
                        alert("⚠️ Hata: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("⛔ İstek hatası:", error);
                    alert("Bir hata oluştu, lütfen tekrar deneyin.");
                })
                .finally(() => {
                    isSubmitting = false;
                    submitButton.disabled = false;
                });
            });

            const clearButton = document.getElementById("clearSignature");
            if (clearButton) {
                clearButton.addEventListener("click", function(event) {
                    event.preventDefault();
                    signaturePad.clear();
                });
            }
        });
    }
</script>

</body>
</html>