<?php
$identity = htmlspecialchars($_GET['identity']);
$student = json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/getStudentByIdentity?identity=" . $identity), true)['data'];
$teachers = json_decode(file_get_contents($_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/api/listTeachers"), true)['data'];

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Müzik Kursu - Dijital İmza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] ?>/assets/css/css.php?file=signature.css">
    <style>
        .split-screen {
            display: flex;
            height: 100vh;
        }
        .teacher-section, .student-section {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
        .teacher-section {
            border-right: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="split-screen">
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
                        <input type="text" name="teacherName" class="form-control" id="teacherSelectionInput" aria-label="Öğretmen seçimi" readonly>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#teacherSelectionModal">Seç</button>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="lessonTime" class="form-label">Ders Saati</label>
                    <input type="text" name="lessonTime" class="form-control" id="lessonTime">
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Tarih</label>
                    <input type="date" name="date" class="form-control" id="date">
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Bilgileri Kaydet</button>
                </div>
            </form>
        </div>

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

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">İmza ile Katıldım</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="teacherSelectionModal" tabindex="-1" aria-labelledby="teacherSelectionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teacherSelectionModalLabel">Öğretmen Seçimi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <?php foreach ($teachers as $teacher): ?>
                        <li class="list-group-item selectable-teacher" data-teacher="<?= $teacher['name'] ?>"><?= $teacher['name'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <script>
        const canvas = document.getElementById('signatureCanvas');
        const signaturePad = new SignaturePad(canvas);

        document.getElementById('clearSignature').addEventListener('click', function() {
            signaturePad.clear();
        });

        document.querySelectorAll('.selectable-teacher').forEach(item => {
            item.addEventListener('click', function() {
                const selectedTeacher = this.getAttribute('data-teacher');
                document.getElementById('teacherSelectionInput').value = selectedTeacher;

                const modal = bootstrap.Modal.getInstance(document.getElementById('teacherSelectionModal'));
                modal.hide();
            });
        });

        document.getElementById('lessonTime').value = getCurrentHourRange();
        document.getElementById('date').value = getCurrentDate();

        function getCurrentHourRange() {
            const now = new Date();
            const hour = now.getHours();
            const startHour = hour.toString().padStart(2, '0');
            const endHour = (hour + 1).toString().padStart(2, '0');
            return `${startHour}:00 - ${endHour}:00`;
        }

        function getCurrentDate() {
            const now = new Date();
            const year = now.getFullYear();
            const month = (now.getMonth() + 1).toString().padStart(2, '0');
            const day = now.getDate().toString().padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
    </script>
</body>
</html>
