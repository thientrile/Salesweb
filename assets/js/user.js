function userInfo() {
  $(
    "#profile > div > div.col-md-9.border-right.shadow-lg > div > div.mt-5.text-center > button"
  ).hide();
  let Server = new server();
  Server.get("action=user")
    .then((res, req) => {
      $(
        "#profile > div > div.col-md-3.border-right.shadow-lg > div > span.font-weight-bold"
      ).text(res.fullname);
      $(
        "#profile > div > div.col-md-3.border-right.shadow-lg > div > img"
      ).attr("src", `./assets/user/${res.id}/avatar/${res.avatar}`);
      $("#myfile").attr("userId", res.id);
      $(
        "#profile > div > div.col-md-3.border-right.shadow-lg > div > span.text-black-50"
      ).text(res.email);

      $(
        "#profile > div > div.col-md-9.border-right.shadow-lg > div > div.row.mt-2 > div > input"
      ).val(res.fullname);
      $(
        "#profile > div > div.col-md-9.border-right.shadow-lg > div > div.row.mt-3 > div:nth-child(1) > input"
      ).val(res.phone_number);
      $(
        "#profile > div > div.col-md-9.border-right.shadow-lg > div > div.row.mt-3 > div:nth-child(2) > input"
      ).val(res.address);
      $("#info input").on("input", () => {
        $(
          "#profile > div > div.col-md-9.border-right.shadow-lg > div > div.mt-5.text-center > button"
        ).show();
      });
    })
    .catch((xhr, status, err) => {
      console.log(xhr, status, err);
    });
}
$(document).ready(() => {
  userInfo();
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
    userInfo();
   
  });
});
