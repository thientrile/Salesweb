function multipleVar() {

  if ($('#multiple').is(':checked')) {
    $("#keys").html(`  <div class="mt-3">
    <div class="row">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text">Enter variant name</span>
                <input type="text" class="form-control"id="" >
            </div>
        </div>
       
        <div class="col-md-4"> <button type="button" class="btn btn-outline-success" onclick="addVarName()">Add variant name</button></div>
    </div>
    
</div>`);

    $("#Option").html('');

  } else {
    $("#var").html("")
    $("#keys").html(``);

    $("#Option").html(`<div class="row">    
      <button type="button" class="btn-close" onclick="this.parentNode.remove()"></button>
    <div class="row mt-3">  
      <div class="col-md-6">
          <div class="input-group">
              <span class="input-group-text">Price</span>
              <input type="text"name="price[]" required value="0"  class="form-control">
              <div class="invalid-feedback">
                  Please enter a valid price.
              </div>
          </div>
      </div>
      <div class="col-md-6">
          <div class="border border-1 p-2 rounded-2">
              <label class="btn btn-info" for="src">Choose source</label>
              <input class="form-control" type="file" name="src[]" id="src" class="form-control" onchange="inputSrc(this,'src-1')" style="display:none" required>
              <span class="src"id="src-1"></span>
              <div class="invalid-feedback">
                  Please enter a valid source of the product.
              </div>
          </div>  
      </div>
    </div>`)



  }
}

var variables = [];

function delProductItem(element, id) {
  element.parentNode.remove()
  const Server = new server();
  Server.delete(`action=admin&function=product&type=productItem&id=${id}`).then((res, req) => {
    console.log(res);
  }).catch((xhr, status, error) => {
    console.log(xhr);
  })
}
function addVarName() {

  let name = $("#keys > div > div > div:nth-child(1) > div > input").val().trim() != '' ? $("#keys > div > div > div:nth-child(1) > div > input").val().trim().split(",") : '';

  if (name != '') {
    $("#var").html(`<div class="col-6" id="variables">

    </div>
    <div class="col-3">
    <button type="button" class="btn btn-primary" onclick=" createVariables()">Create variation</button>
    </div>
   `)
    let index = 0;

    for (let i of name) {
      $("#variables").append(`
        <div class="input-group mt-3">        
        <span class="input-group-text variables-name">Attribute ${index}</span>
        <span class="input-group-text variables-name">${i}</span>
        <input type="text" class="form-control variables-val" placeholder="Value">
        <button type="button" class="btn-close" onclick="delVarialbe(this)"></button>
      </div>
      `)
      index++;
    }

  }

  else {
    $("#var").html(`
    `)
  }




}
function editVariable(element, index, variable) {


  if (delete variables[index][variable.trim()]) {
    if (Object.keys(variables[index]).length == 0) {
      variables.splice(index, 1)
      element.parentNode.parentNode.parentNode.remove()
    }
    element.parentNode.remove();

  }

}
function delOption(index) {
  variables.splice(index, 1)
  loadVariables()
}
function loadVariables() {
  let Option = '';
  let index = 0
  for (let i of variables) {
    let keys = [];
    let values = '';
    let id = Math.floor(Math.random() * 1000) + Date.now();
    for (let key of Object.keys(i)) {

      keys.push(key);

      values += `
          <span  class="btn btn-primary">
      ${i[key]} <button  type="button " onclick="editVariable(this,${index},'${key}')" class="btn btn-close"></button>
    </span>
          
          
          `;



    }
    Option += `
    <div class="row mt-3">
    <div class="col-md-4">
    
    <span class="badge bg-secondary">${keys.join(" x ")}</span>
    </div>
    <div class="col-md-4">${values}</div>
    <div class="col-md-2">
    
    
  
    <div class="input-group mt-1">
     <span class="input-group-text">Price:</span>
     <input type="text" class="form-control" value="0" name="price[]">
   </div>
    </div>
    <div class="col-md-1">
    <div class="border border-1 p-2 rounded-2">
             <label class="btn btn-info" for="src${id}">Choose source</label>
             <input class="form-control" type="file" name="src[]" id="src${id}" class="form-control" onchange="inputSrc(this,'src-${id}')" style="display:none" required>
             <span class="src"id="src-${id}"></span>
             <div class="invalid-feedback">
                 Please enter a valid source of the product.
             </div>
         </div>  
    
    
    </div>
    <div class="col-md-1 btn-close" onclick="delOption(${index})">
    
    
    </div>
    </div>
    
    `
    index++;
  }
  $("#Option").html(Option)

}

