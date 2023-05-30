<style>
    .searchbar {
        margin-bottom: auto;
        margin-top: auto;
        height: 40px;
        background-color: #d0f8f1;
        border-radius: 30px;
        padding: 10px;
        position: relative;
        top: 0;
        right: 0;

    }

    .search_input {
        translate: all .5s;
        color: black;
        border: 0;
        outline: 0;
        background: none;
        width: 0;
        caret-color: transparent;
        line-height: 20px;
        transition: width 0.4s linear;

    }

    .searchbar:hover>.search_input {
        padding: 0 10px;
        width: 25rem;
        caret-color: red;
        transition: width 0.4s linear;
    }

    .searchbar:hover>.search_icon {
        background: white;
        color: #e74c3c;
    }

    .search_icon {
        height: 20px;
        width: 20px;
        float: right;
        position: relative;
        right: 0;

        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
        color: #333;

    }
</style>
<div class="d-flex justify-content-end ">

    <div class="shadow-lg  p-4 ">
        <div class="d-flex justify-content-center h-100">
            <div class="searchbar">
                <input class="search_input" id="search" oninput="views()" type="text" name="" placeholder="Search...">
                <button class="search_icon btn" onclick=""><i class="fas fa-search"></i></button>
            </div>
        </div>

    </div>
    <div class="shadow-lg  p-4 me-2">

        <div class="form-floating">
            <select class="form-select" id="fil-role" onchange="views()">
                <option value="0" selected>All</option>

            </select>
            <label for="cate">Role</label>
        </div>
    </div>
    <div class="shadow-lg  p-4  d-flex justify-content-center">
        <button onclick="viewInser()" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#myModal">Add user <i class="fa-solid fa-plus mx-2"></i></button>
    </div>
   
</div>
<div class="table-responsive-md shadow-lg mt-2 p-5 rounded-2 border-2">
    <table class="table table-hover  ">
        <thead class="table-success">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Username</th>
                <th scope="col">Avatar</th>
                <th scope="col">Balance</th>

                <th scope="col">Email</th>
                <th>Type</th>
                <th colspan="2" id="page"></th>
            </tr>
        </thead>
        <tbody id="customer">
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td scope="row">
                    <div class="spinner-border text-secondary"></div>
                </td>
                <td></td>
                <td></td>
                <td></td>


            </tr>

        </tbody>
    </table>



</div>
<div class="modal fade" id="myModal">
    <form id="form-data" class="modal-dialog modal-fullscreen">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal Header 

                <!-- Modal body -->
            <div class="modal-body">
                <div class="container-xl px-4 mt-4">
                    <!-- Account page navigation-->

                    <hr class="mt-0 mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <!-- Profile picture card-->
                            <div class="card mb-4 mb-xl-0">
                                <div class="card-header">Profile Picture</div>
                                <div class="card-body text-center">
                                    <!-- Profile picture image-->
                                    <img id="avatar" class="img-account-profile  mb-2" style="width:100%" alt="">
                                    <!-- Profile picture help block-->
                                    <input class="form-controll" type="file" name="avatar" onchange=" inputImage(this)" id="input-avatar" style="display:none" accept="Image/*">
                                    <div class="invalid-feedback">Please fill out this field.</div>
                                    <label class="btn btn-primary" id="label-avatar" for="input-avatar">Upload new image</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <!-- Account details card-->
                            <div class="card mb-4">
                                <div class="card-header">Customer Details</div>
                                <div class="card-body" id="card-body">
                                    <!-- Form Group (username)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="inputUsername">Username</label>
                                        <input class="form-control" name="username" id="inputUsername" oninput=" checkusername(this)" type="text" placeholder="Enter your username" value="">
                                    </div>
                                    <div class=" row mb-3">
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                            <input type="email" name="email" class="form-control" id="email" oninput=" checkEmail(this)">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select class="form-select" id="role" name="role">


                                                </select>
                                                <label for="cate">Role</label>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputAddress">Your Address</label>
                                            <input class="form-control" name="address" id="inputAddress" type="text" placeholder="Enter your address">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputPhone">Phone number</label>
                                            <input class="form-control" name="phone" oninput="checkPhone(this)" id="inputPhone" type="tel" placeholder="Enter your phone number">
                                        </div>

                                    </div>
                                    <div class="mb-3" id="pswd" style="display:none">
                                        <label class="small mb-1" for="inputPswd">Password</label>
                                        <input class="form-control" name="pswd" id="inputPswd" onchange=" checkpswd(this)" type="text" placeholder="Enter your password" value="">
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button id="function" type="submit" class="btn btn-outline-primary" style="display:none">Update</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>




        </div>
    </form>
</div>
<script src="./assets/js/member.js"></script>