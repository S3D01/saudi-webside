function toggleNightMode() {
  document.body.classList.toggle("night-mode");

  const btn = document.getElementById("modeBtn");

  if (document.body.classList.contains("night-mode")) {
    btn.textContent = "☀️";
    localStorage.setItem("nightMode", "on");
  } else {
    btn.textContent = "🌙 ";
    localStorage.setItem("nightMode", "off");
  }
}
