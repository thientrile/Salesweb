var Server = new server();
function inputImage(input) {
    let file = input.files;
    // $(".img-prev").text(file[0].name)

    let reader = new FileReader();
    reader.readAsDataURL(file[0]);
    reader.addEventListener("load", function (e) {
        $("#avatar").attr("src", reader.result);
    });
}
function checkEmail(e) {
    let Server = new server();
    let data = new FormData();
    data.append("email", e.value);
    Server.post("action=checkvalid&function=email", data)
        .then((res, rep) => {
            if (res.status) {
                e.setCustomValidity("This email already exists");
                e.reportValidity();
            } else {
                e.setCustomValidity("");
                e.reportValidity();
            }
        })
        .catch((xhr, status, error) => {
            console.log(xhr.responseText, status, error);
        });
}
function checkpswd(e) {
    const lower = new RegExp("(?=.*[a-z])");
    const upper = new RegExp("(?=.*[A-Z])");
    const number = new RegExp("(?=.*[0-9])");
    const special = new RegExp("(?=.*[!@#$%^&*])");
    const length = new RegExp("(?=.{8,})");
    let value = e.value;
    if (!lower.test(value)) {
        e.setCustomValidity("At least one lowercase character");
        e.reportValidity();
    } else if (!upper.test(value)) {
        e.setCustomValidity("At least one uppercase character");
        e.reportValidity();
    } else if (!number.test(value)) {
        e.setCustomValidity("At least one number");
        e.reportValidity();
    } else if (!special.test(value)) {
        e.setCustomValidity("At least one special characte");
        e.reportValidity();
    } else if (!length.test(value)) {
        e.setCustomValidity("At least 8 characters");
        e.reportValidity();
    } else {
        e.setCustomValidity("");
        e.reportValidity();
    }
}
function checkusername(e) {
    let regex = /^[^0-9\W]\S{4,}$/;
    let value = e.value;
    if (!regex.test(value)) {
        e.setCustomValidity("Invalid username");
        e.reportValidity();
    } else {
        e.setCustomValidity("");
        e.reportValidity();
    }
}
function checkPhone(input) {
    let regex = /^(0|84)(2(0[3-9]|1[0-6|8|9]|2[0-2|5-9]|3[2-9]|4[0-9]|5[1|2|4-9]|6[0-3|9]|7[0-7]|8[0-9]|9[0-4|6|7|9])|3[2-9]|5[5|6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])([0-9]{7})$/;
    let value = input.value;
    if (!regex.test(value)) {
        input.setCustomValidity("Phone number is not in the correct format");
        input.reportValidity();
    } else {
        input.setCustomValidity("");
        input.reportValidity();
    }
}
function views() {
    Server.get(`action=admin&function=member&page=${currentPages}&keySearch=${$("#search").val()}& role=${$("#fil-role").val()}`).then((res, req) => {
        let views = "";
        totalPages = res.page;
        if (res.page > 1) {
            createPagination(currentPages, res.page);
        } else {
            $("#page").html("");
        }
        for (let i of res.data) {
            views += ` <tr>
            <td>${i.id}</td>
            <td> ${i.fullname} </td>
            <td><img style="width:5rem;height:5rem;object-fit: cover;
            " src="${i.avatar}"></td>
            <td>
               ${i.balance}
            </td>
            <td>${i.email}</td>
            <td>${i.roleName}</td>
            
<td><button type="button" class="btn btn-outline-info"data-bs-toggle="modal" data-bs-target="#myModal" onclick="view(${i.id})">Edit</button></td>
<td><button type="button" class="btn btn-outline-danger" onclick="del(this,${i.id})">Delete</button></td>

        </tr>`;

        }
        $("#customer").html(views)

    }).catch((xhr, status, error) => {
        console.log(xhr);
    })
}
function navigateToPage(page) {
    currentPages = page;
    views();
    createPagination(page, totalPages);
    // Thực hiện các tác vụ cần thiết khi chuyển đến trang mới
    // ở đây, bạn có thể gọi hàm tải dữ liệu mới, v.v.

    // Gọi lại hàm tạo điều hướng phân trang với trang hiện tại mới
}
function view(id) {
    $("#label-avatar").show()
    $("#pswd input").attr({ placeholder: "Enter new password" })
    $("#pswd input").val('')
    $("#form-data").attr({ onsubmit: "update(this,event)" }).removeClass("was-validated")
    $("#form-data").attr({ "user-id": id })
    // $("#pswd").hide()
    $("#inputPswd").removeAttr("required")

    Server.get(`action=admin&function=member&id=${id}`).then((res, req) => {
        let data = res.data

        getRole(data.role_id);
        $("#bal").val(data.balance)
        $("#avatar").attr({ src: data.avatar })
        $("#inputUsername").val(data.fullname)
        $("#email").val(data.email)
        $("#email").attr({ "readonly": "true" })
        $("#inputAddress").val(data.address)
        $("#inputPhone").val(data.phone_number).get(0).setCustomValidity("");
        $("#function").show().text("Update")
    }).catch((xhr, status, error) => {
        console.log(xhr, status, error);
    })
}
function getRole(id = 0) {
    Server.get("action=admin&function=member&type=role").then((res, req) => {
        let option = "";
        let fill = ""
        for (let i of res.data) {
            option += ` <option value="${i.id}" ${i.id == id ? "selected" : ""}>${i.name}</option>`
            fill += ` <option value="${i.id}"}>${i.name}</option>`;
        }

        $("#fil-role").html(`  <option value="0" selected>All</option>` + fill);
        $("#role").html(option);

    })
}
function update(form, e) {
    e.preventDefault();
    let id = $(form).attr("user-id")
    let data = new FormData(form);
    Server.post(`action=admin&function=member&id=${id}`, data).then((res, req) => {
        Swal.fire({

            icon: 'success',
            title: 'Your work has been saved',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {


        })
    }).catch((xhr, status, error) => {
        Swal.fire({
            icon: 'error',
            title: 'update failed',
            text: 'Please try again later!',

        })
    }).finally(() => {
        views()
        view(id)
    })

}
function insert(form, e) {
    e.preventDefault()
    let data = new FormData(form);
    Server.post("action=admin&function=member", data).then((res, req) => {
        console.log(res.status);
        if (res.status == "success") {
            Swal.fire({

                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
            })
            viewInser()
        }
    }).catch((xhr, statsu, error) => {
        Swal.fire({
            icon: 'error',
            title: 'update failed',
            text: 'Please try again later!',

        })
        console.log(xhr);

    }).finally(() => {
        views();

    })
}
function viewInser() {
    $("#pswd input").attr({ placeholder: "Enter  password" })
    $("#avatar").attr({ src: "" })
    $("#form-data").removeAttr("user-id").removeClass("was-validated")
    $("#form-data").attr({ onsubmit: "insert(this,event)" })
    getRole(2);
    $("#avatar").attr({ src: "assets/avatar/people.png" })
    $("#inputUsername").val("").attr({ required: "true" })
    $("#email").attr({ required: "true" }).removeAttr("readonly")
    $("#email").val("")
    $("#inputAddress").val("")
    $("#inputPhone").val("").get(0).setCustomValidity("");
    $("#label-avatar").hide()
    $("#function").show().text("Add New")
    $("#pswd").show()
    $("#inputPswd").attr({ required: "true" }).val("")

}
function del(e, id) {
    $(e).html(`<div class="spinner-border text-danger"></div>`);
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
                Server.delete(`action=admin&function=member&id=${id}`)
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

            } else {
                $(e).text(`Delete`);
            }
        })

}

$(() => {
    getRole()
    views();
    $("#function").click(() => {
        let form = document.getElementById("form-data");

        if (!form.checkValidity()) {
            form.classList.add("was-validated");
        } else {
            form.classList.remove("was-validated");
        }
    });
})