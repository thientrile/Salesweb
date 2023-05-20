var totalPages = 1;
var currentPages = 1;
function createPagination(currentPage, totalPages) {
  const paginationElement = document.getElementById("page");

  // Xóa nội dung điều hướng phân trang hiện tại
  paginationElement.innerHTML = "";

  // Tạo phần tử <ul> chứa điều hướng phân trang
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
      pageButton.href = "#";
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
      pageButton.href = "#";
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
  nextButton.href = "#";
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

function navigateToPage(page) {
  currentPages = page;
  loadLibrary();
  createPagination(page, totalPages);
  // Thực hiện các tác vụ cần thiết khi chuyển đến trang mới
  // ở đây, bạn có thể gọi hàm tải dữ liệu mới, v.v.

  // Gọi lại hàm tạo điều hướng phân trang với trang hiện tại mới
}
function loadLibrary() {
  let Server = new server();
  $("#library").html(
    ` <div class="d-flex justify-content-center"> <div class="spinner-border text-info "></div></div> `
  );
  Server.get(`action=payment&function=view_Library&page=${currentPages}`)
    .then((res, req) => {
      let result = "";
      createPagination(currentPages, res.page);
      for (let i of res.data) {
        result += `
              <div class="col-lg-4 col-md-6">
                  <div class="card">
                      <div class="creative-img-cover">
                          <img class="card-img-top" src="${i.img}" alt="${i.img}" style="width: 100%; min-height:200px" />
                          <div class="creative-icon">
                              <span class="plus" style="--bg: #fff; --color: #34b7ae">
                                  <a href="${i.source}" alt="${i.img}">
        
        
                                  <i class="fa-solid fa-down-long"></i>
                                  </a>
                              </span>
                             
                          </div>
                      </div>
        
                      <div class="card-body">
                          <a href="index.php?action=shop&cate=${i.category_id}" class="heading-note">${i.name}</a>
                          <br>
                          <a href="index.php?action=shop&act=detail&id=${i.id}" class="card-title h5 text-dark" style="text-decoration: none;">${i.title}</a>
                        
                      </div>
                  </div>
              </div>
        `;
      }
      $("#library").html(result);
    })
    .catch((x, st, err) => {
      $("#library").text(``);
    })
    .finally(() => {});
}
$(document).ready(() => {
  loadLibrary();
});