function createVariables() {
  let grouplist = document.querySelectorAll('#variables > div.input-group');
  let array = [];
  let variations = []
  for (let i of grouplist) {
    array.push({ name: i.querySelector('span:nth-child(2)').innerHTML.trim(), value: (i.querySelector('input').value).trim().split(",") })
  }



  // Hàm đệ quy để tạo biến thể
  function generateVariations(currentIndex, currentVariation) {
    if (currentIndex === array.length) {
      // Đã lặp qua tất cả các thuộc tính, thêm biến thể vào mảng kết quả
      variations.push(currentVariation);
      return;
    }

    const attribute = array[currentIndex];
    for (let i = 0; i < attribute.value.length; i++) {
      const value = attribute.value[i];

      // Sao chép biến thể hiện tại và thêm thuộc tính mới
      const newVariation = { ...currentVariation };
      newVariation[attribute.name] = value;

      // Đệ quy để tiếp tục với thuộc tính tiếp theo
      generateVariations(currentIndex + 1, newVariation);
    }
  }

  // Bắt đầu từ biến thể rỗng và chỉ mục 0
  generateVariations(0, {});
  variables = variations
  // In kết quả
  loadVariables()


}




function delVarialbe(element) {
  element.parentNode.remove()
  if ($("#variables").html().trim() == "") {
    $("#var").html(`
    `)
  }
}
function getVariables() {
  for (let i of variables) {
    for (let j of i.data) {
      j.price = $(`#price-${j.id}`).val();
      j.sources = $(`#src-${j.id}`).prop("files")[0];
    }
  }
}

function Hidden(e, id) {
  let text = $(e).text() == "Hidden" ? "Show" : "Hidden";
  let Server = new server();
  let data = new FormData();
  data.append("id", id);
  Server.post("action=admin&function=product&type=hidden", data)
    .then((res, req) => {
      $(e).text(text);
      console.log(res);
    })
    .catch((xhr, stauts, error) => {
      console.log(xhr, stauts, error);
    });
}

var arrGallery = [];


