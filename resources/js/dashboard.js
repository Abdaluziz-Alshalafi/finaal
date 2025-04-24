document.addEventListener("DOMContentLoaded", () => {
  // Sidebar Toggle
  const menuToggle = document.getElementById("menuToggle")
  const closeSidebarBtn = document.getElementById("closeSidebar")
  const sidebar = document.querySelector(".sidebar")

  if (menuToggle) {
    menuToggle.addEventListener("click", () => {
      sidebar.classList.add("active")
    })
  }

  if (closeSidebarBtn) {
    closeSidebarBtn.addEventListener("click", () => {
      sidebar.classList.remove("active")
    })
  }

  // Theme Toggle
  const themeToggles = document.querySelectorAll(".theme-toggle")
  const body = document.body

  themeToggles.forEach((themeToggle) => {
    if (themeToggle) {
      themeToggle.addEventListener("click", () => {
        body.classList.toggle("dark-theme")

        // Update all theme toggle icons
        themeToggles.forEach((toggle) => {
          const icon = toggle.querySelector("i")
          if (body.classList.contains("dark-theme")) {
            icon.classList.remove("fa-moon")
            icon.classList.add("fa-sun")
          } else {
            icon.classList.remove("fa-sun")
            icon.classList.add("fa-moon")
          }
        })

        // Save theme preference
        const theme = body.classList.contains("dark-theme") ? "dark" : "light"
        localStorage.setItem("theme", theme)
      })
    }
  })

  // Check for saved theme preference
  const savedTheme = localStorage.getItem("theme")
  if (savedTheme === "dark") {
    body.classList.add("dark-theme")
    themeToggles.forEach((toggle) => {
      const icon = toggle.querySelector("i")
      if (icon) {
        icon.classList.remove("fa-moon")
        icon.classList.add("fa-sun")
      }
    })
  }







const dialogOverlays = document.querySelectorAll(".dialog-overlay")
const closeDialogBtns = document.querySelectorAll(".close-dialog")
const cancelBtns = document.querySelectorAll(".dialog-footer .secondary-btn")

function showDialog(dialogId) {
  const dialog = document.getElementById(dialogId)
  if (dialog) {
    dialog.classList.add("active")
  }
}

function hideDialog(dialog) {
  if (dialog) {
    dialog.classList.remove("active")
  }
}

const logoutBtn = document.querySelector(".logout-btn")
if (logoutBtn) {
  logoutBtn.addEventListener("click", () => showDialog("logoutDialog"))
}

  // Example trigger for dialog


  closeDialogBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      const dialog = btn.closest(".dialog-overlay")
      hideDialog(dialog)
    })
  })

  cancelBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      const dialog = btn.closest(".dialog-overlay")
      hideDialog(dialog)
    })
  })

  // Close dialog when clicking outside
  dialogOverlays.forEach((overlay) => {
    overlay.addEventListener("click", (e) => {
      if (e.target === overlay) {
        hideDialog(overlay)
      }
    })
  })

  // Animation for content
  const animateElements = document.querySelectorAll(".stats-container, .activity-section")
  animateElements.forEach((element) => {
    element.classList.add("fade-in")
  })

  // Tab functionality
  const tabItems = document.querySelectorAll(".tab-item")
  const tabContents = document.querySelectorAll(".tab-content")

  tabItems.forEach((tab) => {
    tab.addEventListener("click", () => {
      const target = tab.getAttribute("data-tab")

      // Update active tab
      tabItems.forEach((item) => {
        item.classList.remove("active")
      })
      tab.classList.add("active")

      // Show target content
      tabContents.forEach((content) => {
        content.classList.remove("active")
        if (content.getAttribute("id") === target) {
          content.classList.add("active")
        }
      })
    })
  })

  // Create dynamic dialogs
  window.createDialog = (options) => {
    const { title, message, type, confirmText, cancelText, onConfirm, onCancel } = options

    // Create dialog elements
    const overlay = document.createElement("div")
    overlay.className = "dialog-overlay active"

    const dialog = document.createElement("div")
    dialog.className = `dialog ${type || ""}`

    const dialogHeader = document.createElement("div")
    dialogHeader.className = "dialog-header"

    const dialogTitle = document.createElement("h3")
    dialogTitle.textContent = title || "تنبيه"

    const closeButton = document.createElement("button")
    closeButton.className = "close-dialog"
    closeButton.innerHTML = '<i class="fas fa-times"></i>'

    const dialogContent = document.createElement("div")
    dialogContent.className = "dialog-content"
    dialogContent.textContent = message || ""

    const dialogFooter = document.createElement("div")
    dialogFooter.className = "dialog-footer"

    // Add cancel button if needed
    if (cancelText !== false) {
      const cancelButton = document.createElement("button")
      cancelButton.className = "secondary-btn"
      cancelButton.textContent = cancelText || "إلغاء"
      cancelButton.addEventListener("click", () => {
        document.body.removeChild(overlay)
        if (typeof onCancel === "function") onCancel()
      })
      dialogFooter.appendChild(cancelButton)
    }

    // Add confirm button
    const confirmButton = document.createElement("button")
    confirmButton.className = "primary-btn"
    confirmButton.textContent = confirmText || "تأكيد"
    confirmButton.addEventListener("click", () => {
      document.body.removeChild(overlay)
      if (typeof onConfirm === "function") onConfirm()
    })
    dialogFooter.appendChild(confirmButton)

    // Assemble dialog
    dialogHeader.appendChild(dialogTitle)
    dialogHeader.appendChild(closeButton)

    dialog.appendChild(dialogHeader)
    dialog.appendChild(dialogContent)
    dialog.appendChild(dialogFooter)

    overlay.appendChild(dialog)

    // Add to body
    document.body.appendChild(overlay)

    // Close button functionality
    closeButton.addEventListener("click", () => {
      document.body.removeChild(overlay)
      if (typeof onCancel === "function") onCancel()
    })

    // Close when clicking outside
    overlay.addEventListener("click", (e) => {
      if (e.target === overlay) {
        document.body.removeChild(overlay)
        if (typeof onCancel === "function") onCancel()
      }
    })

    return {
      close: () => {
        if (document.body.contains(overlay)) {
          document.body.removeChild(overlay)
        }
      },
    }
  }

  // Example of success dialog
  window.showSuccessDialog = (message, onClose) =>
    window.createDialog({
      title: "تمت العملية بنجاح",
      message: message || "تم تنفيذ العملية بنجاح",
      type: "success",
      confirmText: "حسناً",
      cancelText: false,
      onConfirm: onClose,
    })

  // Example of error dialog
  window.showErrorDialog = (message, onClose) =>
    window.createDialog({
      title: "حدث خطأ",
      message: message || "حدث خطأ أثناء تنفيذ العملية",
      type: "error",
      confirmText: "حسناً",
      cancelText: false,
      onConfirm: onClose,
    })

  // Example of warning dialog
  window.showWarningDialog = (message, onConfirm, onCancel) =>
    window.createDialog({
      title: "تنبيه",
      message: message || "هل أنت متأكد من تنفيذ هذه العملية؟",
      type: "warning",
      onConfirm: onConfirm,
      onCancel: onCancel,
    })

  // Example of confirmation dialog
  window.showConfirmDialog = (message, onConfirm, onCancel) =>
    window.createDialog({
      title: "تأكيد العملية",
      message: message || "هل أنت متأكد من رغبتك في تنفيذ هذه العملية؟",
      onConfirm: onConfirm,
      onCancel: onCancel,
    })

  // Example of info dialog
  window.showInfoDialog = (message, onClose) =>
    window.createDialog({
      title: "معلومات",
      message: message || "",
      type: "info",
      confirmText: "حسناً",
      cancelText: false,
      onConfirm: onClose,
    })
})
