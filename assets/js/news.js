function inputImage(input) {
  let file = input.files;
  // $(".img-prev").text(file[0].name)

  let reader = new FileReader();
  reader.readAsDataURL(file[0]);
  reader.addEventListener("load", function (e) {
    $("#img-prev").attr("src", reader.result);
  });
}
function loadcate(id = 1) {
  let Server = new server();
  Server.get("action=admin&function=cate_news").then((res, req) => {
    let options = "";
    for (let i of res.data) {
      options += `<option value="${i.id}"${i.id == id ? checked : ""}>${
        i.name
      }</option>`;
    }
    $("#category").html(options);
  });
}
function createNews() {
  $("#title").val("");
  $("#img-prev").attr({ src: "" });
  tinymce.get("content").setContent();
  $("#form-data").attr({ onsubmit: "insertNews(event)" });
}
function insertNews(e) {
  e.preventDefault();

  let data = new FormData();
  data.append("title", $("#title").val());
  data.append("avatar", $("#img-prev").attr("src"));
  // data.append("avatar", "t");
  data.append("cateNews", $("#category").val());
  data.append("content", tinymce.get("content").getContent());
  let Server = new server();
  Server.post("action=admin&function=insert_news", data)
    .then((res, req) => {
      console.log(res);
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}
function addCate() {
  let Server = new server();
  let formdata = new FormData();
  formdata.append("name", $("#cate-news").val());
  Server.post("action=admin&function=cate_news", formdata)
    .then((res, req) => {
      console.log(res);
      $("#newCate").remove();
      $("#flexCheckDefault").prop("checked", false);
      loadcate();
    })
    .catch((rhx, status, error) => {
      console.log(rhx, status, error);
    });
}
function showAddCate(element) {
  if ($(element).is(":checked")) {
    console.log(true);
    $("#Newscate").append(`<div class="form-floating mb-3" id="newCate">
    <input type="text" class="form-control" id="cate-news">
    <label for="cate-news">New news category name</label>
    <button onclick="addCate()" class="btn btn-outline-indigo"> Add new category</button>

</div>`);
  } else {
    $("#newCate").remove();
  }
}
$(function () {
  loadcate();

  tinymce.init({
    selector: "#content",
    plugins: "save image media",

    height: 700,
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
        input.setAttribute("accept", "video/mp4");
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
    setup: function (editor) {
      editor.on("init", function () {
        // Ẩn logo TinyMCE
        $("div.tox-statusbar__text-container > span > a > svg > path").css(
          "display",
          "none"
        );
      });
    },
  });
});
