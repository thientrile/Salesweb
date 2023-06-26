function navigateToPage(page) {
  currentPages = page;
  loadLibrary();
  createPagination(page, totalPages);
}
function loadLibrary() {
  let Server = new server();
  var page = 1;
  Server.get(`action=payment&function=view_Library&page=${currentPages}`)
    .then((res, req) => {
      let result = "";

      for (let i of res.data) {
        result += `
              <div class="col-lg-4 col-md-6">
                  <div class="card">
                      <div class="creative-img-cover">
                          <img class="card-img-top" src="${i.img}" alt="${i.img}" style="width: 100%; min-height:200px" />
                          <div class="creative-icon">
                              <span class="plus" style="--bg: #fff; --color: #34b7ae">
                                  <a target="_blank" href="${i.sources}">       
                                  <i class="fa-solid fa-down-long"></i>
                                  </a>
                              </span>                             
                          </div>
                      </div>        
                      <div class="card-body">
                          <a href="index.php?action=shop&cate=${i.category_id}" class="heading-note">${i.name} </a>
                          <br>
                          <a href="index.php?action=shop&act=detail&id=${i.id}" class="card-title h5 text-dark" style="text-decoration: none;">${i.title}  ${i.value != null ? " (" + i.value + ")" : ""}</a>                        
                      </div>
                  </div>
              </div>`;
      }
      $("#library").html(result);
      page = res.page

    })
    .catch((x, st, err) => {
      console.log(x);
      $("#library").text(``);
    })
    .finally(() => {

      createPagination(currentPages, page);
    });
}
$(document).ready(() => {
  loadLibrary();
});
