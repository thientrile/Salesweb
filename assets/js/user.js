function userInfo() {
  $("#upload").hide();
  let Server = new server();
  Server.get("action=user")
    .then((res, req) => {
      $(
        "#profile > div > div.col-lg-3.border-right.shadow-lg > div > span.font-weight-bold"
      ).text(res.fullname);
      $(
        "#profile > div > div.col-lg-3.border-right.shadow-lg > div > img"
      ).attr({
        src: `./assets/user/${res.id}/avatar/${res.avatar}`,
        alt: res.avatar,
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
    })
    .catch((xhr, status, err) => {
      console.log(xhr, status, err);
    });
}
function loadOrders() {
  let Server = new server();
  Server.get("action=payment&function=order")
    .then((res, req) => {
      console.log(res);
    })
    .catch((xhr, status, err) => {
      console.log(xhr);
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
$(document).ready(() => {
  userInfo();
  loadOrder();
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
  $("#info").submit((e) => {
    e.preventDefault();

    let dataForm = new FormData();
    let id = $("#myfile").attr("userId");
    let name = $("#info > div > div.row.mt-2 > div > input").val();
    let address = $(
      "#info > div > div.row.mt-3 > div:nth-child(2) > input"
    ).val();
    let phone = $(
      "#info > div > div.row.mt-3 > div:nth-child(1) > input"
    ).val();

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
  });
});
