<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://localhost/assets/css/css.php?file=login.css">
    <style>
        .logo img {
            width: 225px;
            height: 225px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <!-- Logo -->

    <!-- Login Form -->
    <div class="login-container">
        <div class="logo" style="text-align: center;">
            <img src="/assets/images/logo.jpg" alt="Logo" class="logo">
        </div>
        <h2>Giriş Yap</h2>
        <form id="loginForm">
            <div class="input-group">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" placeholder="Kullanıcı adınızı girin" required>
            </div>
            <div class="input-group">
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" placeholder="Şifrenizi girin" required>
            </div>
            <button type="submit" class="btn-login">Giriş Yap</button>
        </form>
    </div>

    <!-- Bootstrap Toast for Alerts -->
    <div id="toast" class="toast position-fixed top-0 end-0 p-3" style="z-index: 1050; min-width: 350px;">
        <div class="toast-body">
            <strong id="toastMessage" class="me-auto"></strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
        // Login form submit handler
        document.getElementById("loginForm").addEventListener("submit", function (e) {
            e.preventDefault(); // Sayfanın yenilenmesini engeller

            // Formu al
            const form = document.getElementById("loginForm");

            // Form verilerini FormData ile al
            const formData = new FormData(form);

            // API'ye AJAX ile veri gönderme
            fetch("http://localhost/api/login", {
                method: "POST", // POST isteği
                body: formData // Form verisini form-data olarak gönderiyoruz
            })
            .then(response => response.json())
            .then(data => {
                // Başarı durumunda toast mesajı göster
                if (data.status == true) {
                    showToast("Başarıyla giriş yapıldı!", "success");
                    // Yönlendirme işlemi
                    window.location.href = "/dashboard"; // Yönlendirme yapılır
                } else {
                    showToast("Hatalı kullanıcı adı veya şifre!", "danger");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                showToast("Bir hata oluştu!", "danger");
            });
        });

        // Toast mesajı göstermek için fonksiyon
        function showToast(message, type) {
            const toastMessage = document.getElementById("toastMessage");
            const toast = new bootstrap.Toast(document.getElementById("toast"));

            // Mesajı ve stilini ayarlıyoruz
            toastMessage.innerText = message;
            document.getElementById("toast").classList.remove("bg-success", "bg-danger");
            document.getElementById("toast").classList.add(`bg-${type}`);

            // Toast'u göster
            toast.show();
        }
    </script>
</body>
</html>
