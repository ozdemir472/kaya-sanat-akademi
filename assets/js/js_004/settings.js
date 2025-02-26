fetch("/api/getSystemOption?option=workingHours", {
    "headers": {
      "accept": "application/json",
      "content-type": "application/json",
      "cache-control": "max-age=0",
      "sec-fetch-mode": "cors",
      "sec-fetch-site": "same-origin"
    },
    "method": "GET",
    "mode": "cors",
    "credentials": "include"
  })
  .then(response => response.json())
  .then(data => {
    if (data.success && data.data.option && data.data.option.array) {
      const workingHours = data.data.option.array;
      const hourGroup = document.getElementById("hour-group");
      
      const allHours = [];
      for (let h = 0; h < 24; h++) {
        let start = (h === 0 ? "00" : String(h).padStart(2, '0')) + ":00";
        let end = (h === 23 ? "00" : String(h + 1).padStart(2, '0')) + ":00";
        allHours.push(start + " - " + end);
      }
  
      allHours.forEach(hour => {
        const checked = workingHours.includes(hour) ? 'checked' : '';
        const checkboxHTML = `
          <label class="list-group-item">
            <input type="checkbox" class="form-check-input" name="work_hours" value="${hour}" ${checked}> ${hour}
          </label>
        `;
        
        hourGroup.insertAdjacentHTML('beforeend', checkboxHTML);
      });
    }
  })
  .catch(error => {
    console.error("API çağrısı sırasında bir hata oluştu:", error);
  });
  
  document.getElementById("save-hours").addEventListener("click", function() {
    const selectedHours = [];
    
    // Seçili olan saatleri al
    document.querySelectorAll("input[name='work_hours']:checked").forEach(checkbox => {
      selectedHours.push(checkbox.value);
    });
  
    // API'ye gönderilecek veriyi oluştur
    const payload = {
      array: selectedHours
    };
  
    // Form-data formatında option içinde JSON gönder
    const formData = new FormData();
    formData.append("option", JSON.stringify(payload));
  
    // API'ye veriyi gönder
    fetch("/api/saveWorkingHours", {
      method: "POST",
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Çalışma saatleriniz başarıyla kaydedildi!");
      } else {
        alert("Bir hata oluştu, tekrar deneyin.");
      }
    })
    .catch(error => {
      console.error("API çağrısı sırasında bir hata oluştu:", error);
      alert("Bir hata oluştu.");
    });
  });
  fetch("/api/getSystemOption?option=workingDays", {
    "headers": {
      "accept": "application/json",
      "content-type": "application/json",
      "cache-control": "max-age=0",
      "sec-fetch-mode": "cors",
      "sec-fetch-site": "same-origin"
    },
    "method": "GET",
    "mode": "cors",
    "credentials": "include"
  })
  .then(response => response.json())
  .then(data => {
    if (data.success && data.data.option && data.data.option.array) {
      const workingDays = data.data.option.array; // API'den gelen çalışma günleri
      const dayGroup = document.getElementById("day-group"); // Container elemanı
  
      // Günler dizisi
      const allDays = ["Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi", "Pazar"];
  
      // Günleri checkbox olarak ekle
      allDays.forEach(day => {
        const checked = workingDays.includes(day) ? 'checked' : ''; // API'den gelenler checked olacak
        const checkboxHTML = `
          <label class="list-group-item">
            <input type="checkbox" class="form-check-input" name="work_days" value="${day}" ${checked}> ${day}
          </label>
        `;
  
        dayGroup.insertAdjacentHTML('beforeend', checkboxHTML);
      });
    }
  })
  .catch(error => {
    console.error("API çağrısı sırasında bir hata oluştu:", error);
  });
  
  // 'save-days' butonuna tıklanınca seçilen günleri API'ye gönder
  document.getElementById("save-days").addEventListener("click", function() {
    const selectedDays = [];
  
    // Seçili olan günleri al
    document.querySelectorAll("input[name='work_days']:checked").forEach(checkbox => {
      selectedDays.push(checkbox.value);
    });
  
    // API'ye gönderilecek veriyi oluştur
    const payload = {
      array: selectedDays
    };
  
    // Form-data formatında option içinde JSON gönder
    const formData = new FormData();
    formData.append("option", JSON.stringify(payload));
  
    // API'ye veriyi gönder
    fetch("/api/saveWorkingDays", {
      method: "POST",
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Çalışma günleriniz başarıyla kaydedildi!");
      } else {
        alert("Bir hata oluştu, tekrar deneyin.");
      }
    })
    .catch(error => {
      console.error("API çağrısı sırasında bir hata oluştu:", error);
      alert("Bir hata oluştu.");
    });
  });
  document.getElementById("save-user").addEventListener("click", function() {
      // Inputlardan verileri al
      const username = document.getElementById("username").value.trim();
      const longname = document.getElementById("longname").value.trim();
      const password = document.getElementById("password").value.trim();
      const email = document.getElementById("email").value.trim();
  
      // Boş alan kontrolü
      if (!username || !password || !email) {
          alert("Lütfen tüm alanları doldurun!");
          return;
      }
  
      // FormData nesnesini oluştur
      const formData = new FormData();
      formData.append("username", username);
      formData.append("password", password);
      formData.append("longname", longname);
      formData.append("email", email);
  
      // API isteği gönder
      fetch("/api/createUser", {
          method: "POST",
          body: formData
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              alert("Kullanıcı başarıyla oluşturuldu!");
              // Modalı kapat
              let modalElement = document.getElementById("createUser");
              let modal = bootstrap.Modal.getInstance(modalElement);
              modal.hide();
          } else {
              alert("Bir hata oluştu: " + (data.message || "Bilinmeyen hata"));
          }
      })
      .catch(error => {
          console.error("API çağrısı sırasında bir hata oluştu:", error);
          alert("Bir hata oluştu.");
      });
  });
  document.getElementById("remove-user").addEventListener("click", function() {
    // Seçilen kullanıcıyı al
    const userId = document.getElementById("remove-user-select").value;
  
    // Eğer kullanıcı seçilmemişse, uyarı göster
    if (!userId) {
      alert("Lütfen silinecek kullanıcıyı seçin.");
      return;
    }
  
    // Form verisi oluşturuluyor
    const formData = new FormData();
    formData.append("user_id", userId);  // Seçilen kullanıcı ID'sini ekliyoruz
  
    // Kullanıcıyı silme işlemi için API'ye veriyi gönderiyoruz
    fetch("/api/removeUser?id=" + userId, {
      method: "GET",
      credentials: "include"  // Eğer session'ı kullanıyorsanız, bu satırı bırakabilirsiniz
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Kullanıcı başarıyla silindi!");
        // Modalı kapat
        $('#removeUser').modal('hide');
      } else {
        alert("Bir hata oluştu, lütfen tekrar deneyin.");
      }
    })
    .catch(error => {
      console.error("API çağrısı sırasında bir hata oluştu:", error);
      alert("Bir hata oluştu.");
    });
  });
  
  