// change the color of the navbar when the user scrolls the page
let navMenu = document.getElementById("nav-menu");

window.onscroll = function () {
  if (window.pageYOffset > 0) {
    navMenu.classList.add("navbar-white");
    navMenu.classList.add("bg-white");
    navMenu.classList.add("shadow");
    navMenu.classList.remove("navbar-dark");
  } else {
    navMenu.classList.remove("navbar-white");
    navMenu.classList.remove("bg-white");
    navMenu.classList.remove("shadow");
    navMenu.classList.add("navbar-dark");
  }
};
// nav-menu active class
window.addEventListener("DOMContentLoaded", function () {
  let urlAction = window.location.href;
  urlAction =
    urlAction.indexOf("action=") != -1
      ? urlAction.split("action=")[1].split("&")[0]
      : "home";

  let navLinks = document.querySelectorAll("#mynavbar > ul > li > a");
  navLinks.forEach(function (navLink) {
    let textContent = navLink.textContent.toLocaleLowerCase();
    textContent = textContent.trim();
    if (textContent == urlAction) {
      navLink.classList.add("active");
    }
  });
});


