// بيانات افتراضية للطلاب والمشرفين
const mockDatabase = window.mockData || {
    // بيانات الطلاب
    students: [
      { id: "123456", name: "أحمد محمد", university: "1", college: "كلية الحاسب", major: "علوم الحاسوب" },
      { id: "234567", name: "سارة أحمد", university: "1", college: "كلية الحاسب", major: "هندسة البرمجيات" },
      { id: "345678", name: "خالد عبدالله", university: "1", college: "كلية الحاسب", major: "نظم المعلومات" },
      { id: "456789", name: "فاطمة علي", university: "1", college: "كلية الحاسب", major: "الذكاء الاصطناعي" },
      { id: "567890", name: "محمد علي", university: "1", college: "كلية الحاسب", major: "هندسة البرمجيات" },
      { id: "678901", name: "نورة سعد", university: "1", college: "كلية الحاسب", major: "علوم الحاسوب" },
      { id: "789012", name: "عبدالله محمد", university: "2", college: "كلية الهندسة", major: "هندسة كهربائية" },
      { id: "890123", name: "ليلى أحمد", university: "2", college: "كلية الحاسب", major: "الذكاء الاصطناعي" },
      { id: "901234", name: "عمر سعيد", university: "2", college: "كلية الحاسب", major: "علوم الحاسوب" },
      { id: "012345", name: "سلمى محمد", university: "3", college: "كلية الحاسب", major: "نظم المعلومات" },
    ],

    // بيانات المشرفين
    supervisors: [
      { id: "1001", name: "د. محمد الأحمد", university: "1", college: "كلية الحاسب", department: "علوم الحاسوب" },
      { id: "1002", name: "د. سارة العلي", university: "1", college: "كلية الحاسب", department: "هندسة البرمجيات" },
      { id: "1003", name: "د. خالد المحمد", university: "1", college: "كلية الحاسب", department: "نظم المعلومات" },
      { id: "1004", name: "د. فاطمة السعيد", university: "2", college: "كلية الحاسب", department: "الذكاء الاصطناعي" },
      { id: "1005", name: "د. أحمد العبدالله", university: "2", college: "كلية الهندسة", department: "هندسة كهربائية" },
      { id: "1006", name: "د. نورة الخالد", university: "3", college: "كلية الحاسب", department: "علوم الحاسوب" },
    ],

    // بيانات الجامعات
    universities: [
      { id: "1", name: "جامعة الملك سعود" },
      { id: "2", name: "جامعة القاهرة" },
      { id: "3", name: "الجامعة الأردنية" },
      { id: "4", name: "جامعة الإمارات" },
    ],
  };

  // متغيرات عامة
  let currentStep = 1;
  let projectCount = 1;
  let researcherCount = 0;
  let currentUniversity = "";
  let currentStudentId = "";
  let currentStudentData = null;
  let selectedSupervisors = [];
  const projectData = {
    projects: [],
    researchers: [],
    supervisors: [],
    supervisionType: "essential",
  };


  // إظهار معلومات المستخدم
  function showUserInfo(user) {
    const authButtons = document.querySelector(".auth-buttons");
    const userMenu = document.querySelector(".user-menu");
    const userName = document.querySelector(".user-name");

    if (authButtons && userMenu && userName) {
      authButtons.style.display = "none";
      userMenu.style.display = "flex";
      userName.textContent = `مرحباً، ${user.name}`;

      // إضافة مستمع حدث لزر تسجيل الخروج
      const logoutBtn = document.querySelector(".logout-btn");
      if (logoutBtn) {
        logoutBtn.addEventListener("click", () => {
          localStorage.removeItem("currentUser");
          window.location.href = "index.html";
        });
      }
    }
  }

  // إعداد مستمعي الأحداث
  function setupEventListeners() {
    // أزرار إضافة المشروع والباحثين
    const addProjectBtn = document.getElementById("add-project-btn");
    if (addProjectBtn) {
      addProjectBtn.addEventListener("click", addProject);
    }

    const addResearcherBtn = document.getElementById("add-researcher-btn");
    if (addResearcherBtn) {
      addResearcherBtn.addEventListener("click", addResearcher);
    }

    // أزرار التنقل بين الخطوات
    const nextToStep2Btn = document.getElementById("next-to-step-2");
    if (nextToStep2Btn) {
      nextToStep2Btn.addEventListener("click", validateStep1AndProceed);
    }

    const backToStep1Btn = document.getElementById("back-to-step-1");
    if (backToStep1Btn) {
      backToStep1Btn.addEventListener("click", () => goToStep(1));
    }

    const nextToStep3Btn = document.getElementById("next-to-step-3");
    if (nextToStep3Btn) {
      nextToStep3Btn.addEventListener("click", validateStep2AndProceed);
    }

    const backToStep2Btn = document.getElementById("back-to-step-2");
    if (backToStep2Btn) {
      backToStep2Btn.addEventListener("click", () => goToStep(2));
    }

    // أزرار الملخص والإرسال
    const showSummaryBtn = document.getElementById("show-summary-btn");
    if (showSummaryBtn) {
      showSummaryBtn.addEventListener("click", validateStep3AndShowSummary);
    }

    const submitProjectBtn = document.getElementById("submit-project-btn");
    if (submitProjectBtn) {
      submitProjectBtn.addEventListener("click", validateStep3AndShowSummary);
    }

    const closeModal = document.querySelector(".close-modal");
    if (closeModal) {
      closeModal.addEventListener("click", closeModals);
    }

    const editProjectBtn = document.getElementById("edit-project-btn");
    if (editProjectBtn) {
      editProjectBtn.addEventListener("click", closeModals);
    }

    const confirmSubmitBtn = document.getElementById("confirm-submit-btn");
    if (confirmSubmitBtn) {
      confirmSubmitBtn.addEventListener("click", submitProject);
    }

    const goToHomeBtn = document.getElementById("go-to-home-btn");
    if (goToHomeBtn) {
      goToHomeBtn.addEventListener("click", () => (window.location.href = "index.html"));
    }

    // إغلاق النوافذ المنبثقة عند النقر خارجها
    const summaryModal = document.getElementById("summary-modal");
    if (summaryModal) {
      window.addEventListener("click", (event) => {
        if (event.target === summaryModal) {
          closeModals();
        }
      });
    }

    // مستمع أحداث لأزرار الراديو لنوع الإشراف
    const supervisionTypeRadios = document.querySelectorAll('input[name="supervision-type"]');
    supervisionTypeRadios.forEach(radio => {
      radio.addEventListener('change', function() {
        projectData.supervisionType = this.value;
      });
    });
  }


  // تحديث مؤشر الخطوات
  function updateStepsIndicator() {
    const steps = document.querySelectorAll(".step");

    steps.forEach(step => {
      const stepNumber = parseInt(step.dataset.step);

      // إزالة جميع الصفوف
      step.classList.remove("active", "completed");

      if (stepNumber === currentStep) {
        step.classList.add("active");
      } else if (stepNumber < currentStep) {
        step.classList.add("completed");
      }
    });
  }

  // إغلاق النوافذ المنبثقة
  function closeModals() {
    const summaryModal = document.getElementById("summary-modal");
    const successModal = document.getElementById("success-modal");

    if (summaryModal) summaryModal.style.display = "none";
    if (successModal) successModal.style.display = "none";

    // إزالة جميع نوافذ التنبيه الموجودة
    const alertModals = document.querySelectorAll(".alert-modal");
    alertModals.forEach(modal => {
      document.body.removeChild(modal);
    });
  }

  // عرض رسالة
  function showMessage(element, message, type) {
    if (!element) return;

    element.textContent = message;
    element.className = `form-message ${type}`;
    element.style.display = "block";

    // إخفاء الرسالة بعد 5 ثوانٍ
    setTimeout(() => {
      element.style.display = "none";
    }, 5000);
  }

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

  // إعداد مبدل السمة
  function setupThemeToggle() {
    const themeToggleBtn = document.getElementById("theme-toggle-btn");
    const body = document.body;

    // تحقق من تفضيل السمة المحفوظ
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme === "dark") {
      body.classList.add("dark-mode");
      updateThemeIcon(true);
    }

    if (themeToggleBtn) {
      themeToggleBtn.addEventListener("click", function() {
        body.classList.toggle("dark-mode");

        const isDarkMode = body.classList.contains("dark-mode");
        updateThemeIcon(isDarkMode);

        // حفظ تفضيل السمة
        localStorage.setItem("theme", isDarkMode ? "dark" : "light");
      });
    }
  }

  // تحديث أيقونة السمة
  function updateThemeIcon(isDarkMode) {
    const themeIcon = document.querySelector("#theme-toggle-btn i");
    if (themeIcon) {
      if (isDarkMode) {
        themeIcon.className = "fas fa-sun";
      } else {
        themeIcon.className = "fas fa-moon";
      }
    }
  }
