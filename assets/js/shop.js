function loadproducts(href = "") {
  let url =
    href != ""
      ? href.split("action=shop&")[1]
      : window.location.href.split("action=shop&")[1];

  $(".creative").html(` <div class="container translate-top">
  <div class="row" id="product">


  </div>
  <div id="pagination">

  </div>


</div>`);

  $.ajax({
    url: `http://demo.local/server.php?action=product&${url}`,
    type: "GET",
    dataType: "json",
    success: function (data) {
      let result = "";
      for (let i of data) {
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
                  <span title="index.php?action=shop&cate=${i.category_id}" onclick="loadproducts(this.title)" class="heading-note">${i.name}</span>
                  <br>
                  <a href="index.php?action=shop&id=${i.id}" class="card-title h5 text-dark" style="text-decoration: none;">${i.title}</a>
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
    },
    error: function (xhr, status, error) {
      console.log(xhr.responseText);
      console.log(status);
      console.log(error);
    },
  });
}

function loadproduct() {
  let id = window.location.href.split("id=")[1].split("&")[0];

  $.ajax({
    url: `http://demo.local/server.php?action=product&id=${id}`,
    type: "GET",
    dataType: "json",
    success: function (req) {
      let img = req.img;
      $(".heading-title").html(req.title).addClass("text-center");
      $(".heading-sub")
        .html(req.sDescription)
        .addClass("text-center")
        .css("font-size:", "1em");
      $.ajax({
        url: `http://demo.local/server.php?action=product&id=${id}&function=gallery`,
        type: "GET",
        dataType: "json",
        success: function (data) {
          let button =
            checkCookie("c_user") == true
              ? `<button class="btn btn-success">Buy</button> <button class="btn btn-warning">Add to cart</button>`
              : `<a href="index.php?action=login" class="btn btn-primary">Login</a>`;

          let price =
            req.discount > 0
              ? `         <sub style="text-decoration:line-through">${
                  req.price
                }</sub>$ ${req.price - req.price * req.discount}`
              : req.price > 0
              ? `$ ${req.price}`
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
                      ? `<button class="btn btn-success">Buy</button> <button id="addcart" onclick="addcart(${req.id})" class="btn btn-warning">Add to cart</button>`
                      : `<a href="index.php?action=login" class="btn btn-primary">Login</a>`
                  }

              </div>
          </div>
          <div class="card mt-4 border border-3" style="width:100%;">
              <div class="card-header text-center">DETAILS</div>
              <div class="card-body d-flex justify-content-start align-items-center flex-column">
                  <ul class="list-group" style="width:100%">
                      <li class="list-group-item">Category:<a href="index.php?action=shop&cate=${
                        req.category_id
                      }"
                              style="font-size:1em;text-decoration: none;" class="text-success">${
                                req.name
                              }

                          </a></li>
                      <li class="list-group-item">Released Date:${
                        req.created_at
                      }</li>
                      <li class="list-group-item">Last Updated:${
                        req.updated_at
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
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
          console.log(status);
          console.log(error);
        },
      });
    },
    error: function (xhr, status, error) {
      console.log(xhr.responseText);
      console.log(status);
      console.log(error);
    },
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
function addcart(id) {
  let formData = new FormData();
  formData.append("id", id);
  $.ajax({
    url: `server.php?action=cart`,
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function (data) {
      $("#addcart").text(`View cart`);
      $("#addcart").attr("onclick", "location.href='index.php?action=cart'");
    },
  });
}
function checkcart() {
  let id = window.location.href.split("id=")[1].split("&")[0];
  $.ajax({
    url: `server.php?action=cart&id=${id}`,
    type: "GET",
    dataType: "JSON",
    processData: false,
    contentType: false,
    success: function (data) {
      if (data.result == true) {
        $("#addcart").text(`View cart`);
        $("#addcart").attr("onclick", "location.href='index.php?action=cart'");
      } else {
        $("#addcart").text(`Add to cart`);
        $("#addcart").attr("onclick", "addcart(${req.id})");
      }
    },
  });
}
$(document).ready(function () {
  if (window.location.href.indexOf("id=") != -1) {
    loadproduct();
  } else {
    loadproducts();
  }
});
