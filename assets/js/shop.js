function loadproducts(href = "") {
  let url =
    href != ""
      ? href.split("action=shop&")[1]
      : window.location.href.split("action=shop&")[1];

  $(".creative").html(` <div class="container translate-top">
  <div class="row" id="product">
  <div class="col-12 d-flex justify-content-center">
  <div class="spinner-border text-info "></div></div>


  </div>
  <div id="pagination">

  </div>


</div>`);
  let Server = new server();
  Server.get(`action=product&${url}`)
    .then((res, req) => {
      let result = "";

      for (let i of res) {
        let price =
          i.discount > 0
            ? `         <sub style="text-decoration:line-through">${
                i.price
              }</sub>$ ${i.price - i.price * i.discount}`
            : i.price > 0
            ? `$ ${i.price}`
            : "Free";

        result += `
          <div class="col-lg-4 col-md-6">
              <div class="card">
                  <div class="creative-img-cover">
                      <img class="card-img-top" src="assets/products/${i.id}/img/${i.img}" alt="${i.img}" style="width: 100%; min-height:200px" />
                      <div class="creative-icon">
                          <span class="plus" style="--bg: #fff; --color: #34b7ae">
                              <a href="index.php?action=shop&id=${i.id}">
    
    
                                  <i class="fa-solid fa-plus"></i>
                              </a>
                          </span>
                          <span class="cart" style="--bg: #34b7ae; --color: #fff"><a href="index.php?action=cart"><i class="fa-solid fa-cart-shopping"></i></a>
                          </span>
                      </div>
                  </div>
    
                  <div class="card-body">
                      <a href="index.php?action=shop&cate=${i.category_id}" class="heading-note">${i.name}</a>
                      <br>
                      <a href="index.php?action=shop&act=detail&id=${i.id}" class="card-title h5 text-dark" style="text-decoration: none;">${i.title}</a>
                      <p class="card-text card-price">
                          <span>
                          ${price}
    
    
    
                          </span>
                      </p>
                  </div>
              </div>
          </div>
    `;
      }
      $("#product").html(result);
    })
    .catch((xhr, statu, error) => {
      console.log(error);
    });
}

