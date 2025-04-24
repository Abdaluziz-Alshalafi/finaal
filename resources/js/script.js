// استدعاء البيانات من ملف JSON
let projectsData = []
let filteredProjects = []

// استدعاء العناصر من DOM
const projectsContainer = document.getElementById("projects-container")
const featuredProjectsContainer = document.getElementById("featured-projects-container")
const searchInput = document.getElementById("search-input")
const majorFilter = document.getElementById("major-filter")
const yearFilter = document.getElementById("year-filter")
const searchBtn = document.getElementById("search-btn")
const projectModal = document.getElementById("project-modal")
const modalContent = document.getElementById("modal-content")
const closeModal = document.querySelector(".close-modal")
const themeToggleBtn = document.getElementById("theme-toggle-btn")

// تحميل البيانات
document.addEventListener("DOMContentLoaded", () => {
  // في الحالة الحقيقية، سنستخدم fetch لجلب البيانات من الخادم
  // لكن في هذا المثال، نفترض أن البيانات متاحة مباشرة من ملف data.json
  projectsData = window.projects || []
  filteredProjects = [...projectsData]

  // إعداد الوضع المظلم/الفاتح
  setupThemeToggle()

  // عرض المشاريع حسب الصفحة
  if (window.location.pathname.includes("projects.html")) {
    // صفحة المشاريع - عرض جميع المشاريع
    renderProjects(filteredProjects)
  } else if (
    window.location.pathname.includes("index.html") ||
    window.location.pathname === "/" ||
    window.location.pathname.endsWith("/")
  ) {
    // الصفحة الرئيسية - عرض المشاريع المميزة فقط
    renderFeaturedProjects()
  }

  // تحديث الإحصائيات في صفحة من نحن
  updateStats()

  // إضافة مستمعي الأحداث
  setupEventListeners()

  // إضافة تأثيرات التحريك للمشاريع
  animateProjectCards()
})

// إعداد تبديل الوضع المظلم/الفاتح
function setupThemeToggle() {
  if (!themeToggleBtn) return

  // التحقق من الوضع المحفوظ
  const savedTheme = localStorage.getItem("theme")
  if (savedTheme === "dark") {
    document.body.classList.add("dark-mode")
    themeToggleBtn.innerHTML = '<i class="fas fa-sun"></i>'
  }

  themeToggleBtn.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode")

    if (document.body.classList.contains("dark-mode")) {
      localStorage.setItem("theme", "dark")
      themeToggleBtn.innerHTML = '<i class="fas fa-sun"></i>'
    } else {
      localStorage.setItem("theme", "light")
      themeToggleBtn.innerHTML = '<i class="fas fa-moon"></i>'
    }
  })
}

// عرض المشاريع
function renderProjects(projects) {
  if (!projectsContainer) return

  projectsContainer.innerHTML = ""

  if (projects.length === 0) {
    projectsContainer.innerHTML = '<div class="no-results">لا توجد مشاريع مطابقة للبحث</div>'
    return
  }

  projects.forEach((project, index) => {
    const projectCard = document.createElement("div")
    projectCard.className = "project-card"
    projectCard.style.animationDelay = `${0.1 * index}s`

    // إضافة اسم الجامعة
    const universityName = getRandomUniversity() // في الحالة الحقيقية، سيكون هذا من البيانات

    projectCard.innerHTML = `
      <div class="university-badge">${universityName}</div>
      <img src="${project.image}" alt="${project.name}">
      <div class="project-content">
        <h3>${project.name}</h3>
        <p>${project.shortDescription}</p>
        <div>
          <span class="badge">${project.major}</span>
          <span class="badge">${project.graduationYear}</span>
        </div>
        <button class="btn btn-primary view-project" data-id="${project.id}">عرض التفاصيل</button>
      </div>
    `
    projectsContainer.appendChild(projectCard)
  })

  // إضافة مستمعي الأحداث لأزرار عرض التفاصيل
  document.querySelectorAll(".view-project").forEach((button) => {
    button.addEventListener("click", function () {
      const projectId = Number.parseInt(this.getAttribute("data-id"))
      openProjectModal(projectId)
    })
  })
}