function navigateToPage(page) {
  currentPages = page;
  loads();
  createPagination(page, totalPages);
  // Thực hiện các tác vụ cần thiết khi chuyển đến trang mới
  // ở đây, bạn có thể gọi hàm tải dữ liệu mới, v.v.

  // Gọi lại hàm tạo điều hướng phân trang với trang hiện tại mới
}
// movies rows
function arrow(element, id, arrow) {

  let Server = new server()
  let data = new FormData();
  data.append("arrow", arrow);
  Server.post(`action=admin&function=product&type=arrow&id=${id}`, data).then((res, req) => {
    loads()
  }).catch((xhr, status, error) => {
    console.log(xhr, status, error);
  })
}
// load products from the database
function loads() {
  $("#form-data").removeClass("was-validated");
  let Server = new server();
  Server.get(
    `action=admin&function=product&keySearch=${$("#search").val()}&cate=${$(
      "#cate"
    ).val()}&page=${currentPages}`
  )
    .then((res, req) => {
      let view = "";
      let data = res.data;
      totalPages = res.page;
      createPagination(currentPages, res.page);
      for (let i of data) {
        let price = [];
        for (let j of i.options) {
          price.push(formatCurrency(j.price));
        }
        ;
        view += `      
          <tr>
                <td scope="row">DG${i.id}</td>
                <td scope="row">${i.title}</td>
                <td scope="row"> <img style="width:10rem" src="${i.img}"> </td>
                <td scope="row">${i.name}</td>
                <td scope="row">${i.discount * 100}%</td>
                <td scope="row">${price.join(" ")}</td>
                <td><button  type="button" class="btn btn-light" onclick="Hidden(this,${i.id
          })">${i.hidden == 0 ? "Show" : "Hidden"}</button></td>
                <td ><div class="btn-group-vertical">
                <button type="button" class="btn btn-outline-muted mb-2 btn-sm" onclick="arrow(this,${i.id},1)"><i class="fa-solid fa-arrow-up"></i></button>
                <button type="button" class="btn btn-outline-muted btn-sm"onclick="arrow(this,${i.id},-1)"><i class="fa-solid fa-arrow-up fa-rotate-180"></i></button>
              
              </div></td>
                <td scope="row"> <button onclick="load(${i.id
          })" class="btn btn-success"data-bs-toggle="modal" data-bs-target="#myModal">Edit</button> </td>
                <td scope="row"> <button onclick="del(this,${i.id
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
function getCate(id = 0) {
  let Server = new server();
  Server.get(`action=product&function=category`)
    .then((res, req) => {
      let view = "";
      let cate = "";
      let managenment = "";
      res.forEach((i) => {

        view += `<option value="${i.id}" ${id == i.id ? "selected" : ""}>${i.id == 0 ? "--Select--" : i.name
          }</option>`;
        cate += `<option value="${i.id}" >${i.id == 0 ? "--Select--" : i.name
          }</option>`
        managenment += i.id == 0 ? "" : `<tr>
          
          <td>${i.name}</td>
          <td><button type="button" class="btn" onclick=" hiddenCate(${i.id}) ">${i.hidden == 0 ? `<i class="fa-solid fa-eye"></i>` : `<i class="fa-solid fa-eye-slash"></i>`}</button></td>
         <td><button type="button" class="btn btn-outline-danger" onclick="delCate(${i.id})">Deleted</button></td>
          
        </tr>`;
      });
      $("#cate").html(cate);
      $(".cate").html(cate);
      $("#category").html(view);
      $("#cate-management").html(managenment);
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}

function load(id) {
  $("#var").html(``)
  $("#Option").html(``)
  $("#Option-old").show();
  variables = []
  $("#form-data").removeClass("was-validated");
  $("#gallery").removeAttr("required");
  $("#img").removeAttr("required");
  $("#src").removeAttr("required");
  arrGallery = [];
  loadGallery(id);
  $("#reset").attr({ onclick: `load(${id})` });
  $("#form-data").attr({ onsubmit: "update(event,this)" });
  $("#function").text("Update");
  let Server = new server();
  $(".modal-title").text("Edit Product");
  multipleVar()
  Server.get(`action=admin&function=product&id=${id}`)
    .then((res, req) => {
      $("#title").val(res.title);
      $("#id").val(res.id);
      getCate(res.category_id);
      $("#discount").val(res.discount);
      $("#multiple").prop('checked', res.multiple)
      let options = "";
      let variables = res.options

      variables.forEach((items) => {

        options += `
        
        <div id="var-${items.id}">
       <input type="hidden" name="product-item-id[]" value="${items.id}">
       <button type="button" class="btn-close" onclick="delProductItem(this, ${items.id})"></button>
     ${items.name != '' ? `  
     
     
     <div class="row">
     <div class="col-md-4">
     
         <div class="row">                
             <div class="col-6">
             <span class="badge rounded-pill bg-success"> ${items.name}</span>
           
               
             </div>
             <div class="col-6">
           
             ${items.value}
            
             </div>
         </div>

     </div>

 </div>`: ""}
    <div class="row mt-3">

        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text">Price</span>
                <input type="text" name="priceOld[]" required value="${items.price}" id="price-${items.id}" class="form-control">
                <div class="invalid-feedback">
                    Please enter a valid price.
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="border border-1 p-2 rounded-2">
                <label class="btn btn-info" for="src-${items.id}">Choose source</label>
                <input class="form-control" type="file" name="srcOld[]" id="src-${items.id}" class="form-control" onchange="inputSrc(this,'src-name-${items.id}')" style="display:none">
                <span class="src"id="src-name-${items.id}">${items.sources.substring(items.sources.lastIndexOf("/") + 1)}</span>
                <div class="invalid-feedback">
                    Please enter a valid source of the product.
                </div>
            </div>

        </div>
    </div>
        </div>
        `;

        $("#Option-old").html(options);

      })

      tinymce.get("sdesc").setContent(res.sDescription);
      tinymce.get("desc").setContent(res.description);
      $("#img-prev").attr({
        src: `${res.img}`,
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
    
    <audio  class="card-img-top" src="${i.thumnali}" controls>
    
    
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
            <source  src="${i.thumnali}" type="video/mp4">
           
         
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
              
              <img   class="card-img-top" src="${i.thumnali}"width="100%" style="object-fit: cover;max-height:320px">
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
function inputSrc(input, id) {
  let file = input.files;
  $(`#${id}`).text(file[0].name);
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
  Server.delete(`action=admin&function=product&type=gallery&id=${id}`)
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
function update(e, form) {
  e.preventDefault();
  let formData = new FormData(form);

  let id = $("#id").val();
  formData.append("desc", tinymce.get("desc").getContent());
  formData.append("sdesc", tinymce.get("sdesc").getContent());



  if (arrGallery.length > 0) {
    arrGallery.forEach((file) => {
      formData.append("gallery[]", file);
    });
  } else {
    formData.append("gallery[]", $("#gallery").prop("files")[0]);
  }


  formData.append("multiple", $('#multiple').is(':checked'))

  formData.append("variables", JSON.stringify(variables))
  let Server = new server();
  Server.post(`action=admin&function=product&id=${id}`, formData)
    .then((res, req) => {
      console.log(res);
      // Swal.fire({
      //   position: 'bottom-start',


      //   icon: 'success',
      //   title: 'The product has been successfully added',
      //   showConfirmButton: false,
      //   timer: 1000
      // }).then(() => {

      //   load(id);
      //   loads();
      // })

    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    }).finally(() => {
      $(form).reset
      variables = []
      load(id)
    })
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
            loads()
          })
          .catch((xhr, status, error) => {
            console.log(xhr, status, error);
          })

      } else {
        $(e).text(`Delete`);
      }
    })
    .catch((error) => {
      console.log(error);
    });
}

