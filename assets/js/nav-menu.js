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

function countCart() {
  let Server = new server();
  Server.get("action=cart")
    .then((res, req) => {
      $("#countCart").text(res.length);
    })
    .catch((xhr, sta, err) => {
      $("#countCart").text(0);
    });
}
function typeSearch() {
  let url = window.location.href;
  if (url.search("action=") != -1) {
    let modelSearchOptions = document.querySelectorAll("#select-search > option");

    modelSearchOptions.forEach(item => {
      console.log(item);
      if (item.value == url.split("?action=")[1].split("&")[0]) {

        item.setAttribute("selected", "");
      }

    })
  }
}
$(document).ready(() => {
  countCart();

});