// عرض المشاريع المميزة في الصفحة الرئيسية
function renderFeaturedProjects() {
  if (!featuredProjectsContainer) return

  featuredProjectsContainer.innerHTML = ""

  // الحصول على المشاريع المميزة فقط
  const featuredProjects = projectsData.filter((project) => project.featured)

  if (featuredProjects.length === 0) {
    featuredProjectsContainer.innerHTML = '<div class="no-results">لا توجد مشاريع مميزة حاليًا</div>'
    return
  }

  featuredProjects.forEach((project, index) => {
    const projectCard = document.createElement("div")
    projectCard.className = "project-card"
    projectCard.style.animationDelay = `${0.1 * index}s`

    // إضافة اسم الجامعة
    const universityName = getRandomUniversity() // في الحالة الحقيقية، سيكون هذا من البيانات

    projectCard.innerHTML = `
      <div class="university-badge">${universityName}</div>
      <img src="${project.image}" alt="${project.name}">
      <div class="project-content">
        <h3>${project.name}</h3>
        <p>${project.shortDescription}</p>
        <div>
          <span class="badge">${project.major}</span>
          <span class="badge">${project.graduationYear}</span>
        </div>
        <button class="btn btn-primary view-project" data-id="${project.id}">عرض التفاصيل</button>
      </div>
    `
    featuredProjectsContainer.appendChild(projectCard)
  })

  // إضافة مستمعي الأحداث لأزرار عرض التفاصيل
  document.querySelectorAll(".view-project").forEach((button) => {
    button.addEventListener("click", function () {
      const projectId = Number.parseInt(this.getAttribute("data-id"))
      openProjectModal(projectId)
    })
  })
}

// الحصول على اسم جامعة عشوائي
function getRandomUniversity() {
  const universities = [
    "جامعة الملك سعود",
    "جامعة القاهرة",
    "الجامعة الأردنية",
    "جامعة الإمارات",
    "جامعة الملك فهد للبترول والمعادن",
  ]
  return universities[Math.floor(Math.random() * universities.length)]
}

// إضافة تأثيرات التحريك للمشاريع
function animateProjectCards() {
  const projectCards = document.querySelectorAll(".project-card")

  if (projectCards.length === 0) return

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = "1"
          entry.target.style.transform = "translateY(0)"
        }
      })
    },
    { threshold: 0.1 },
  )

  projectCards.forEach((card) => {
    observer.observe(card)
  })
}

// تحديث الإحصائيات في صفحة من نحن
function updateStats() {
  const universitiesCount = document.getElementById("universities-count")
  const projectsCount = document.getElementById("projects-count")
  const majorsCount = document.getElementById("majors-count")
  const studentsCount = document.getElementById("students-count")

  if (!universitiesCount) return

  // الحصول على الإحصائيات من البيانات
  const stats = window.stats || { universities: 12, projects: 150, majors: 25, students: 450 }

  // تحريك العدادات
  animateCounter(universitiesCount, 0, stats.universities, 2000)
  animateCounter(projectsCount, 0, stats.projects, 2000)
  animateCounter(majorsCount, 0, stats.majors, 2000)
  animateCounter(studentsCount, 0, stats.students, 2000)
}

// تحريك العدادات
function animateCounter(element, start, end, duration) {
  if (!element) return

  let startTimestamp = null
  const step = (timestamp) => {
    if (!startTimestamp) startTimestamp = timestamp
    const progress = Math.min((timestamp - startTimestamp) / duration, 1)
    element.textContent = Math.floor(progress * (end - start) + start)
    if (progress < 1) {
      window.requestAnimationFrame(step)
    }
  }
  window.requestAnimationFrame(step)
}

