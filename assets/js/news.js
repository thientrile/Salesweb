// var totalPages = 1;
// var currentPages = 1;


function navigateToPage(page) {
  currentPages = page;
  views();
  createPagination(page, totalPages);
  // Thực hiện các tác vụ cần thiết khi chuyển đến trang mới
  // ở đây, bạn có thể gọi hàm tải dữ liệu mới, v.v.

  // Gọi lại hàm tạo điều hướng phân trang với trang hiện tại mới
}

function inputImage(input) {
  let file = input.files;
  // $(".img-prev").text(file[0].name)

  let reader = new FileReader();
  reader.readAsDataURL(file[0]);
  reader.addEventListener("load", function (e) {
    $("#img-prev").attr("src", reader.result);
  });
}
function loadcate(id = 0) {
  let Server = new server();
  Server.get("action=blog&function=cate")
    .then((res, req) => {
      let options = "";
      let managenment = "";
      for (let i of res.data) {
        options += `<option value="${i.id}"${i.id == id ? "selected" : ""}>${i.id != 0 ? i.name : "--Select--"
          }</option>`;
        managenment += i.id == 0 ? "" : `<tr>
          
          <td>${i.name}</td>
          <td><button type="button" class="btn" onclick=" hiddenCate(${i.id}) ">${i.hidden == 0 ? `<i class="fa-solid fa-eye"></i>` : `<i class="fa-solid fa-eye-slash"></i>`}</button></td>
         <td><button type="button" class="btn btn-outline-danger" onclick="delCate(${i.id})">Deleted</button></td>
          
        </tr>`;
      }
      $("#cate-management").html(managenment);
      $("#category").html(options);
      $("#cate").html(options);
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}
function createNews() {
  $("#title").val("");
  $("#img-prev").attr({ src: "" });
  tinymce.get("content").setContent("");
  $("#form-data").attr({ onsubmit: "insertNews(event)" });
  $("#function").text("Insert");
  $("#img").prop({ required: "true" }).val("");
  $("#reset").attr({ onclick: ` createNews()` });
}
function insertNews(e) {
  e.preventDefault();

  let data = new FormData();
  data.append("title", $("#title").val());
  data.append("avatar", $("#img-prev").attr("src"));
  data.append("cateNews", $("#category").val());
  data.append("content", tinymce.get("content").getContent());
  let Server = new server();
  Server.post("action=admin&function=news", data)
    .then((res, req) => {
      views();
      createNews();
    })
    .catch((xhr, status, error) => {
      console.log(xhr.responseText, status, error);
    });
}
function addCate() {
  let Server = new server();
  let formdata = new FormData();
  formdata.append("name", $("#cate-news").val());
  Server.post("action=admin&function=news&type=category", formdata)
    .then((res, req) => {
      console.log(res);
      $("#newCate").remove();
      $("#flexCheckDefault").prop("checked", false);
      loadcate();
    })
    .catch((rhx, status, error) => {
      console.log(rhx.responseText, status, error);
    });
}
function showAddCate(element) {
  if ($(element).is(":checked")) {
    $("#Newscate").append(`<div class="form-floating mb-3" id="newCate">
    <input type="text" class="form-control" id="cate-news" required>
    <label for="cate-news">New news category name</label>
    <div class="invalid-feedback">
                                Please enter a valid image of the category.
                            </div>
    <button onclick="addCate()" class="btn btn-outline-indigo"> Add new category</button>

</div>`);
  } else {
    $("#newCate").remove();
  }
}
function arrow(element, id, arrow) {

  let Server = new server()
  let data = new FormData();
  data.append("arrow", arrow);
  Server.post(`action=admin&function=news&type=arrow&id=${id}`, data).then((res, req) => {
    views();
  }).catch((xhr, status, error) => {
    console.log(xhr, status, error);
  })

}
function views() {
  let Server = new server();
  Server.get(
    `action=admin&function=news&keySearch=${$("#search").val()}&cate=${$(
      "#cate"
    ).val()}&page=${currentPages}`
  )
    .then((res, req) => {
      let result = "";
      if (res.page > 1) {
        totalPages = res.page;
        createPagination(currentPages, totalPages);
      }

      for (let i of res.data) {
        result += ` <tr>
        <td>NEWS${i.id}</td>
        <td>${i.title}</td>
        <td><img style="width:10rem" src="${i.avatar}"></td>
        <td >
           ${i.name}
        </td>
        <td>${i.fullname}</td>
        <td>${i.created_at}</td>
        <td><button class="btn ${i.hidden == 0 ? "btn-light-danger" : "btn-outline-light-danger"
          } btn-light-danger" onclick="Hidden(this,${i.id})">${i.hidden == 0 ? "Show" : "Hidden"
          }</button> </td>
        <td ><div class="btn-group-vertical">
                <button type="button" class="btn btn-outline-muted mb-2 btn-sm" onclick="arrow(this,${i.id},1)"><i class="fa-solid fa-arrow-up"></i></button>
                <button type="button" class="btn btn-outline-muted btn-sm"onclick="arrow(this,${i.id},-1)"><i class="fa-solid fa-arrow-up fa-rotate-180"></i></button>
              
              </div></td>
        <td> <button class="btn btn-danger-light" onclick="view(${i.id
          }) " data-bs-toggle="modal" data-bs-target="#myModal">Edit</button> </td>
        <td> <button class="btn btn-danger" onclick="del(this,${i.id
          })">Deleted</button> </td>


    </tr>`;
      }
      $("#news").html(result);
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}
function view(id) {
  let Server = new server();
  $("#img").removeAttr("required");

  Server.get(`action=blog&function=views&id=${id}`)
    .then((res, req) => {
      $("#title").val(res.title);
      $("#img-prev").attr({ src: res.avatar });
      tinymce.get("content").setContent(res.content);
      $("#form-data").attr({ onsubmit: `UpdateNews(event,${id})` });
      $("#function").text("Update");
      loadcate(res.newsCate_id);
      $("#reset").attr({ onclick: ` view(${id})` });
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}
function UpdateNews(e, id) {
  e.preventDefault();
  let data = new FormData();

  data.append("title", $("#title").val());
  data.append("avatar", $("#img-prev").attr("src"));
  data.append("cateNews", $("#category").val());
  data.append("content", tinymce.get("content").getContent());
  let Server = new server();
  Server.post(`action=admin&function=news&id=${id}`, data)
    .then((res, req) => {
      console.log(res);
      view(id);
      loadcate();
      views();
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}
function del(e, id) {
  $(e).html(`<div class="spinner-border text-light"></div>`);
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  })
    .then((result) => {
      if (result.isConfirmed) {
        let Server = new server();
        Server.delete(`action=admin&function=news&id=${id}`)
          .then((res, req) => {
            Swal.fire({
              icon: "success",
              title: "Deleted!",
              text: "Your file has been deleted.",
              showConfirmButton: false,
              timer: 1000,
            });
            e.parentNode.parentNode.remove();
            views();
            // console.log(res);
          })
          .catch((xhr, status, error) => {
            console.log(xhr, status, error);
          });
      } else {
        $(e).text(`Delete`);
      }
    })
    .catch((error) => {
      console.log(error);
    });
}
function Hidden(e, id) {
  let data = new FormData();

  data.append("id", id);
  let Server = new server();
  Server.post("action=admin&function=news&type=hidden", data)
    .then((res, req) => {
      views();
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}
function hiddenCate(id) {
  let data = new FormData();
  data.append("id", id);
  let Server = new server();
  Server.post("action=admin&function=news&type=hiddenCate", data).then((res, req) => {
    loadcate();
    views();
  }).catch((xhr, status, error) => {
    console.log(xhr);
  })
}
function delCate(id) {
  let data = new FormData();
  let Server = new server();
  Server.delete(`action=admin&function=news&type=cate&id=${id}`, data).then((res, req) => {

    loadcate();
    views();

  }).catch((xhr, status, error) => {
    console.log(xhr.responseText);
  })
}
function managerCate(e, form) {
  e.preventDefault()
  let data = new FormData(form);
  let Server = new server();
  Server.post("action=admin&function=news&type=category", data).then((res, req) => {

    loadcate();
    form.reset();
  }).catch((xhr, status, error) => {
    console.log(xhr);
  })
}
$(function () {
  loadcate();
  views();
  tinymce.init({
    selector: "#content",
    plugins: "save image media",
    height: 700,
    image_title: true,
    media_live_embeds: true,
    image_dimensions: false,
    file_picker_callback: function (callback, value, meta) {
      if (meta.filetype === "image") {
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

  $("#function").click(() => {
    let form = document.getElementById("form-data");

    if (!form.checkValidity()) {
      form.classList.add("was-validated");
    } else {
      form.classList.remove("was-validated");
    }
  });
});
