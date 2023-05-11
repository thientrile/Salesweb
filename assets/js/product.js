function loads() {
  let Server = new server();
  Server.get("action=product")
    .then((res, req) => {
      console.log(res);
      let view = "";
      for (let i of res) {
        view += `
          <tr>
                <td scope="row">${i.id}</td>
                <td scope="row">${i.title}</td>
                <td scope="row"> <img style="width:20%" src="assets/products/${
                  i.id
                }/img/${i.img}"> </td>
                <td scope="row">${i.name}</td>
                <td scope="row">${i.discount * 100}%</td>
                <td scope="row">$${i.price}</td>
                <td scope="row"> <button onclick="load(${
                  i.id
                })" class="btn btn-success"data-bs-toggle="modal" data-bs-target="#myModal">Update</button> </td>
                <td scope="row"> <button class="btn btn-danger">Delete</button> </td>




            </tr>
        `;
      }
      $("#product").html(view);
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}
function load(id) {
  let Server = new server();
  $(".modal-title").text("Update Product");

  Server.get(`action=product&function=category`)
    .then((res, req) => {
      let view = "";
      res.forEach((i) => {
        view += `<option value="${i.id}">${i.name}</option>`;
      });
      $("#category").html(view);
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
  Server.get(`action=product&id=${id}`)
    .then((res, req) => {
      $("#title").val(res.title);
      $("#id").val(res.id);
      $("#category option")
        .filter(function () {
          return this.value == res.category_id;
        })
        .attr("selected", "true");
      $("#price").val(res.price);
      $("#discount").val(res.discount);
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}
$(function () {
  loads();
});
