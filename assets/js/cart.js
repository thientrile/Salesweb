// function is called when the website is loaded.It's loads
function loadCart() {
  countCart();
  $("#cart").html(
    ` <div class="d-flex justify-content-center"> <div class="spinner-border text-info "></div></div> `
  );
  let Server = new server();
  Server.get("action=cart")
    .then((res, req) => {
      if (res.length > 0) {
        let items = "";
        for (let i of res) {
          items += ` <div class="row bg-white shadow-lg m-2 p-2 rounded bg-white">
              <div class="col-3 p-2" style="line-height: 100%;">${i.title}</div>
              <div class="col-3"><img width="50%" src="${i.img}" alt=""></div>
              <div class="col-3 p-2">${
                i.discount > 0
                  ? `         <sub style="text-decoration:line-through">${
                      i.price
                    }</sub>$ ${i.price - i.price * i.discount}`
                  : i.price > 0
                  ? `$ ${i.price}`
                  : "Free"
              }</div>
              <div class="col-3 p-2 "> <button cartId="${
                i.id
              }" class="btn btn-danger m-auto cartDel" onclick="cartDel(this)">Delete</button> </div>
          </div>         `;
        }
        items += ` <div class="row bg-white shadow-lg m-2 p-2 rounded bg-white">
        
        <div class="col-3"> <h5>Items:  ${res.length}</h5></div>
       <div class="col-5"></div>
        <div class="col-4">
           <button class="btn btn-outline-danger" onclick="carDels(this)">Deletel All</button>
           <a href="index.php?action=payment" class="btn btn-success">Payments</a>
        </div>
      
        
    </div>`;
        $("#cart").html(items);
      } else {
        $("#cart").text("Your cart is empty.");
        $("#cart").css({ background: "white", "min-height": "150px" });
        $("#cart").addClass("shadow-lg p-2");
      }
    })
    .catch((xhr, sta, err) => {
      $("#cart").text("Your cart is empty.");
      $("#cart").css({ background: "white", "min-height": "150px" });
      $("#cart").addClass("shadow-lg p-2");
    });
}
function cartDel(e) {
  $(e).html(`<div class="spinner-border text-white"></div>`);
  let Server = new server();

  Server.delete(`action=cart&id=${$(e).attr("cartId")}`, "")
    .then((res, req) => {
      loadCart();
    })
    .catch((xhr, status, err) => {
      console.log(xhr, status, err);
    });
}
function carDels(e) {
  $(e).html(`<div class="spinner-border text-white"></div>`);
  let Server = new server();
  Server.delete(`action=cart`, "")
    .then((res, req) => {
      loadCart();
    })
    .catch((xhr, status, err) => {
      console.log(xhr, status, err);
    });
}
$(document).ready(function () {
  loadCart();
});
