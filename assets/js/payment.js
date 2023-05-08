function userInfo() {
  let Server = new server();
  Server.get("action=user")
    .then((res, req) => {
      $("#info").html(`  <div class="col-3">Name: ${res.fullname}</div>
      <div class="col-lg-3">Email: ${res.email}</div>
      <div class="col-lg-3">Balance:$ ${res.balance}</div>
      <div class="col-lg-3"><button type="button" class="btn btn-info">Recharge</button></div>`);
    })
    .catch((xhr, status, err) => {});
}
function view() {
  let Server = new server();
  let url = window.location.href;
  if (url.search("id") == -1) {
    Server.get("action=cart").then((res, req) => {
      let items = "";
      let price = 0;
      let discount = 0;
      for (let i of res) {
        price += i.price;
        discount += i.discount;
        items += ` <div class="row ">
              <div class="col-3 p-2" style="line-height: 100%;">${i.title}</div>
              <div class="col-3"><img width="50%" src="assets/products/${
                i.product_id
              }/img/${i.img}" alt=""></div>
              <div class="col-3 p-2">${
                i.discount > 0
                  ? `         <sub style="text-decoration:line-through">${
                      i.price
                    }</sub>$ ${i.price - i.price * i.discount}`
                  : i.price > 0
                  ? `$ ${i.price}`
                  : "Free"
              }</div>
            
          </div>         `;
      }
      $("#payment").html(`  <div class="row">
      <div class="col-md-12 col-sm-2 text-center h2">Items: ${res.length}</div>
      <div class="col-md-12 col-sm-2 border-top">Price:$${price}</div>
      <div class="col-md-12 col-sm-2">Discount: $${discount * price}</div>
      <div class="col-md-12 col-sm-2 border-top">Totals: $${
        price - discount * price
      }</div>
      <div class="col-md-12 col-sm-2">
          <div class="row">
              <div class="col-6"><a class="btn btn-outline-info" href="index.php?action=shop">Back to shop</a> </div>
              <div class="col-6"> <button class="btn btn-danger" onclick="pay(this) ">Payment</button> </div>
          </div>
      </div>
  </div>`);
      $("#items").html(items);
    });
  }
}
function pay(e) {
  $(e).html(`<div class="spinner-border text-white"></div>`);
  let Server = new server();
  let url = window.location.href;
  if (url.search("id") == -1) {
    Server.post("action=payment", "")
      .then((res, req) => {
        view();
        userInfo();
        //   window.location.replace("index.php?action=shop");
      })
      .catch((xhr, status, err) => {})
      .finally(() => {
        console.log("done !");
      });
  }
}
$(document).ready(function () {
  userInfo();
  view();
});
