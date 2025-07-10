document.addEventListener("DOMContentLoaded", function () {
  const navLinks = document.querySelectorAll(".nav-link");
  const subPages = document.querySelectorAll(".admin-sub-page");
  const hamburgerAdmin = document.getElementById("hamburgerAdmin");
  const adminNav = document.getElementById("adminNav");
  const logoutBtn = document.getElementById("logoutBtn");

  function showPage(pageId) {
    subPages.forEach((page) => {
      page.classList.remove("active");
    });
    document.getElementById(pageId).classList.add("active");

    navLinks.forEach((link) => {
      link.classList.remove("active");
    });
    document
      .querySelector(`.nav-link[data-page="${pageId.replace("Page", "")}"]`)
      .classList.add("active");
  }

  navLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      if (this.dataset.page) {
        showPage(this.dataset.page + "Page");
      }
      if (window.innerWidth <= 768 && adminNav.classList.contains("active")) {
        adminNav.classList.remove("active");
      }
    });
  });

  document
    .querySelectorAll(".quick-link-button[data-page-target]")
    .forEach((button) => {
      button.addEventListener("click", function (e) {
        e.preventDefault();
        const targetPage = this.dataset.pageTarget;
        if (targetPage) {
          showPage(targetPage + "Page");
        }
      });
    });

  hamburgerAdmin.addEventListener("click", function () {
    adminNav.classList.toggle("active");
  });

  function handleLogout(e) {
    e.preventDefault();

    alert("Anda telah berhasil logout!");

    localStorage.removeItem("userToken");
    localStorage.removeItem("userName");

    window.location.href = "/SukaInfo_app/login";
  }

  if (logoutBtn) {
    logoutBtn.addEventListener("click", handleLogout);
  }

  showPage("dashboardPage");
});
