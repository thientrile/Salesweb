function loads() {
  let Server = new server();
  Server.get("action=product")
    .then((res, req) => {
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
      $("#product").html("");
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
      $(".src").text(res.source);
      tinymce.get("sdesc").setContent(res.sDescription);
      tinymce.get("desc").setContent(res.description);
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}
$(function () {
  loads();
  tinymce.init({
    selector: "#sdesc",
    plugins:
      "anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss",
    toolbar:
      "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat",
    tinycomments_mode: "embedded",
    tinycomments_author: "Author name",
    mergetags_list: [
      { value: "First.Name", title: "First Name" },
      { value: "Email", title: "Email" },
    ],
  });
  tinymce.init({
    selector: "#desc",
    plugins: "save image media",

    height: 300,
    image_title: true,
    media_live_embeds: true,
    image_dimensions: false,

    file_picker_callback: function (callback, value, meta) {
      if (meta.filetype === "image") {
        // Mở hộp thoại chọn ảnh
        // Để đơn giản, ví dụ này sử dụng hộp thoại mặc định của trình duyệt
        // Bạn có thể sử dụng thư viện tải lên tệp tin của riêng mình
        var input = document.createElement("input");
        input.setAttribute("type", "file");
        input.setAttribute("accept", "image/*");
        input.onchange = function () {
          var file = this.files[0];
          var reader = new FileReader();
          reader.onload = function () {
            var id = "blobid" + new Date().getTime();
            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
            var base64 = reader.result.split(",")[1];
            var blobInfo = blobCache.create(id, file, base64);
            blobCache.add(blobInfo);
            callback(blobInfo.blobUri(), { title: file.name });
          };
          reader.readAsDataURL(file);
        };
        input.click();
      }
      if (meta.filetype === "media") {
        // Mở hộp thoại chọn video
        // Để đơn giản, ví dụ này sử dụng hộp thoại mặc định của trình duyệt
        // Bạn có thể sử dụng thư viện tải lên tệp tin của riêng mình
        var input = document.createElement("input");
        input.setAttribute("type", "file");
        input.setAttribute("accept", "video/*");
        input.onchange = function () {
          var file = this.files[0];
          var reader = new FileReader();
          reader.onload = function () {
            var id = "blobid" + new Date().getTime();
            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
            var blobInfo = blobCache.create(id, file);
            blobCache.add(blobInfo);
            callback(blobInfo.blobUri(), { title: file.name });
          };
          reader.readAsDataURL(file);
        };
        input.click();
      }
    },
  });
});
