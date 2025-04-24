

  // عرض نافذة تنبيه
  function showAlertModal(title, message) {
    // إنشاء عنصر النافذة المنبثقة
    const alertDiv = document.createElement("div");
    alertDiv.className = "alert-modal";
    alertDiv.innerHTML = `
      <div class="alert-modal-content">
        <div class="alert-icon">
          <i class="fas fa-exclamation-circle"></i>
        </div>
        <h3>${title}</h3>
        <p>${message}</p>
        <button class="btn btn-primary close-alert-btn">موافق</button>
      </div>
    `;

    document.body.appendChild(alertDiv);

    // إضافة مستمع حدث لزر الإغلاق
    const closeBtn = alertDiv.querySelector(".close-alert-btn");
    closeBtn.addEventListener("click", () => {
      document.body.removeChild(alertDiv);
    });
  }


 // تحميل الصفحة
  document.addEventListener("DOMContentLoaded", () => {
    // التحقق من تسجيل دخول المستخدم
    const currentUser = JSON.parse(localStorage.getItem("currentUser") || "null");

         // التحقق من تسجيل دخول المستخدم
        if (!window.currentUser) {
            showAlertModal("تنبيه", "يجب تسجيل الدخول للوصول إلى هذه الصفحة");
            setTimeout(() => {
                window.location.href = window.routes.login;
                // window.location.href = "/";
            }, 2000);
            return;
        }

        if (window.userType !== "students") {
            showAlertModal("تنبيه", "هناك خطاء في بياناتك يرجاء مراجعت الاداره");
            fetch(window.routes.logout, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                }
            })
            .then(() => {
                setTimeout(() => {
                    window.location.href = window.routes.login;
                }, 2000);
            });

            return;
        }

        // عرض ترحيب
        console.log("مرحبًا، " + window.currentUser.name);



  });
