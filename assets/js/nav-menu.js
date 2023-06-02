$(document).ready(() => {
  countCart();

});
// change the color of the navbar when the user scrolls the page

/* This code is changing the color and style of the navbar when the user scrolls the page. It first
gets the element with the ID "nav-menu" and then adds or removes certain classes based on the user's
scroll position. If the user has scrolled down the page, it adds the classes "navbar-white",
"bg-white", and "shadow" to the navbar and removes the class "navbar-dark". If the user has scrolled
back to the top of the page, it removes those classes and adds the class "navbar-dark" back to the
navbar. */
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
/* This code is adding an "active" class to the navigation link that matches the current URL action. It
does this by first getting the current URL using `window.location.href`, and then checking if it
contains the string "action=". If it does, it extracts the value of the action parameter using
`split()` and sets it to the `urlAction` variable. If it doesn't, it sets `urlAction` to "home". */
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

/**
 * The function counts the number of items in the user's cart using a server request and updates the
 * count displayed on the webpage.
 */
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
/**
 * The function selects an option in a dropdown menu based on the value in the URL.
 */
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