// فتح نافذة تفاصيل المشروع
function openProjectModal(projectId) {
  const project = projectsData.find((p) => p.id === projectId)
  if (!project || !modalContent) return

  modalContent.innerHTML = `
    <div class="project-details">
      <h2>${project.name}</h2>
      <img src="${"فهوم-البوابة-الإلكترونية.jpg?height=500&width=600"}" alt="${project.name}">

      <div class="project-meta">
        <div class="meta-item">
          <i class="fas fa-graduation-cap"></i>
          <span>${project.major}</span>
        </div>
        <div class="meta-item">
          <i class="fas fa-calendar-alt"></i>
          <span>${project.graduationYear}</span>
        </div>
        <div class="meta-item">
          <i class="fas fa-university"></i>
          <span>${getRandomUniversity()}</span>
        </div>
      </div>

      <div class="project-info">
        <p>${project.fullDescription}</p>
      </div>

      <div class="team-members">
        <h3>فريق العمل</h3>
        <div class="members-list">
          ${project.teamMembers
            .map(
              (member) => `
              <div class="member-card">
                <img src="${"فهوم-البوابة-الإلكترونية.jpg?height=500&width=600"}" alt="${member.name}">
                <div>
                  <h4>${member.name}</h4>
                  <p>${member.role}</p>
                </div>
              </div>
              <div class="member-card">
                <img src="${"images (4).jpg?height=500&width=600"}" alt="${member.name}">
                <div>
                  <h4>${member.name}</h4>
                  <p>${member.role}</p>
                </div>
              </div>
            `,
            )
            .join("")}
        </div>
      </div>
    </div>
  `

  projectModal.style.display = "block"
  document.body.style.overflow = "hidden"
}

// إغلاق نافذة تفاصيل المشروع
function closeProjectModal() {
  projectModal.style.display = "none"
  document.body.style.overflow = "auto"
}

// البحث وتصفية المشاريع
function searchProjects() {
  const searchTerm = searchInput ? searchInput.value.trim().toLowerCase() : ""
  const selectedMajor = majorFilter ? majorFilter.value : ""
  const selectedYear = yearFilter ? yearFilter.value : ""

  filteredProjects = projectsData.filter((project) => {
    const matchesSearch =
      searchTerm === "" ||
      project.name.toLowerCase().includes(searchTerm) ||
      project.shortDescription.toLowerCase().includes(searchTerm)

    const matchesMajor = selectedMajor === "" || project.major === selectedMajor
    const matchesYear = selectedYear === "" || project.graduationYear.toString() === selectedYear

    return matchesSearch && matchesMajor && matchesYear
  })

  renderProjects(filteredProjects)
}

// إعداد مستمعي الأحداث
function setupEventListeners() {
  // مستمعي أحداث البحث والتصفية
  if (searchBtn) {
    searchBtn.addEventListener("click", searchProjects)
  }

  if (searchInput) {
    searchInput.addEventListener("keyup", (event) => {
      if (event.key === "Enter") {
        searchProjects()
      }
    })
  }

  if (majorFilter) {
    majorFilter.addEventListener("change", searchProjects)
  }

  if (yearFilter) {
    yearFilter.addEventListener("change", searchProjects)
  }

  // مستمع حدث إغلاق النافذة المنبثقة
  if (closeModal) {
    closeModal.addEventListener("click", closeProjectModal)
  }

  // إغلاق النافذة المنبثقة عند النقر خارجها
  window.addEventListener("click", (event) => {
    if (event.target === projectModal) {
      closeProjectModal()
    }
  })

  // مستمع حدث زر القائمة للشاشات الصغيرة
  const hamburger = document.querySelector(".hamburger")
  const navLinks = document.querySelector(".nav-links")

  if (hamburger && navLinks) {
    hamburger.addEventListener("click", () => {
      navLinks.classList.toggle("active")
      hamburger.classList.toggle("active")
    })
  }

  // مستمع حدث نموذج الاتصال
  const contactForm = document.getElementById("contact-form")
  const formMessage = document.getElementById("form-message")

  if (contactForm && formMessage) {
    contactForm.addEventListener("submit", (event) => {
      event.preventDefault()

      // محاكاة إرسال النموذج
      formMessage.textContent = "تم إرسال رسالتك بنجاح! سنتواصل معك قريبًا."
      formMessage.className = "form-message success"

      // إعادة تعيين النموذج
      contactForm.reset()
    })
  }

  // مستمع حدث التمرير لتأثيرات التحريك
  window.addEventListener("scroll", handleScroll)
}

