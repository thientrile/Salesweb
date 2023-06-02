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

            <li class="d-flex ms-auto">
                <a id="admin" href="index.php?action=admin" class="btn btn-outline-info me-2" style="display:none">Administration</a>
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
                            <img class="rounded-circle mt-5 avatar"id="image-Avatar" style="width:10em;height:10em;object-fit: cover" src="" alt="">
                            <label for="myfile" class="btn btn-light">Change avatar</label>
                            <input class="form-control" userId="" type="file" id="myfile" name="avatar" accept="image/png, image/gif, image/jpeg" id="updateFile" style="display:none">
                            <span class="font-weight-bold"></span>
                            <span class="text-black-50"></span>
                            <span> </span>
                        </div>
                    </div>
                    <form class="col-lg-9 border-right shadow-lg " id="info" onsubmit="update(event)">
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
                                <button id="upload" class="btn btn-primary profile-button" type="button">Save Profile</button>
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


                    </tbody>
                </table>


            </div>

        </div>
    </div>

</div>
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">

            <div class="card">
                <div class="card-body">
                    <div class="container mb-5 mt-3">
                        <div class="row d-flex align-items-baseline">
                            <div class="col-xl-9">
                                <p style="color: #7e8d9f;font-size: 20px;">Invoice >> <strong class="id">ID: </strong></p>
                            </div>
                            <div class="col-xl-3 float-end">
                                <a class="btn btn-light text-capitalize border-0" onclick="printHtml()" data-mdb-ripple-color="dark"><i class="fas fa-print text-primary"></i> Print</a>
                                <a class="btn btn-light text-capitalize" id="export" data-mdb-ripple-color="dark"><i class="far fa-file-pdf text-danger"></i> Export</a>
                            </div>
                            <hr>
                        </div>

                        <div class="container">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                    <img src="./assets/img/heading/logo/dgw-logo-grey.png" alt="" style="height:100px;object-fit: cover;" />

                                </div>

                            </div>


                            <div class="row">
                                <div class="col-xl-8">
                                    <ul class="list-unstyled">
                                        <li class="text-muted">To: <span class="fullname" style="color:#5d9fc5 ;">John Lorem</span></li>

                                        <li class="text-muted address">State, Country</li>
                                        <li class="text-muted"><i class="fas fa-phone"></i><span class="phone"></span> </li>
                                    </ul>
                                </div>
                                <div class="col-xl-4">
                                    <ul class="list-unstyled">
                                        <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span class="fw-bold id"></span></li>
                                        <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span class="fw-bold">Creation Date: </span> <span class="created"></span> </li>

                                    </ul>
                                </div>
                            </div>

                            <div class="row my-2 mx-1 justify-content-center">
                                <table class="table table-striped table-borderless">
                                    <thead style="background-color:#84B0CA ;" class="text-white">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Discount</th>
                                            <th scope="col">Unit Price</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col"></th>
                                            <th scope="col" id="page"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="detail">


                                    </tbody>

                                </table>
                            </div>
                            <div class="row">
                                <div class="col-xl-8">
                                    <p class="ms-3">Add additional notes and payment information</p>

                                </div>
                                <div class="col-xl-3">
                                    <ul class="list-unstyled">
                                        <li class="text-muted ms-3 price"><span class="text-black me-4">SubTotal</span></li>
                                        <li class="text-muted ms-3 mt-2 discount"><span class="text-black me-4 discount">Tax(15%)</span>$111</li>
                                    </ul>
                                    <p class="text-black float-start total"><span class="text-black me-3"> Total Amount</span><span style="font-size: 25px;">$1221</span></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xl-10">
                                    <p>Thank you for your purchase</p>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="./assets/js/user.js"></script>