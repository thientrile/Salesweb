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

$(function () {
  let urlAction = window.location.href;
  urlAction =
    urlAction.indexOf("action=") != -1
      ? urlAction.split("action=")[1].split("&")[0]
      : "home";
  if (urlAction == "login" && checkCookie("c_user")) {
    window.location.replace("index.php?action=user");
  } else if (urlAction == "login") {
    $("head > link:nth-child(18)").remove();
    $("head > link:nth-child(18)").remove();
    $("#main > script").remove();
    $("#Modal-search").remove();
    $("#header").remove();
    $("#footer").remove();
  }
  if (urlAction == "user" && !checkCookie("c_user")) {
    window.location.replace("index.php?action=login");
  }
  if (urlAction != "admin") {
    $("#body").load(
      "view/client/" + urlAction + ".views.php",
      (response, status, xhr) => {
        if (status == "error") {
          $("html").load("view/error/404.php");
        }
      }
    );
  } else if (checkCookie("c_user")) {
    $("#header").remove();
    $("#footer").remove();
    let Server = new server();
    Server.get("action=user")
      .then((res, req) => {
        if (res.role_id != 2) {
          $("head > link:nth-child(18)").attr(
            "href",
            "./assets/css/styles.min.css"
          );
          $("#Modal-search").remove();

          $("body").load("view/include/admin.php", function () {
            let adminUrl =
              window.location.href.search("function=") != -1
                ? window.location.href.split("function=")[1].split("&")[0]
                : "dashboard";
            $("#body").load(
              `view/admin/${adminUrl}.views.php`,
              function (res, status, xhr) {
                $("head > title").html(
                  urlAction.toLocaleUpperCase() + " - " + adminUrl
                );
                if (status == "error") {
                  window.location.replace(
                    "index.php?action=admin&function=dashboard"
                  );
                }
              }
            );
          });
        } else {
          window.location.replace("index.php?action=home");
        }
      })
      .catch((xhr, status, error) => {
        window.location.replace("index.php?action=home");
        console.log(xhr, status, error);
      });
  } else {
    window.location.replace("index.php?action=home");
  }
  $("head > title").html(urlAction.toLocaleUpperCase()); //
});
