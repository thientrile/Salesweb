
/**
 * The function updates the text of an HTML element with the formatted price value or "Free" if the
 * price is zero.
 * @param price - The price of a product or service, which is passed as an argument to the function.
 */
function getprice(price) {
  $("#rePrice").text(price != 0 ? formatCurrency(price) : "Free")

  let product_item_id = $("input[name='product_item']:checked").val()
  $("#cart").attr({ onclick: `addToCart(${product_item_id})` })
  $("#payment").attr({ onclick: `payment(${product_item_id})` })


}
function formatCurrency(amount) {
  return amount.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
}
function addToCart(id) {
  let data = new FormData();
  $("#cart").html(`<div class="spinner-border text-light"></div>`)
  data.append("id", id);
  let Server = new server();
  Server.post("action=cart", data).then((res, req) => {
    if (res.status == "success") {
      countCart()
    }
  }).catch((xhr, status, error) => {
    console.log(xhr.responseText);
  }).finally(() => {
    loadproduct();

  })
}
function payment(id) {
  window.location.href = `index.php?action=payment&id=${id}`;
}
/**
 * The function navigates to a specific page and loads products while creating pagination.
 * @param page - The page parameter is a number that represents the current page that the user wants to
 * navigate to.
 */
function navigateToPage(page) {
  currentPages = page;
  createPagination(page, totalPages);
  loadproducts();

}
/**
 * The function loads products from a server and displays them on a webpage with pagination and options
 * to add to cart or view details.
 */
