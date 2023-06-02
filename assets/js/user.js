var fullname = "";
var address = "";
var phone = "";
var email = "";
function userInfo() {
  $("#upload").hide();
  let Server = new server();
  Server.get("action=user")
    .then((res, req) => {
      fullname = res.fullname;
      address = res.address;
      phone = res.phone_number;
      email = res.email;
      $(
        "#profile > div > div.col-lg-3.border-right.shadow-lg > div > span.font-weight-bold"
      ).text(res.fullname);
      $(
        "#image-Avatar"
      ).attr({
        "src": res.avatar,
        "alt": res.avatar,
      });
      $("#myfile").attr("userId", res.id);
      $(
        "#profile > div > div.col-lg-3.border-right.shadow-lg > div > span.text-black-50"
      ).text(res.email);

      $("#info > div > div.row.mt-2 > div > input").val(res.fullname);
      $("#info > div > div.row.mt-3 > div:nth-child(1) > input").val(
        res.phone_number
      );
      $("#info > div > div.row.mt-3 > div:nth-child(2) > input").val(
        res.address
      );
      $("#info input").on("input", () => {
        $("#upload").show();
      });
      $("#myfile").val("");
      if (res.role_id != 2) {
        $("#admin").show();
      }
    })
    .catch((xhr, status, err) => {
      console.log(xhr, status, err);
    });
}
function loadOrders() {
  let Server = new server();
  Server.get("action=payment&function=order")
    .then((res, req) => {
      if (res.data.length > 0) {
        let result = "";
        for (let i of res.data) {
          let created = new Date(i.date_order);
          let currentDate = new Date();
          let timeDiff = currentDate - created;

          // Convert milliseconds to days
          let daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
          if (daysDiff === 0) {
            created = "Today";
          }
          // Check if it's yesterday
          else if (daysDiff === 1) {
            created = "Yesterday";
          }
          // It's neither today nor yesterday, so print the original date
          else {
            created = created.toDateString();
          }
          result += ` <tr>
          <td>#DG-${i.id}</td>
          <td>$${i.total}</td>
          <td >${created}</td>
          <td><button id="DG-${i.id}" type="button" class="btn" data-bs-toggle="modal" data-bs-target="#myModal" onclick="loadOrder(${i.id},'${i.date_order}')">
                  <i class="fas fa-info me-2"></i> Get information
              </button></td>
      </tr>`;
        }
        $("#order").html(result);
      } else {
        $("#Order-History").hide();
        $("#body > div.creative > div > ul > li:nth-child(2) > a").hide();
        $("#myModal").hide();
      }
    })
    .catch((xhr, status, err) => {
      console.log(xhr, status, err);
    }).finally(() => {
      if (window.location.href.search("&id=") != -1) {
        let id = window.location.href.split("&id=")[1];
        let element = document.getElementById(`DG-${id}`);
        element.onclick();
        let openModal = new bootstrap.Modal(document.getElementById("myModal"))
        openModal.show();
      }
    });
  if (window.location.href.search("function") != -1) {
    let a = document.querySelectorAll("#body > div.creative > div > ul > li > a")
    a.forEach((e) => {
      if (e.getAttribute("href").split("#")[1] == window.location.href.split("function=")[1].split("&")[0]) {
        $(e).addClass("active")
        $(`${e.getAttribute("href")}`).addClass("active")
        $(`${e.getAttribute("href")}`).removeClass("fade")
      }
      else {
        $(e).removeClass("active")

        $(`#${e.getAttribute("href").split("#")[1]}`).addClass("fade")
        $(`#${e.getAttribute("href").split("#")[1]}`).removeClass("active")
      }
    })




  }


}
function loadOrder(id, created) {
  let date = new Date(created);
  date = date.toUTCString();

  $(".id").text(`ID: #DG${id}`);
  $(".fullname").text(fullname);
  $(".created").text(date);
  $(".address").text(address);
  $(".phone").text(phone);
  let Server = new server();
  let price = 0;
  let discount = 0;
  let result = "";
  Server.get(`action=payment&function=order&id=${id}`)
    .then((res, req) => {
      for (let i of res) {
        $("#export").attr({ "onclick": `exportpdf('#DG-${i.id}')` })
        price += i.price;
        discount += i.discount;
        result += ` <tr>
        <td scope="col">#DG${i.id}</td>
        <td scope="col">${i.title}</td>
        <td scope="col">$${i.discount * i.price}</td>
        <td scope="col">$${i.price}</td>
        <td scope="col">$${i.price - i.price * i.discount}</td>
    </tr>`;
      }
      $("#detail").html(result);
      $(".price").html(
        `<span class="text-black me-4">SubTotal</span>$${price}`
      );
      $(".discount").html(
        `<span class="text-black me-4 discount">Tax(${discount * 100
        }%)</span>$${price * discount}`
      );
      $(".total").html(
        `<span class="text-black me-3"> Total Amount</span><span style="font-size: 25px;">$${price - price * discount
        }</span>`
      );
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}

function logout() {
  Swal.fire({
    title: "Do you want to logout?",

    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Log out!",
  }).then((result) => {
    if (result.isConfirmed) {
      document.cookie =
        "c_user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      Swal.fire({
        icon: "success",
        title: "Your account has been logged out",
        showConfirmButton: false,
        timer: 1500,
      }).then(() => {
        window.location.replace("index.php");
      });
    }
  });
}
function update(e) {
  e.preventDefault();

  let dataForm = new FormData();
  let id = $("#myfile").attr("userId");
  let name = $("#info > div > div.row.mt-2 > div > input").val();
  let address = $(
    "#info > div > div.row.mt-3 > div:nth-child(2) > input"
  ).val();
  let phone = $("#info > div > div.row.mt-3 > div:nth-child(1) > input").val();

  dataForm.append("id", id);
  dataForm.append("name", name);
  dataForm.append("address", address);
  dataForm.append("phone", phone);
  let Server = new server();
  Server.post("action=user&function=Upload", dataForm)
    .then((res, req) => {
      Swal.fire({
        icon: "success",
        title: "Your information has been updated successfully",
        showConfirmButton: false,
        timer: 500,
      }).then((res) => {
        userInfo();
      });
    })
    .catch((xhr, stauts, error) => {
      console.log(xhr, stauts, error);
    });
}

