function userInfo() {
  let Server = new server();
  Server.get("action=user")
    .then((res, req) => {
      $("#info").html(`  <div class="col-3">Name: ${res.fullname}</div>
      <div class="col-lg-3">Email: ${res.email}</div>
      <div class="col-lg-3">Balance:$ ${res.balance}</div>
      <div class="col-lg-3"><button type="button" class="btn btn-info">Recharge</button></div>`);
    })
    .catch((xhr, status, err) => { });
}
function view() {
  countCart();
  let Server = new server();
  let url = window.location.href;
  let id = url.split("id=")[1];
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
              <div class="col-3"><img width="50%" src="${i.img}" alt=""></div>
              <div class="col-3 p-2">${i.discount > 0
            ? `         <sub style="text-decoration:line-through">${i.price
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
      <div class="col-md-12 col-sm-2 border-top">Totals: $${price - discount * price
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
  } else {
    Server.get(`action=product&id=${id}`)
      .then((res, req) => {
        $("#items").html(`<div class="row ">
        <div class="col-3 p-2" style="line-height: 100%;">${res.title}</div>
        <div class="col-3"><img width="50%" src="${res.img}" alt=""></div>
        <div class="col-3 p-2">${res.discount > 0
            ? `         <sub style="text-decoration:line-through">${res.price
            }</sub>$ ${res.price - res.price * res.discount}`
            : res.price > 0
              ? `$ ${res.price}`
              : "Free"
          }</div>
      
    </div>         `);
        $("#payment").html(`  <div class="row">
    <div class="col-md-12 col-sm-2 text-center h2">Items:1</div>
    <div class="col-md-12 col-sm-2 border-top" value="${res.price}">Price:$${res.price
          }</div>
    <div class="col-md-12 col-sm-2 "value="${res.discount}">Discount: $${res.discount * res.price
          }</div>
    <div class="col-md-12 col-sm-2 border-top">Totals: $${res.price - res.discount * res.price
          }</div>
    <div class="col-md-12 col-sm-2">
        <div class="row">
            <div class="col-6"><a class="btn btn-outline-info" href="index.php?action=shop">Back to shop</a> </div>
            <div class="col-6"> <button class="btn btn-danger" onclick="pay(this) ">Payment</button> </div>
        </div>
    </div>
</div>`);
      })
      .catch((xhr, status, err) => { });
  }
}
function pay(e) {
  $(e).html(`<div class="spinner-border text-white"></div>`);
  let Server = new server();
  let url = window.location.href;
  if (url.search("id") == -1) {
    Server.post("action=payment", "")
      .then((res, req) => {
        if (res.status == "success") {
          Swal.fire({
            icon: "success",
            title: "Your work has been saved",
            showConfirmButton: false,
            timer: 2000,
          }).then(() => {
            window.location.replace(`index.php?action=user&function=Order-History&id=${res.orderId}`);
          });
        } else {
          Swal.fire({
            title: "Do you want to top up more money?",
            text: "Your account balance is not enough!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes,I want!",
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.replace("index.php?action=recharge");
            }
          });
        }
      })
      .catch((xhr, status, err) => { })
      .finally(() => {
        $(e).text(`Payment`);
      });
  } else {
    let formData = new FormData();

    formData.append("id", url.split("id=")[1]);
    formData.append(
      "price",
      parseFloat($("#payment > div > div:nth-child(2)").attr("value"))
    );

    formData.append(
      "discount",
      parseFloat($("#payment > div > div:nth-child(3)").attr("value"))
    );
    Server.post("action=payment", formData)
      .then((res, req) => {
        if (res.status == "success") {
          Swal.fire({
            icon: "success",
            title: "Your work has been saved",
            showConfirmButton: false,
            timer: 2000,
          }).then(() => {
            window.location.replace(`index.php?action=user&function=Order-History&id=${res.orderId}`);
          });
        } else {
          Swal.fire({
            title: "Do you want to top up more money?",
            text: "Your account balance is not enough!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes,I want!",
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.replace("index.php?action=recharge");
            }
          });
        }
      })
      .catch((xhr, status, err) => {
        console.log(xhr, status, err);
      })
      .finally(() => {
        $(e).text(`Payment`);
      });
  }
}
$(document).ready(function () {
  userInfo();
  view();
});