function loadproducts() {
  let url =
    window.location.href.split("action=shop&")[1];

  let Server = new server();
  Server.get(`action=product&${url}&page=${currentPages}`)
    .then((res, _req) => {
      let result = "";
      totalPages = res.page;
      createPagination(currentPages, res.page);
      if (window.location.href.search("&keySearch=") != -1) {

        $("#body > div.img-top > div > p").text("Search Results '" + window.location.href.split("keySearch=")[1].split("&")[0] + "' found "+res.data.length+" results")
      }
      for (let i of res.data) {
        try {
          const price = i.options.map((j) => formatCurrency(j.price)).join(", ");
          result += `
          <div class="col-lg-4 col-md-6">
              <div class="card">
                  <div class="creative-img-cover">
                      <img class="card-img-top" src="${i.img}" alt="" style="width: 100%; min-height:200px" />
                      <div class="creative-icon" id="creative-icon-${i.id}">
                          <span class="plus" style="--bg: #fff; --color: #34b7ae">
                              <a href="index.php?${i.multiple ? `action=shop&id=${i.id}` : `action=payment&id=${i.options[0].id}`}">
                                  <i class="fa-solid fa-plus"></i>
                              </a>
                          </span>
                          <span class="cart" style="--bg: #34b7ae; --color: #fff;cursor:pointer">
                              <a ${i.multiple ? `href="index.php?action=shop&id=${i.id}"` : ` onclick=" toCart(${i.options[0].id})"`}>
                                  <i class="fa-solid fa-cart-shopping"></i>
                              </a>
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
        } catch (exceptionVar) {
          console.log(exceptionVar);
        }

      };
      $("#product").html(result);
    })
    .catch((xhr, statu, error) => {
      console.log(xhr, statu, error);
    });
}

/**
 * The function loads a product page with details and media content from a server response.
 */
function loadproduct() {

  let id = window.location.href.split("id=")[1].split("&")[0];
  let Server = new server();
  Server.get(`action=product&id=${id}`)
    .then((res, _req) => {
      let options = res.options
      let btn = `   <button type="button" class="btn btn-outline-warning" id="cart" onclick="addToCart(${options[options.length - 1].id})"><i class="fa-solid fa-cart-plus"></i></button>
      <button type="button" class="btn btn-success mt-2"id="payment" onclick="payment(${options[options.length - 1].id})"><i class="fa-solid fa-credit-card"  ></i></button>`;
      let price = ""



      let cart = 0;

      let checkout = 0;

      for (let i = 0; i < options.length; i++) {
        if (!options[i].check) {
          if (res.multiple) {

            price += `<div class="form-check">
                <input type="radio" class="form-check-input" id="radio${options[i].id}" name="product_item"  value="${options[i].id}" onchange="getprice(${options[i].price},)"${!options[i].check ? "checked" : ""} >
                <label   for="radio${options[i].id}"> ${options[i].name + " " + options[i].value + " - " + formatCurrency(options[i].price)} ${options[i].cart ? `<span style="transform: translateY(-50%);" class="badge rounded-pill bg-warning">in cart</span>` : ""}                  
                </label>
              </div>`;
          }


        }

        if (options[i].cart) {
          cart++;
          // console.log(options[i].cart);
          if (cart == options.length) {
            btn = `   <button type="button" class="btn btn-outline-warning" id="cart" onclick="window.location.href='index.php?action=cart'"><i class="fa-solid fa-cart-shopping"></i></button>
            <button type="button" class="btn btn-success mt-2"><i class="fa-solid fa-credit-card" id="payment" onclick="payment(${options[options.length - 1].id})"></i></button>`;
          }


        }
        if (options[i].check) {
          checkout++
          // console.log(checkout);
          if (checkout == options.length) {
            btn = ` <button type="button" class="btn btn-outline-warning" id="library" onclick="window.location.href='index.php?action=library'"><i class="fa-regular fa-floppy-disk"></i></button>`
          }

        }



      }
      if (!checkCookie('c_user')) {
        btn = `<a href="action=login" class="btn btn-success">Login</a>`;
      }



      if (res) {
        $("body > header > title").text("SHOP - " + res.title);
        let img = res.img;
        $("head > title").html(res.title)
        $(".heading-title").html(res.title).addClass("text-center");
        $(".heading-sub")
          .html(res.sDescription)
          .addClass("text-center")
          .css("font-size:", "1em");



        Server.get(`action=product&id=${id}&function=gallery`).then(
          (data, _req = "") => {


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
                        <img class="d-block w-100 " src=" ${img}" alt=${img}">
                        <audio class="d-block w-100" src=" ${data[i].thumnali}" controls></audio>
                      </div>`
                    : `<div class="carousel-item">
                        <img class="d-block w-100 " src=" ${img}" alt="<?php echo $new[2] ?>">
                        <audio class="d-block w-100" src=" ${data[i].thumnali}" controls></audio>
                      </div>`;
              } else if (getFileType(data[i].thumnali) == "image") {
                inner +=
                  i == 0
                    ? `<div class="carousel-item active"><img class="d-block w-100 " style="object-fit: cover;" src="${data[i].thumnali}"></div>`
                    : `<div class="carousel-item"><img class="d-block w-100 " style="object-fit: cover;" src="${data[i].thumnali}"></div>`;
              } else {
                inner +=
                  i == 0
                    ? `<div class="carousel-item active ">
                        <video class="d-block w-100" src=" ${data[i].thumnali}" controls></video>
                      </div>`
                    : `<div class="carousel-item">
                        <video class="d-block w-100" controls>
                        
                        <source   src=" ${data[i].thumnali}" type="video/*">
                        </video>
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
                          <div class="card-body d-block  px-5">
                          <h1 id="rePrice" class="text-center">${res.options[res.options.length - 1].price == 0 ? "Free" : formatCurrency(res.options[res.options.length - 1].price)}</h1>
                           
                             ${price}
                          
                            
                             
                              <div id="view-btn"class="d-flex justify-content-center flex-column ">
                           ${btn}</div>
  
                              
                          </div>
                      </div>
                      <div class="card mt-4 border border-3" style="width:100%;">
                          <div class="card-header text-center">DETAILS</div>
                          <div class="card-body d-flex justify-content-start align-items-center flex-column">
                              <ul class="list-group" style="width:100%">
                                  <li class="list-group-item">Category:<a href="index.php?action=shop&cate=${res.category_id}"
                                          style="font-size:1em;text-decoration: none;" class="text-success">${res.name}
                                      </a></li>
                                  <li class="list-group-item">Released Date:${res.created_at}</li>
                                  <li class="list-group-item">Last Updated:${res.updated_at}</li>
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
            ${res.description}
                          </div>
                      </div>
                  </div>
              </div>
            </div>`);

          }
        );

      } else {
        window.location.replace("index.php?action=shop");
      }
    })
    .catch((_xhr, _stauts, error) => {
      console.log(_xhr);
    });
}

/**
 * The function determines the file type based on the file extension.
 * @param filename - a string representing the name of a file, including its extension.
 * @returns a string indicating the type of file based on the file extension. It returns "audio" if the
 * file extension is .mp3, .wav, or .ogg, "video" if the file extension is .mp4, .mov, or .avi, and
 * "image" if the file extension is .jpg, .jpeg, .png, or .gif. If the
 */
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



/* The above code is using jQuery to check if the current URL contains the string "id=". If it does, it
calls the function "loadproduct()", otherwise it calls the function "loadproducts()". This code is
likely used to determine whether to load a single product or multiple products on a page, based on
the presence of an ID parameter in the URL. */
$(function () {
  if (window.location.href.indexOf("id=") != -1) {
    loadproduct();

  } else {
    loadproducts();
  }
});
