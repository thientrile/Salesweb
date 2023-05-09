function checkCookie(name) {
  const cookies = document.cookie.split(";");

  for (let i = 0; i < cookies.length; i++) {
    const cookie = cookies[i].trim();

    if (cookie.startsWith(name + "=")) {
      return true;
    }
  }

  return false;
}

class server {
  url = "server.php?";
  get(path = "") {
    let urlApi = this.url + path;
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: urlApi,
        type: "GET",
        dataType: "json",
        processData: false,
        contentType: false,
      })
        .done(function (res, req) {
          resolve(res, req);
        })
        .fail(function (xhr, status, error) {
          reject(xhr, status, error);
        });
    });
  }
  post(path = "", Data = "") {
    let urlApi = this.url + path;
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: urlApi,
        type: "POST",
        data: Data,
        dataType: "json",
        processData: false,
        contentType: false,
      })
        .done(function (res, req) {
          resolve(res, req);
        })
        .fail(function (xhr, status, error) {
          reject(xhr, status, error);
        });
    });
  }
  delete(path = "", Data = "") {
    let urlApi = this.url + path;
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: urlApi,
        type: "DELETE",
        data: Data,

        processData: false,
        contentType: false,
      })
        .done(function (res, req) {
          resolve(res, req);
        })
        .fail(function (xhr, status, error) {
          reject(xhr, status, error);
        });
    });
  }
}

$(document).ready(function () {
  let urlAction = window.location.href;
  if (checkCookie("c_user")) {
    urlAction =
      urlAction.indexOf("action=") != -1 &&
      urlAction.split("action=")[1].split("&")[0] != "login"
        ? urlAction.split("action=")[1].split("&")[0]
        : "home";

    $("#user-login").attr("href", "index.php?action=user");
  } else {
    urlAction =
      urlAction.indexOf("action=") != -1 &&
      urlAction.split("action=")[1].split("&")[0] != "user"
        ? urlAction.split("action=")[1].split("&")[0]
        : "home";
    $("#user-login").attr("href", "index.php?action=login");
    if (urlAction == "login") {
      $("#header").remove();
      $("body > link:nth-child(3)").remove();
      $("#Modal-search").remove();
      $("#main > script").remove();
      $("#footer").remove();
      $("body > link").remove();
    }
  }

  $("#body").load(
    "view/" + urlAction + ".views.php",
    (response, status, xhr) => {
      if (status == "error") {
        $("html").load("view/error/404.php");
      }
    }
  );

  $("body > header > title").text(urlAction.toLocaleUpperCase()); //
});