function addNew(e, form) {
  e.preventDefault();
  let formData = new FormData(form);

  formData.append("variables", JSON.stringify(variables))

  formData.append("desc", tinymce.get("desc").getContent());
  formData.append("sdesc", tinymce.get("sdesc").getContent());
  formData.append("multiple", $('#multiple').is(':checked'))

  if (arrGallery.length > 0) {
    arrGallery.forEach((file) => {
      formData.append("gallery[]", file);
    });
  } else {
    formData.append("gallery[]", $("#gallery").prop("files")[0]);
  }


  $("#form-data > div.modal-header > button").hide();
  $("#function").html(`<div class="spinner-border text-light"></div>`)
  let Server = new server();
  Server.post(`action=admin&function=product`, formData)
    .then((res, req) => {
      console.log(res);
      Swal.fire({
        position: 'bottom-start',
        icon: 'success',
        title: 'The product has been successfully added',
        showConfirmButton: false,
        timer: 1500
      }).then(() => {
        $("#function").text("Add New")
        $("#form-data > div.modal-header > button").show();

        loads();
        Reset();

      })
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}

function Reset() {
  $("#Option-old").hide();
  arrGallery = [];
  getCate()
  variables = [];
  $("#form-data").removeClass("was-validated");
  $("#form-data").attr({ onsubmit: "addNew(event,this)" });
  $("#title").val("");
  $("#id").val("");
  $("#function").text("Add new");
  $("#price").val("0");
  $("#discount").val("0").attr({ required: "true" });
  $(".src").text("");
  $("#Option").html(`<div class="row">
  <button type="button" class="btn-close" onclick="this.parentNode.remove()"></button>
<div class="row mt-3">

  <div class="col-md-6">
      <div class="input-group">
          <span class="input-group-text">Price</span>
          <input type="text"name="price[]" required value="0"  class="form-control">
          <div class="invalid-feedback">
              Please enter a valid price.
          </div>
      </div>
  </div>
  <div class="col-md-6">
      <div class="border border-1 p-2 rounded-2">
          <label class="btn btn-info" for="src">Choose source</label>
          <input class="form-control" type="file" name="src[]" id="src" class="form-control" onchange="inputSrc(this,'src-1')" style="display:none">
          <span class="src"id="src-1"></span>
          <div class="invalid-feedback">
              Please enter a valid source of the product.
          </div>
      </div>

  </div>
</div>`)
  multipleVar()
  tinymce.get("sdesc").setContent("");
  tinymce.get("desc").setContent("");
  $("#img-prev").attr({
    src: "",
    alt: "",
  });
  $("#gallery-prev").html("");
  $("#reset").attr({ onclick: "Reset()" });
  $("#gallery").prop({ required: "true" }).val("");
  $("#img").prop({ required: "true" }).val("");
  $("#src").prop({ required: "true" }).val("");
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
function showAddCate(element) {
  if ($(element).is(":checked")) {
    $("#Newscate").append(`<div class="form-floating mb-3" id="newCate">
    <input type="text" class="form-control" id="new-cate" required>
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
function addCate() {
  let Server = new server();
  let data = new FormData();
  data.append("name", $("#new-cate").val());
  Server.post("action=admin&function=product&type=category", data)
    .then((res, req) => {
      $("#newCate").remove();
      $("#flexCheckDefault").prop("checked", false);
      getCate();
      loads();
    })
    .catch((xhr, status, error) => {
      console.log(xhr, status, error);
    });
}
function managerCate(e, form) {
  e.preventDefault()
  let data = new FormData(form);
  let Server = new server();
  Server.post("action=admin&function=product&type=category", data).then((res, req) => {
    getCate();
    form.reset();
  }).catch((xhr, status, error) => {
    console.log(xhr);
  })
}
function hiddenCate(id) {
  let data = new FormData();
  data.append("id", id);
  let Server = new server();
  Server.post("action=admin&function=product&type=hiddenCate", data).then((res, req) => {
    getCate();
    loads()
  }).catch((xhr, status, error) => {
    console.log(xhr);
  })
}
function delCate(id) {
  let data = new FormData();
  let Server = new server();
  Server.delete(`action=admin&function=product&type=cate&id=${id}`, data).then((res, req) => {

    getCate();
    loads();

  }).catch((xhr, status, error) => {
    console.log(xhr.responseText);
  })
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
