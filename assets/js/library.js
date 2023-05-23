function navigateToPage(page) {
  currentPages = page;
  loadLibrary();
  createPagination(page, totalPages);
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
