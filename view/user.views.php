<div class="img-top" style="background: url('./assets/img/pro/seamless-gold-rhombus-grid-pattern-black-background_53876-97589.jpg')">

    <div class="container">
        <h1 class="ps-5 heading-title animate__animated animate__fadeInUp text-white text-start">user</h1>


    </div>
</div>
<div class="creative">
    <div class="container translate-top ">
        <!-- Nav pills -->
        <ul class="nav nav-pills shadow-lg p-2 bg-white">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="pill" href="#profile">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#Order-History">Order History</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#menu2">Menu 2</a>
            </li>
            <li class="d-flex ms-auto">

                <button class="btn btn-danger" type="button" onclick="logout()">Logout <i class="fa-solid fa-arrow-right-from-bracket"></i></button>
            </li>
        </ul>
        <style type="text/css">
            .nav-pills .nav-link.active,
            .nav-pills .show>.nav-link {
                color: #000;
                background-color: #ffff;
                position: relative;
            }

            a.nav-link.active::before {
                content: "";
                position: absolute;
                background-color: #34b7ae;
                height: 3px;
                width: 100%;
                bottom: 0;
                left: 0;
                border-radius: 3px;
                animation: load .5s;
            }

            @keyframes load {
                0% {
                    width: 0%;
                }

                100% {
                    width: 100%;
                }
            }
        </style>

        <!-- Tab panes -->
        <div class="tab-content  mt-2">
            <div class="tab-pane  active" id="profile">
                <div class="row">
                    <div class="col-lg-3 border-right shadow-lg">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                            <img class="rounded-circle mt-5 avatar" style="width:10em;height:10em;object-fit: cover" src="" alt="">
                            <input class="form-control" userId="" type="file" id="myfile" name="avatar" accept="image/png, image/gif, image/jpeg" id="updateFile">
                            <span class="font-weight-bold"></span>
                            <span class="text-black-50"></span>
                            <span> </span>
                        </div>
                    </div>
                    <form class="col-lg-9 border-right shadow-lg was-validated" id="info">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">Profile Settings</h4>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label class="labels">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Full Name" value="" required pattern="(\w|\W){5,16}$">
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">Mobile Number</label>
                                    <input type="tel" name="mobile" class="form-control" placeholder="enter phone number" value="" pattern="^(0|\+84)(3[2-9]|5[6|8|9]|7[0|6-9]|8[1-5|8|9]|9[0-4|6-9])(\d{7})$">
                                </div>
                                <div class="col-md-12">
                                    <label class="labels">Address </label>
                                    <input name="address" type="text" class="form-control" placeholder="enter address " value="">
                                </div>

                            </div>
                            <div class="mt-5 text-center">
                                <button id="upload" class="btn btn-primary profile-button" type="submit">Save Profile</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="tab-pane container fade py-2 bg-white shadow-lg" id="Order-History">
                <table class="table table-hover border-right ">
                    <thead>
                        <tr>
                            <th>Order#</th>
                            <th>Total</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="order">
                        <tr>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <td><button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#myModal">
                                    <i class="fas fa-info me-2"></i> Get information
                                </button></td>
                        </tr>

                    </tbody>
                </table>


            </div>
            <div class="tab-pane container fade" id="menu2">...</div>
        </div>
    </div>

</div>
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Modal body..
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<script src="./assets/js/user.js"></script>