function loadproduct() {
  let id = window.location.href.split("id=")[1].split("&")[0];
  let Server = new server();
  Server.get(`action=product&id=${id}`)
    .then((res, req) => {
      let img = res.img;
      $(".heading-title").html(res.title).addClass("text-center");
      $(".heading-sub")
        .html(res.sDescription)
        .addClass("text-center")
        .css("font-size:", "1em");
      Server.get(`action=product&id=${id}&function=gallery`).then(
        (data, req = "") => {
          console.log(data);
          let button =
            checkCookie("c_user") == true
              ? `<button class="btn btn-success">Buy</button> <button class="btn btn-warning">Add to cart</button>`
              : `<a href="index.php?action=login" class="btn btn-primary">Login</a>`;
          let price =
            res.discount > 0
              ? `         <sub style="text-decoration:line-through">${
                  res.price
                }</sub>$ ${res.price - res.price * res.discount}`
              : res.price > 0
              ? `$ ${res.price}`
              : "Free";
          let indicators = "";
          let inner = "";
          for (let i = 0; i < data.length; i++) {
            if (data.length > 1) {
              indicators +=
                i == 0
                  ? `<li data-bs-target="#media-carousel" data-bs-slide-to="${i}" class="active"></li>`
                  : `<li data-bs-target="#media-carousel" data-bs-slide-to="${i}" ></li>`;
            }
            if (getFileType(data[i].thumnali) == "audio") {
              inner +=
                i == 0
                  ? `<div class="carousel-item active">
                      <img class="d-block w-100 " src=" assets/products/${id}/img/${img}" alt=${img}">
                      <audio class="d-block w-100" src=" assets/products/${id}/gallery/${data[i].thumnali}" controls></audio>
                    </div>`
                  : `<div class="carousel-item">
                      <img class="d-block w-100 " src=" assets/products/${id}/img/${img}" alt="<?php echo $new[2] ?>">
                      <audio class="d-block w-100" src=" assets/products/${id}/gallery/${data[i].thumnali}" controls></audio>
                    </div>`;
            } else if (getFileType(data[i].thumnali) == "image") {
              inner +=
                i == 0
                  ? `<div class="carousel-item active"><img class="d-block w-100 " style="object-fit: cover;" src="assets/products/${id}/gallery/${data[i].thumnali}"></div>`
                  : `<div class="carousel-item"><img class="d-block w-100 " style="object-fit: cover;" src="assets/products/${id}/gallery/${data[i].thumnali}"></div>`;
            } else {
              inner +=
                i == 0
                  ? `<div class="carousel-item active ">
                      <video class="d-block w-100" src=" assets/products/${id}/gallery/${data[i].thumnali}" controls></video>
                    </div>`
                  : `<div class="carousel-item">
                      <video class="d-block w-100" src=" assets/products/${id}/gallery/${data[i].thumnali}" controls></video>
                    </div>`;
            }
          }
          $(".creative")
            .html(` <div class="container translate-top shadow-lg" style="background: white;">
            <div class="row p-3">
                <div class="col-md-8">
                    <div id="media-carousel" class="carousel slide" data-bs-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators" style="bottom:auto;top:0">
          ${indicators}
                        </ol>
                        <!-- Slides -->
                        <div class="carousel-inner">
          ${inner}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mt-4 border border-3" style="width:100%;">
                        <div class="card-header text-center">Item Details</div>
                        <div class="card-body d-flex justify-content-center align-items-center flex-column">
                            <h3 class="">
                          ${price}
                            </h3>
                            ${
                              checkCookie("c_user") == true
                                ? `<button class="btn btn-success">Buy</button> <button id="addcart" onclick="addcart(${res.id})" class="btn btn-warning">Add to cart</button>`
                                : `<a href="index.php?action=login" class="btn btn-primary">Login</a>`
                            }
                        </div>
                    </div>
                    <div class="card mt-4 border border-3" style="width:100%;">
                        <div class="card-header text-center">DETAILS</div>
                        <div class="card-body d-flex justify-content-start align-items-center flex-column">
                            <ul class="list-group" style="width:100%">
                                <li class="list-group-item">Category:<a href="index.php?action=shop&cate=${
                                  res.category_id
                                }"
                                        style="font-size:1em;text-decoration: none;" class="text-success">${
                                          res.name
                                        }
                                    </a></li>
                                <li class="list-group-item">Released Date:${
                                  res.created_at
                                }</li>
                                <li class="list-group-item">Last Updated:${
                                  res.updated_at
                                }</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mt-5">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#description">Description</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane container active" id="description">
          ${req.description}
                        </div>
                    </div>
                </div>
            </div>
          </div>`);
          checkcart();
        }
      );
    })
    .catch((xhr, stauts, error) => {
      console.log(error);
    });
}

function getFileType(filename) {
  if (
    filename.endsWith(".mp3") ||
    filename.endsWith(".wav") ||
    filename.endsWith(".ogg")
  ) {
    return "audio";
  } else if (
    filename.endsWith(".mp4") ||
    filename.endsWith(".mov") ||
    filename.endsWith(".avi")
  ) {
    return "video";
  } else if (
    filename.endsWith(".jpg") ||
    filename.endsWith(".jpeg") ||
    filename.endsWith(".png") ||
    filename.endsWith(".gif")
  ) {
    return "image";
  }
}
function addcart(id, e) {
  $(e).html(`<div class="spinner-border text-white"></div>`);
  let formData = new FormData();
  formData.append("id", id);
  let Server = new server();
  Server.post("action=cart", formData)
    .then((res, req) => {
      checkcart();
    })
    .catch((xhr, sta, err) => {
      console.log(err);
    })
    .finally(() => {
      checkcart();
    });
}
function checkcart() {
  let id = window.location.href.split("id=")[1].split("&")[0];
  let Server = new server();
  Server.get(`action=cart&id=${id}`).then((res, req) => {
    if (res.result == true) {
      $("#addcart").text(`View cart`);
      $("#addcart").attr("onclick", "location.href='index.php?action=cart'");
    } else {
      $("#addcart").text(`Add to cart`);
      $("#addcart").attr("onclick", `addcart(${id},this)`);
    }
  });
}
$(document).ready(function () {
  if (window.location.href.indexOf("id=") != -1) {
    loadproduct();
  } else {
    loadproducts();
  }
});
