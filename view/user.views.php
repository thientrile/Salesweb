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
                <a class="nav-link" data-bs-toggle="pill" href="#menu1">Menu 1</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#menu2">Menu 2</a>
            </li>
            <li class="d-flex ms-auto">

                <button class="btn btn-danger" type="button">Logout <i class="fa-solid fa-arrow-right-from-bracket"></i></button>
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
                    <div class="col-md-3 border-right shadow-lg">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5 avatar" style="width:200px;height:200px;object-fit: cover" src=""> <input class="form-control" userId="" type="file" id="myfile" name="avatar" accept="image/png, image/gif, image/jpeg" id="updateFile"><span class="font-weight-bold">Edogaru</span><span class="text-black-50">edogaru@mail.com.my</span><span> </span></div>
                    </div>
                    <div class="col-md-9 border-right shadow-lg " id="info">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">Profile Settings</h4>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12"><label class="labels">Name</label><input type="text" class="form-control" placeholder="Full Name" value=""></div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12"><label class="labels">Mobile Number</label><input type="text" class="form-control" placeholder="enter phone number" value=""></div>
                                <div class="col-md-12"><label class="labels">Address </label><input type="text" class="form-control" placeholder="enter address line 1" value=""></div>

                            </div>
                            <div class="mt-5 text-center"><button id="upload" class="btn btn-primary profile-button" type="button">Save Profile</button></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane container fade" id="menu1">...</div>
            <div class="tab-pane container fade" id="menu2">...</div>
        </div>
    </div>

</div>
<script src="./assets/js/user.js"></script>