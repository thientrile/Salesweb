// function is called when the website is loaded.It's loads
function loadCart() {
  $("#cart").html(`<div class="spinner-border text-info"></div>`);
  $.ajax({
    url: `server.php?action=cart`,
    type: "GET",
    dataType: "json",
    success: function (data) {
      if (data.length > 0) {
        let items = "";
        for (let i of data) {
          items += ` <div class="row bg-white shadow-lg m-2 p-2 rounded bg-white">
                <div class="col-3 p-2" style="line-height: 100%;">${
                  i.title
                }</div>
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
                <div class="col-3 p-2 "> <button cartId="${
                  i.id
                }" class="btn btn-danger m-auto cartDel" onclick="cartDel(this)">Delete</button> </div>
            </div>         `;
        }

        $("#cart").append(items);
      } else {
        $("#cart").text("Your cart is empty.");
        $("#cart").css({ background: "white", "min-height": "150px" });
        $("#cart").addClass("shadow-lg p-2");
      }
    },
    error: function (xhr, status, error) {
      // handle errors
      //   console.log(error);
      $("#cart").text("Your cart is empty.");
      $("#cart").css({ background: "white", "min-height": "150px" });
      $("#cart").addClass("shadow-lg p-2");
    },
    complete: function () {},
  });
}
function cartDel(e) {
  $(e).html(`<div class="spinner-border text-white"></div>`);
  console.log();
  $.ajax({
    url: `server.php?action=cart&id=${$(e).attr("cartId")}`,
    type: "DELETE",
    success: function (data) {
      loadCart();
    },
  });
}
$(document).ready(function () {
  loadCart();
});
