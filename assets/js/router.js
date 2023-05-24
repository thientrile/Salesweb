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
var totalPages = 1;
var currentPages = /([\?&])page=([^&#]*)/.test(window.location.href)
  ? parseFloat(window.location.href.split("&page=")[1])
  : 1;
function addPageQueryParam(event, currentPage) {
  event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>

  let url = window.location.href;
  let regex = /([\?&])page=([^&#]*)/; // Regex để tìm kiếm tham số truy vấn 'page'

  if (regex.test(url)) {
    // Nếu tham số truy vấn 'page' đã tồn tại
    var newUrl = url.replace(regex, "$1page=" + currentPage);
    window.history.replaceState(null, "", newUrl);
  } else {
    // Nếu tham số truy vấn 'page' chưa tồn tại
    var separator = url.indexOf("?") !== -1 ? "&" : "?";
    var newUrl = url + separator + "page=" + currentPage;
    window.history.replaceState(null, "", newUrl);
  }
}

function createPagination(currentPage, totalPages) {
  const paginationElement = document.getElementById("page");

  // Xóa nội dung điều hướng phân trang hiện tại
  paginationElement.innerHTML = "";
  if (totalPages > 1) {
    const paginationList = document.createElement("ul");
    paginationList.classList.add("pagination");

    // Tạo phần tử <li> và nút Previous (Trang trước)
    const previousLi = document.createElement("li");
    previousLi.classList.add("page-item");
    const previousButton = document.createElement("a");
    previousButton.classList.add("page-link");
    previousButton.href = "#";
    previousButton.innerText = "Previous";
    previousButton.disabled = currentPage === 1;
    previousButton.addEventListener("click", () => {
      if (currentPage > 1) {
        navigateToPage(currentPage - 1);
      }
    });
    previousLi.appendChild(previousButton);
    paginationList.appendChild(previousLi);

    // Tạo phần tử <li> cho từng trang
    for (let page = 1; page <= totalPages; page++) {
      if (
        page === currentPage ||
        (page >= currentPage - 1 && page <= currentPage + 1) ||
        (page === totalPages && page >= currentPage + 2)
      ) {
        const pageLi = document.createElement("li");
        pageLi.classList.add("page-item");
        const pageButton = document.createElement("a");
        pageButton.classList.add("page-link");
        
        pageButton.setAttribute("onclick", `addPageQueryParam(event,${page})`);
        pageButton.innerText = page.toString();
        if (page === currentPage) {
          pageLi.classList.add("active");
        }
        pageButton.addEventListener("click", () => {
          navigateToPage(page);
        });
        pageLi.appendChild(pageButton);
        paginationList.appendChild(pageLi);
      } else if (page === currentPage + 2) {
        const pageLi = document.createElement("li");
        pageLi.classList.add("page-item");
        const pageButton = document.createElement("a");
        pageButton.classList.add("page-link");
        pageButton.href = `#`;
        pageButton.setAttribute(
          "onclick",
          `addPageQueryParam(event,${currentPage})`
        );

        pageButton.innerText = "...";
        pageButton.addEventListener("click", () => {
          navigateToPage(page);
        });
        pageLi.appendChild(pageButton);
        paginationList.appendChild(pageLi);
      }
    }

    // Tạo phần tử <li> và nút Next (Trang tiếp theo)
    const nextLi = document.createElement("li");
    nextLi.classList.add("page-item");
    const nextButton = document.createElement("a");
    nextButton.classList.add("page-link");
    
    nextButton.innerText = "Next";
    nextButton.disabled = currentPage === totalPages;
    nextButton.addEventListener("click", () => {
      if (currentPage < totalPages) {
        navigateToPage(currentPage + 1);
      }
    });
    nextLi.appendChild(nextButton);
    paginationList.appendChild(nextLi);

    // Thêm phần tử <ul> vào điều hướng phân trang
    paginationElement.appendChild(paginationList);
  }
  // Tạo phần tử <ul> chứa điều hướng phân trang
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
    $("#bs5").remove();
    $("#style").remove();
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
          window.location.replace("index.php?action=home");
        }
      }
    );
  } else if (checkCookie("c_user")) {
    $("#style").attr("href", "./assets/css/styles.min.css");
    $("#header").remove();
    $("#footer").remove();
    $("#Modal-search").remove();
    let Server = new server();
    Server.get("action=user")
      .then((res, req) => {
        if (res.role_id != 2) {
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
          window.location.replace("index.php?action=user");
        }
      })
      .catch((xhr, status, error) => {
        window.location.replace("index.php?action=user");
        console.log(xhr, status, error);
      });
  } else {
    window.location.replace("index.php?action=user");
  }
  $("head > title").html(urlAction.toLocaleUpperCase()); //
});