function exportpdf(name) {

  // Tạo một instance của jsPDF
  let doc = new jsPDF();

  // Lấy ra phần tử cần in vào file PDF
  let element = document.getElementById("myModal");

  // Lấy nội dung HTML của phần tử
  let htmlContent = element.innerHTML;

  // Chuyển đổi nội dung HTML thành PDF và in vào file
  doc.fromHTML(htmlContent, 15, 15, {
    width: 170
  });

  // Tải về file PDF
  doc.save(`invoid-${name}.pdf`);

}
function printHtml() {
  let element = document.getElementById("myModal");
  let printWindow = window.open('', '', 'width=600,height=600');
  printWindow.document.write(element.innerHTML);
  printWindow.document.close();
  printWindow.onload = function () {
    // Thực hiện lệnh in của trình duyệt
    printWindow.print();
  };
}
$(document).ready(() => {
  userInfo();
  loadOrders();
  $("#myfile").on("input", (e) => {
    const selectedFile = event.target.files[0];
    const reader = new FileReader();
    reader.addEventListener("load", () => {
      $(
        "#profile > div > div.col-md-3.border-right.shadow-lg > div > img"
      ).attr("src", reader.result);
    });
    reader.readAsDataURL(selectedFile);
    let Server = new server();
    $("#myfile").attr("userId");
    let formData = new FormData();
    formData.append("id", $("#myfile").attr("userId"));
    formData.append("File_avatar", $("#myfile")[0].files[0]);
    Server.post(`action=user&function=avatar`, formData)
      .then((res, req) => {
        userInfo();
      })
      .catch((xhr, status, error) => {
        console.log(false);
      });
  });
  $("#upload").click((e) => {
    $("#info").submit();
  });
  $("#body > div.creative > div > ul > li > a").click((e) => {
    window.history.replaceState(
      {},
      "",
      "index.php?action=user&function=" +
      e.target.getAttribute("href").split("#")[1]
    );




  })
})
