function getBasePath() {
  const path = window.location.pathname;
  if (path.includes("/admin/")) {
    return "../assets/";
  }
  return "assets/";
}

function updateModeIcon(iconName) {
  const oldIcon = document.getElementById("modeIcon");
  if (!oldIcon) return;

  // إنشاء أيقونة جديدة بنفس الـ id
  const newIcon = document.createElement("i");
  newIcon.setAttribute("data-lucide", iconName);
  newIcon.id = "modeIcon";

  oldIcon.replaceWith(newIcon);

  // إعادة تشغيل lucide عشان يرسم الأيقونة الجديدة
  if (typeof lucide !== "undefined") {
    lucide.createIcons();
  }
}

function toggleNightMode() {
  document.body.classList.toggle("night-mode");

  const logo = document.getElementById("siteLogo");
  const base = getBasePath();

  if (document.body.classList.contains("night-mode")) {
    updateModeIcon("sun");
    localStorage.setItem("nightMode", "on");
    if (logo) logo.src = base + "dark.png";
  } else {
    updateModeIcon("moon");
    localStorage.setItem("nightMode", "off");
    if (logo) logo.src = base + "light.png";
  }
}

window.onload = function () {
  const logo = document.getElementById("siteLogo");
  const base = getBasePath();

  if (localStorage.getItem("nightMode") === "on") {
    document.body.classList.add("night-mode");
    updateModeIcon("sun");
    if (logo) logo.src = base + "dark.png";
  }
};
function validateLogin(form) {
  const username = form.querySelector('input[name="username"]').value.trim();
  const password = form.querySelector('input[name="password"]').value.trim();

  if (!username || !password) {
    alert("يرجى تعبئة جميع الحقول");
    return false;
  }
  if (username.length < 3) {
    alert("اسم المستخدم يجب أن يكون 3 أحرف على الأقل");
    return false;
  }
  if (password.length < 4) {
    alert("كلمة المرور يجب أن تكون 4 أحرف على الأقل");
    return false;
  }
  return true;
}
function validateAdd(form) {
  const city = form.querySelector('input[name="city"]').value.trim();
  const description = form
    .querySelector('textarea[name="description"]')
    .value.trim();
  const features = form.querySelector('input[name="features"]').value.trim();
  const activities = form
    .querySelector('input[name="activities"]')
    .value.trim();
  const landmarks = form.querySelector('input[name="landmarks"]').value.trim();
  const mainImage = form.querySelector('input[name="main_image"]').files.length;
  const gallery1 = form.querySelector('input[name="gallery1"]').files.length;

  if (!city || !description || !features || !activities || !landmarks) {
    alert("يرجى تعبئة جميع الحقول المطلوبة *");
    return false;
  }
  if (city.length < 2) {
    alert("اسم المكان يجب أن يكون حرفين على الأقل");
    return false;
  }
  if (description.length < 10) {
    alert("الوصف يجب أن يكون 10 أحرف على الأقل");
    return false;
  }
  if (!mainImage) {
    alert("يرجى رفع الصورة الرئيسية");
    return false;
  }
  if (!gallery1) {
    alert("يرجى رفع صورة المعرض الأولى على الأقل");
    return false;
  }
  return true;
}function validateUpdate(form) {
    const city        = form.querySelector('input[name="city"]').value.trim();
    const description = form.querySelector('textarea[name="description"]').value.trim();
    const features    = form.querySelector('input[name="features"]').value.trim();
    const activities  = form.querySelector('input[name="activities"]').value.trim();
    const landmarks   = form.querySelector('input[name="landmarks"]').value.trim();

    if (!city || !description || !features || !activities || !landmarks) {
        alert('يرجى تعبئة جميع الحقول المطلوبة');
        return false;
    }
    if (city.length < 2) {
        alert('اسم المكان يجب أن يكون حرفين على الأقل');
        return false;
    }
    if (description.length < 10) {
        alert('الوصف يجب أن يكون 10 أحرف على الأقل');
        return false;
    }
    return true;
}
function validateUpdate(form) {
  const city = form.querySelector('input[name="city"]').value.trim();
  const description = form
    .querySelector('textarea[name="description"]')
    .value.trim();
  const features = form.querySelector('input[name="features"]').value.trim();
  const activities = form
    .querySelector('input[name="activities"]')
    .value.trim();
  const landmarks = form.querySelector('input[name="landmarks"]').value.trim();

  if (!city || !description || !features || !activities || !landmarks) {
    alert("يرجى تعبئة جميع الحقول المطلوبة");
    return false;
  }
  if (city.length < 2) {
    alert("اسم المكان يجب أن يكون حرفين على الأقل");
    return false;
  }
  if (description.length < 10) {
    alert("الوصف يجب أن يكون 10 أحرف على الأقل");
    return false;
  }
  return true;
}
document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  if (!form) return;

  const path = window.location.pathname;

  if (path.includes("login.php")) {
    form.addEventListener("submit", function (e) {
      if (!validateLogin(form)) e.preventDefault();
    });
  } else if (path.includes("add.php")) {
    form.addEventListener("submit", function (e) {
      if (!validateAdd(form)) e.preventDefault();
    });
  } else if (path.includes("update.php")) {
    form.addEventListener("submit", function (e) {
      if (!validateUpdate(form)) e.preventDefault();
    });
  }
});
function confirmDelete() {
  return confirm("هل أنت متأكد أنك تريد حذف هذا المكان؟");
}