// معالجة حدث التمرير
function handleScroll() {
  // تأثير الخلفية المتغيرة عند التمرير
  if (document.querySelector(".projects-page")) {
    const scrollPosition = window.scrollY
    const opacity = Math.min(0.8, 0.5 + scrollPosition / 1500)

    // تطبيق تأثير الشفافية المتغيرة عند التمرير
    if (document.body.classList.contains("dark-mode")) {
      document.querySelector(".projects-page").style.backgroundImage =
        `linear-gradient(rgba(15, 23, 42, ${opacity}), rgba(30, 41, 59, ${opacity})), url('/placeholder.svg?height=1080&width=1920')`
    } else {
      document.querySelector(".projects-page").style.backgroundImage =
        `linear-gradient(rgba(30, 41, 59, ${opacity}), rgba(15, 23, 42, ${opacity})), url('/placeholder.svg?height=1080&width=1920')`
    }
  }
}

// تعيين البيانات من ملف JSON
// في الحالة الحقيقية، سيتم استدعاء هذه البيانات من الخادم
window.projects = [

  {
    id: 1,
    name: "نظام إدارة المستشفيات الذكي",
    shortDescription: "نظام متكامل لإدارة المستشفيات باستخدام تقنيات الذكاء الاصطناعي",
    fullDescription:
      "نظام إدارة المستشفيات الذكي هو حل متكامل يهدف إلى تحسين كفاءة العمليات الإدارية والطبية في المستشفيات. يستخدم النظام تقنيات الذكاء الاصطناعي لتحليل البيانات الطبية وتقديم توصيات للأطباء، كما يوفر واجهة سهلة الاستخدام لإدارة مواعيد المرضى وملفاتهم الطبية وإدارة المخزون الطبي. يساعد النظام على تقليل الأخطاء الطبية وتحسين جودة الرعاية الصحية المقدمة للمرضى.",
    image: 'فهوم-البوابة-الإلكترونية.jpg?height=500&width=600',
    major: "علوم الحاسوب",
    graduationYear: 2025,
    featured: true,
    teamMembers: [
      {
        name: "أحمد محمد",
        role: "مطور برمجيات",
        image: "مفهوم-البوابة-الإلكترونية.jpg?height=100&width=100",
      },
      {
        name: "سارة أحمد",
        role: "مهندسة ذكاء اصطناعي",
        image: "مفهوم-البوابة-الإلكترونية.jpg?height=100&width=100",
      },
      {
        name: "خالد عبدالله",
        role: "مصمم واجهات",
        image: "مفهوم-البوابة-الإلكترونية.jpg?height=100&width=100",
      },
    ],
  },
  {
    id: 2,
    name: "تطبيق التعلم الذكي",
    shortDescription: "منصة تعليمية تفاعلية تستخدم الذكاء الاصطناعي لتخصيص تجربة التعلم",
    fullDescription:
      "تطبيق التعلم الذكي هو منصة تعليمية مبتكرة تهدف إلى تحسين تجربة التعلم من خلال استخدام تقنيات الذكاء الاصطناعي. يقوم التطبيق بتحليل أداء المتعلم وتفضيلاته وأسلوب تعلمه، ثم يقدم محتوى تعليمي مخصص يناسب احتياجاته. يوفر التطبيق مجموعة متنوعة من الدورات التعليمية في مختلف المجالات، مع تمارين تفاعلية واختبارات لقياس مستوى التقدم. كما يتضمن ميزات للتعلم التعاوني والتواصل مع المعلمين والطلاب الآخرين.",
    image: "فهوم-البوابة-الإلكترونية.jpg?height=500&width=600",
    major: "هندسة البرمجيات",
    graduationYear: 2024,
    featured: true,
    teamMembers: [
      {
        name: "محمد علي",
        role: "مطور تطبيقات",
        image: "images (4).jpg?height=500&width=600",
      },
      {
        name: "نورة سعد",
        role: "مصممة تجربة المستخدم",
        image: "مفهوم-البوابة-الإلكترونية.jpg?height=100&width=100",
      },
    ],
  },
  {
    id: 3,
    name: "نظام مراقبة استهلاك الطاقة",
    shortDescription: "نظام ذكي لمراقبة وترشيد استهلاك الطاقة في المباني السكنية والتجارية",
    fullDescription:
      "نظام مراقبة استهلاك الطاقة هو حل متكامل يهدف إلى ترشيد استهلاك الطاقة في المباني السكنية والتجارية. يستخدم النظام أجهزة استشعار متصلة بالإنترنت لقياس استهلاك الكهرباء والماء والغاز في الوقت الفعلي، ويقدم تحليلات مفصلة عن أنماط الاستهلاك. كما يوفر توصيات لتقليل الاستهلاك وتوفير التكاليف، ويمكن التحكم في الأجهزة المنزلية عن بعد لتحسين كفاءة استخدام الطاقة.",
    image: "مفهوم-البوابة-الإلكترونية.jpg?height=300&width=500",
    major: "هندسة كهربائية",
    graduationYear: 2024,
    featured: false,
    teamMembers: [
      {
        name: "عبدالله محمد",
        role: "مهندس كهربائي",
        image: "/placeholder.svg?height=100&width=100",
      },
      {
        name: "فاطمة علي",
        role: "مطورة برمجيات",
        image: "فهوم-البوابة-الإلكترونية.jpg?height=100&width=100",
      },
      {
        name: "سعد خالد",
        role: "مهندس إلكترونيات",
        image: "فهوم-البوابة-الإلكترونية.jpg?height=100&width=100",
      },
    ],
  },
  {
    id: 4,
    name: "روبوت المساعدة المنزلية",
    shortDescription: "روبوت ذكي لمساعدة كبار السن وذوي الاحتياجات الخاصة في المنزل",
    fullDescription:
      "روبوت المساعدة المنزلية هو روبوت متطور مصمم لمساعدة كبار السن وذوي الاحتياجات الخاصة في المنزل. يمكن للروبوت أداء مجموعة متنوعة من المهام المنزلية مثل تنظيف المنزل وتحضير الطعام وتذكير المستخدمين بمواعيد الأدوية. كما يمكنه التواصل مع المستخدمين من خلال واجهة صوتية سهلة الاستخدام، والاتصال بالطوارئ في حالات الضرورة. يستخدم الروبوت تقنيات الذكاء الاصطناعي للتعلم من عادات المستخدم وتفضيلاته وتكييف سلوكه وفقًا لذلك.",
    image: "فهوم-البوابة-الإلكترونية.jpg?height=300&width=500",
    major: "الذكاء الاصطناعي",
    graduationYear: 2025,
    featured: false,
    teamMembers: [
      {
        name: "ليلى أحمد",
        role: "مهندسة روبوتات",
        image: "فهوم-البوابة-الإلكترونية.jpg?height=100&width=100",
      },
      {
        name: "عمر سعيد",
        role: "مطور ذكاء اصطناعي",
        image: "فهوم-البوابة-الإلكترونية.jpg?height=100&width=100",
      },
    ],
  },
  {
    id: 5,
    name: "منصة التجارة الإلكترونية المحلية",
    shortDescription: "منصة لربط المنتجين المحليين بالمستهلكين وتعزيز الاقتصاد المحلي",
    fullDescription:
      "منصة التجارة الإلكترونية المحلية هي سوق إلكتروني يهدف إلى ربط المنتجين المحليين والحرفيين بالمستهلكين. توفر المنصة واجهة سهلة الاستخدام للبائعين لعرض منتجاتهم وإدارة مبيعاتهم، وتجربة تسوق سلسة للمشترين. تتميز المنصة بنظام دفع آمن وخيارات توصيل متعددة، بالإضافة إلى نظام تقييم ومراجعة للمنتجات والبائعين. تهدف المنصة إلى تعزيز الاقتصاد المحلي ودعم الصناعات الصغيرة والمتوسطة.",
    image: "فهوم-البوابة-الإلكترونية.jpg?height=300&width=500",
    major: "نظم المعلومات",
    graduationYear: 2024,
    featured: false,
    teamMembers: [
      {
        name: "سلمى محمد",
        role: "محللة أعمال",
        image: "فهوم-البوابة-الإلكترونية.jpg?height=100&width=100",
      },
      {
        name: "يوسف أحمد",
        role: "مطور ويب",
        image: "فهوم-البوابة-الإلكترونية.jpg?height=100&width=100",
      },
      {
        name: "رنا خالد",
        role: "مصممة واجهات",
        image: "hero-bg.jpg?height=500&width=600",
      },
    ],
  },
  {
    id: 6,
    name: "تطبيق الواقع المعزز للسياحة",
    shortDescription: "تطبيق يستخدم تقنية الواقع المعزز لتعزيز تجربة السياحة وزيارة المعالم التاريخية",
    fullDescription:
      "تطبيق الواقع المعزز للسياحة هو تطبيق مبتكر يهدف إلى تعزيز تجربة السياحة من خلال استخدام تقنية الواقع المعزز. يمكن للمستخدمين توجيه كاميرا هواتفهم نحو المعالم السياحية والتاريخية للحصول على معلومات تفاعلية ونماذج ثلاثية الأبعاد وإعادة بناء افتراضية للمواقع التاريخية. يوفر التطبيق أيضًا جولات إرشادية افتراضية ومسارات سياحية مخصصة بناءً على اهتمامات المستخدم والوقت المتاح. يدعم التطبيق العديد من اللغات ويعمل دون اتصال بالإنترنت بعد تحميل البيانات.",
    image: "hero-bg.jpg?height=500&width=600",
    major: "علوم الحاسوب",
    graduationYear: 2025,
    featured: false,
    teamMembers: [
      {
        name: "طارق سعيد",
        role: "مطور تطبيقات موبايل",
        image:"hero-bg.jpg?height=500&width=600",
      },
      {
        name: "منى عبدالله",
        role: "مصممة ثلاثية الأبعاد",
        image:"images (4).jpg?height=500&width=600",
      },
    ],
  },
  {
    id: 1,
    name: "نظام إدارة المستشفيات الذكي",
    shortDescription: "نظام متكامل لإدارة المستشفيات باستخدام تقنيات الذكاء الاصطناعي",
    fullDescription:
      "نظام إدارة المستشفيات الذكي هو حل متكامل يهدف إلى تحسين كفاءة العمليات الإدارية والطبية في المستشفيات. يستخدم النظام تقنيات الذكاء الاصطناعي لتحليل البيانات الطبية وتقديم توصيات للأطباء، كما يوفر واجهة سهلة الاستخدام لإدارة مواعيد المرضى وملفاتهم الطبية وإدارة المخزون الطبي. يساعد النظام على تقليل الأخطاء الطبية وتحسين جودة الرعاية الصحية المقدمة للمرضى.",
    image: 'hero-bg.jpg?height=500&width=600',
    major: "علوم الحاسوب",
    graduationYear: 2025,
    featured: true,
    teamMembers: [
      {
        name: "أحمد محمد",
        role: "مطور برمجيات",
        image: "hero-bg.jpg?height=100&width=100",
      },
      {
        name: "سارة أحمد",
        role: "مهندسة ذكاء اصطناعي",
        image: "hero-bg.jpg?height=100&width=100",
      },
      {
        name: "خالد عبدالله",
        role: "مصمم واجهات",
        image: "فهوم-البوابة-الإلكترونية.jpg?height=100&width=100",
      },
    ],
  },
  {
    id: 2,
    name: "تطبيق التعلم الذكي",
    shortDescription: "منصة تعليمية تفاعلية تستخدم الذكاء الاصطناعي لتخصيص تجربة التعلم",
    fullDescription:
      "تطبيق التعلم الذكي هو منصة تعليمية مبتكرة تهدف إلى تحسين تجربة التعلم من خلال استخدام تقنيات الذكاء الاصطناعي. يقوم التطبيق بتحليل أداء المتعلم وتفضيلاته وأسلوب تعلمه، ثم يقدم محتوى تعليمي مخصص يناسب احتياجاته. يوفر التطبيق مجموعة متنوعة من الدورات التعليمية في مختلف المجالات، مع تمارين تفاعلية واختبارات لقياس مستوى التقدم. كما يتضمن ميزات للتعلم التعاوني والتواصل مع المعلمين والطلاب الآخرين.",
    image: "فهوم-البوابة-الإلكترونية.jpg?height=500&width=600",
    major: "هندسة البرمجيات",
    graduationYear: 2024,
    featured: true,
    teamMembers: [
      {
        name: "محمد علي",
        role: "مطور تطبيقات",
        image: "فهوم-البوابة-الإلكترونية.jpg?height=500&width=600",
      },
      {
        name: "نورة سعد",
        role: "مصممة تجربة المستخدم",
        image: "فهوم-البوابة-الإلكترونية.jpg?height=100&width=100",
      },
    ],
  },
  {
    id: 3,
    name: "نظام مراقبة استهلاك الطاقة",
    shortDescription: "نظام ذكي لمراقبة وترشيد استهلاك الطاقة في المباني السكنية والتجارية",
    fullDescription:
      "نظام مراقبة استهلاك الطاقة هو حل متكامل يهدف إلى ترشيد استهلاك الطاقة في المباني السكنية والتجارية. يستخدم النظام أجهزة استشعار متصلة بالإنترنت لقياس استهلاك الكهرباء والماء والغاز في الوقت الفعلي، ويقدم تحليلات مفصلة عن أنماط الاستهلاك. كما يوفر توصيات لتقليل الاستهلاك وتوفير التكاليف، ويمكن التحكم في الأجهزة المنزلية عن بعد لتحسين كفاءة استخدام الطاقة.",
    image: "/placeholder.svg?height=300&width=500",
    major: "هندسة كهربائية",
    graduationYear: 2024,
    featured: false,
    teamMembers: [
      {
        name: "عبدالله محمد",
        role: "مهندس كهربائي",
        image: "/placeholder.svg?height=100&width=100",
      },
      {
        name: "فاطمة علي",
        role: "مطورة برمجيات",
        image: "/placeholder.svg?height=100&width=100",
      },
      {
        name: "سعد خالد",
        role: "مهندس إلكترونيات",
        image: "فهوم-البوابة-الإلكترونية.jpg?height=100&width=100",
      },
    ],
  },
  {
    id: 4,
    name: "روبوت المساعدة المنزلية",
    shortDescription: "روبوت ذكي لمساعدة كبار السن وذوي الاحتياجات الخاصة في المنزل",
    fullDescription:
      "روبوت المساعدة المنزلية هو روبوت متطور مصمم لمساعدة كبار السن وذوي الاحتياجات الخاصة في المنزل. يمكن للروبوت أداء مجموعة متنوعة من المهام المنزلية مثل تنظيف المنزل وتحضير الطعام وتذكير المستخدمين بمواعيد الأدوية. كما يمكنه التواصل مع المستخدمين من خلال واجهة صوتية سهلة الاستخدام، والاتصال بالطوارئ في حالات الضرورة. يستخدم الروبوت تقنيات الذكاء الاصطناعي للتعلم من عادات المستخدم وتفضيلاته وتكييف سلوكه وفقًا لذلك.",
    image: "فهوم-البوابة-الإلكترونية.jpg?height=300&width=500",
    major: "الذكاء الاصطناعي",
    graduationYear: 2025,
    featured: false,
    teamMembers: [
      {
        name: "ليلى أحمد",
        role: "مهندسة روبوتات",
        image: "/placeholder.svg?height=100&width=100",
      },
      {
        name: "عمر سعيد",
        role: "مطور ذكاء اصطناعي",
        image: "فهوم-البوابة-الإلكترونية.jpg?height=100&width=100",
      },
    ],
  },
  {
    id: 5,
    name: "منصة التجارة الإلكترونية المحلية",
    shortDescription: "منصة لربط المنتجين المحليين بالمستهلكين وتعزيز الاقتصاد المحلي",
    fullDescription:
      "منصة التجارة الإلكترونية المحلية هي سوق إلكتروني يهدف إلى ربط المنتجين المحليين والحرفيين بالمستهلكين. توفر المنصة واجهة سهلة الاستخدام للبائعين لعرض منتجاتهم وإدارة مبيعاتهم، وتجربة تسوق سلسة للمشترين. تتميز المنصة بنظام دفع آمن وخيارات توصيل متعددة، بالإضافة إلى نظام تقييم ومراجعة للمنتجات والبائعين. تهدف المنصة إلى تعزيز الاقتصاد المحلي ودعم الصناعات الصغيرة والمتوسطة.",
    image: "/placeholder.svg?height=300&width=500",
    major: "نظم المعلومات",
    graduationYear: 2024,
    featured: false,
    teamMembers: [
      {
        name: "سلمى محمد",
        role: "محللة أعمال",
        image: "/placeholder.svg?height=100&width=100",
      },
      {
        name: "يوسف أحمد",
        role: "مطور ويب",
        image: "/placeholder.svg?height=100&width=100",
      },
      {
        name: "رنا خالد",
        role: "مصممة واجهات",
        image: "hero-bg.jpg?height=500&width=600",
      },
    ],
  },
  {
    id: 6,
    name: "تطبيق الواقع المعزز للسياحة",
    shortDescription: "تطبيق يستخدم تقنية الواقع المعزز لتعزيز تجربة السياحة وزيارة المعالم التاريخية",
    fullDescription:
      "تطبيق الواقع المعزز للسياحة هو تطبيق مبتكر يهدف إلى تعزيز تجربة السياحة من خلال استخدام تقنية الواقع المعزز. يمكن للمستخدمين توجيه كاميرا هواتفهم نحو المعالم السياحية والتاريخية للحصول على معلومات تفاعلية ونماذج ثلاثية الأبعاد وإعادة بناء افتراضية للمواقع التاريخية. يوفر التطبيق أيضًا جولات إرشادية افتراضية ومسارات سياحية مخصصة بناءً على اهتمامات المستخدم والوقت المتاح. يدعم التطبيق العديد من اللغات ويعمل دون اتصال بالإنترنت بعد تحميل البيانات.",
    image: "hero-bg.jpg?height=500&width=600",
    major: "علوم الحاسوب",
    graduationYear: 2025,
    featured: false,
    teamMembers: [
      {
        name: "طارق سعيد",
        role: "مطور تطبيقات موبايل",
        image:"فهوم-البوابة-الإلكترونية.jpg?height=500&width=600",
      },
      {
        name: "منى عبدالله",
        role: "مصممة ثلاثية الأبعاد",
        image:"فهوم-البوابة-الإلكترونية.jpg?height=500&width=600",
      },
    ],
  },
]

window.stats = {
  universities: 12,
  projects: 150,
  majors: 25,
  students: 450,
}

