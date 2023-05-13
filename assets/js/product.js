var arrGallery = [];
function loads() {
  let Server = new server();
  Server.get(
    `action=product&keySearch=${$("#search").val()}&cate=${$("#cate").val()}`
  )
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
                })" class="btn btn-success"data-bs-toggle="modal" data-bs-target="#myModal">Edit</button> </td>
                <td scope="row"> <button onclick="del(this,${
                  i.id
                })" class="btn btn-danger">Delete</button> </td>




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
function getCate() {
  let Server = new server();
  Server.get(`action=product&function=category`)
    .then((res, req) => {
      view = "";
      res.forEach((i) => {
        view += `<option value="${i.id}">${i.name}</option>`;
      });
      $("#cate").append(view);
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}
function load(id) {
  arrGallery = [];
  loadGallery(id);
  $("#reset").attr({ onclick: `load(${id})` });
  $("#form-data").attr({ onsubmit: "update(event)" });
  $("#function").text("Update");
  let Server = new server();
  $(".modal-title").text("Edit Product");

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
      $("#img-prev").attr({
        src: `assets/products/${res.id}/img/${res.img}`,
        alt: res.img,
      });
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}
function loadGallery(id) {
  let Server = new server();
  Server.get(`action=product&id=${id}&function=gallery`)
    .then((res, req) => {
      let view = "";
      res.forEach((i) => {
        switch (getFileType(i.thumnali)) {
          case "audio": {
            view += `
            <div class=" toast show col-md-4">
  <div class="toast-header">
 
    <button onclick="delGallery(${i.id})" type="button" class="btn-close" data-bs-dismiss="toast"></button>
  </div>
  <div class="toast-body">
    
    <audio  class="card-img-top" src="assets/products/${id}/gallery/${i.thumnali}" controls>
    
    
    </audio>
  </div>
</div>
           
          `;
            break;
          }
          case "video": {
            view += `
            
            <div class="toast show col-md-4">
            <div class="toast-header">
           
              <button onclick="delGallery(${i.id})" type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
            <video class="card-img-top" controls>
            <source  src="assets/products/${id}/gallery/${i.thumnali}" type="video/mp4">
           
         
          </video>
            </div>
          </div>
            `;
            break;
          }
          default: {
            view += `
            
            
            <div class=" toast show col-md-4">
            <div class="toast-header">
           
              <button onclick="delGallery(${i.id})" type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
              
              <img   class="card-img-top" src="assets/products/${id}/gallery/${i.thumnali}"width="100%" style="object-fit: cover;max-height:320px">
            </div>
          </div>
           `;
          }
        }
        $("#gallery-prev").html(view);
      });
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}
function getFileType(filename) {
  if (
    filename.endsWith(".mp3") ||
    filename.endsWith(".wav") ||
    filename.endsWith(".ogg")
  ) {
    return "audio";
  } else if (
    filename.endsWith(".mp4") ||
    filename.endsWith(".mov") ||
    filename.endsWith(".avi")
  ) {
    return "video";
  } else if (
    filename.endsWith(".jpg") ||
    filename.endsWith(".jpeg") ||
    filename.endsWith(".png") ||
    filename.endsWith(".gif")
  ) {
    return "image";
  }
}
function inputSrc(input) {
  let file = input.files;
  $(".src").text(file[0].name);
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
function inputGallery(input) {
  let files = input.files;
  let index = arrGallery.length > 0 ? arrGallery.length : 0;
  for (let i of files) {
    arrGallery.push(i);
    let reader = new FileReader();
    reader.readAsDataURL(i);
    reader.addEventListener("load", function (e) {
      let view = "";
      switch (getFileType(i.name)) {
        case "audio": {
          view = `
          
          <div class=" toast show col-md-4">
          <div class="toast-header">
         
            <button onclick="delimage(${index})" type="button" class="btn-close" data-bs-dismiss="toast"></button>
          </div>
          <div class="toast-body">
            
            <audio controls width="100%">
            
            <source src="${reader.result}" type="audio/mp3">
            
            </audio>
          </div>
        </div>
          `;
          break;
        }
        case "video": {
          view = `<
        <div class=" toast show col-md-4">
        <div class="toast-header">
       
          <button onclick="delimage(${index})" type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
        <video class="card-img-top" controls>
        <source src="${reader.result}" type="video/mp4">
       
     
      </video>
        </div>
      </div>
        `;
          break;
        }
        default: {
          view = `
            <div class=" toast show col-md-4">
            <div class="toast-header">
           
              <button onclick="delimage(${index})" type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
              
              <img src="${reader.result}"width="100%" style="object-fit: cover;max-height:320px">
            </div>
          </div>
            
            `;
        }
      }
      $("#gallery-prev").append(view);
      index++;
    });
  }
}
function delGallery(id) {
  let Server = new server();
  Server.delete(`action=admin&function=gallery&id=${id}`)
    .then((res, req) => {
      console.log(res);
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}
function delimage(index) {
  arrGallery.splice(index, 1);
}
function update(e) {
  e.preventDefault();
  let formData = new FormData();
  let id = $("#id").val();
  formData.append("title", $("#title").val());
  formData.append("img", $("#img").prop("files")[0]);
  formData.append("src", $("#src").prop("files")[0]);
  formData.append("type", $("#category").val());
  formData.append("desc", tinymce.get("desc").getContent());
  console.log(tinymce.get("desc").getContent());
  formData.append("sdesc", tinymce.get("sdesc").getContent());
  formData.append("discount", $("#discount").val());
  formData.append("price", $("#price").val());
  if (arrGallery.length > 0) {
    arrGallery.forEach((file) => {
      formData.append("gallery[]", file);
    });
  } else {
    formData.append("gallery[]", $("#gallery").prop("files")[0]);
  }
  let Server = new server();
  Server.post(`action=admin&function=Editproduct&id=${id}`, formData)
    .then((res, req) => {
      load(id);
      loads();
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
  }).then((result) => {
    if (result.isConfirmed) {
      let Server = new server();
      Server.delete(`action=admin&function=product&id=${id}`)
        .then((res, req) => {
          Swal.fire({
            icon: "success",
            title: "Deleted!",
            text: "Your file has been deleted.",
            showConfirmButton: false,
            timer: 1000,
          });
          e.parentNode.parentNode.remove();
        })
        .catch((xhr, status, error) => {
          console.log(xhr, status, error);
        })
        .finailly(() => {});
    } else {
      $(e).text(`Delete`);
    }
  });
}
function addNew(e) {
  e.preventDefault();
}

function Reset() {
  arrGallery = [];
  $("#form-data").attr({ onsubmit: "addNew(event)" });
  $("#title").val("");
  $("#id").val("");
  $("#function").text("Add new");
  $("#price").val("");
  $("#discount").val("");
  $(".src").text("");
  tinymce.get("sdesc").setContent("");
  tinymce.get("desc").setContent("");
  $("#img-prev").attr({
    src: "",
    alt: "",
  });
  $("#gallery-prev").html("");
  $("#reset").attr({ onclick: "Reset()" });
  let Server = new server();
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
}
$(function () {
  getCate();
  loads();
  tinymce.init({
    selector: "#sdesc",
    height: 430,
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
    $("#form-data").submit();
  });
});
