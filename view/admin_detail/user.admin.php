<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Members</h1>

    <form class=" shadow-sm p-3" method="get" action="">
        <input type="hidden" name="action" value="user" style="display: none;">
        <input type="hidden" name="act" value="user" style="display: none;">
        <select class="form-select" name="role" onchange="submitForm(this.parentNode)">
            <option value="">ALL</option>
            <?php
            $viewRole = $admin->viewRoles();
            while ($rowRole = $viewRole->fetch()) { ?>

                <option value=" <?php echo $rowRole[0] ?>" <?php echo isset($_GET['role']) && $_GET['role'] == $rowRole[0] ? "selected" : "" ?>><?php echo $rowRole[1] ?></option>
            <?php } ?>
        </select>


    </form>
    <script>
        function submitForm(id) {
            // console.log("🚀 ~ file: user.admin.php:157 ~ submitForm ~ id:", id)
            id.submit();


        }
    </script>
</div>
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Admin
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Users
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Member Of HR anagement
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    50%
                                </div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Product Manager Member
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="member" class=" shadow p-3">
    <div class="card">
        <div class="card-header  text-primary font-weight-bold">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-3 ">ID</div>
                        <div class="col-3">Username</div>
                        <div class="col-3">Email</div>
                        <div class="col-3">Membership category</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php while ($row = $userLists->fetch()) { ?>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-3"><?php echo crc32($row[0]); ?></div>
                            <div class="col-3"><?php echo $row[2]; ?></div>
                            <div class="col-3"><?php echo $row[4]; ?></div>
                            <div class="col-3"><?php echo $admin->viewRole($row[8])[1]; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-6"> <a class="btn btn-primary" data-bs-toggle="collapse" href="#member<?php echo crc32($row[0]); ?>">
                                    Edit
                                </a></div>
                            <div class="col-6"> <?php if (!$admin->hiddenMemberDelete) { ?>
                                    <button type="button" class=" btn btn-danger" data-bs-toggle="modal" data-bs-target="#Delmember<?php echo crc32($row[0]); ?>">
                                        Delete
                                    </button>
                                    <div class="modal fade" id="Delmember<?php echo crc32($row[0]); ?>">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Product deletion confirmation</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    Do you want to delete product <?php echo $row[1]; ?> ?
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                    <form class="was-validated" action="index.php?action=user&act=user&deletedid=<?php echo $row[0] ?>" method="post">
                                                        <button type="submit" class="btn  btn-secondary">Comfirm ?</button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="member<?php echo crc32($row[0]); ?>" class="collapse <?php echo isset($_GET['id']) && $_GET['id'] == crc32($row[0]) ? "show" : ""; ?>" data-bs-parent=" #member">
                    <div class="card-body" style="background-color: #eee;">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        <img style="width:100px;object-fit: cover;" src="assets/user/<?php echo md5($row[0]) ?>/avatar/<?php echo $row[1]; ?>" alt="">
                                        <h5 class="my-3"><?php echo $row[2]; ?></h5>

                                        <div class="d-flex justify-content-center mb-2">
                                            <form action="index.php?action=user&act=user&avatarid=<?php echo $row[0] ?>&id=<?php echo $row[0] ?>" method="post" enctype="multipart/form-data">
                                                <input class="form-control" class="form-control" style="width:90px;overflow:hidden" type="file" id="myfile" name="avatar" accept="image/png, image/gif, image/jpeg" onchange="submitForm(this.parentNode)">
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-8">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Username</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <form action="index.php?action=user&act=user&userid=<?php echo $row[0] ?>" method="post" class="was-validated"><input class="form-control" name="username" type="text" class="form-control" value="<?php echo $row[2]; ?>" readonly="true" <?php if (!$admin->hiddenMemberUpdate) { ?> ondblclick="this.readOnly=false" <?php } ?> required pattern="(\w|\W){5,16}$">
                                                </form>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Email</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0"><?php echo $row[4]; ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Phone</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <form class="was-validated" action="index.php?action=user&act=user&phonenumberid=<?php echo $row[0] ?>" method="post"><input class="form-control" name="phonenumber" type="text" class="form-control" style="height:100px;" value="<?php echo $row[5]; ?>" readonly="true" <?php if (!$admin->hiddenMemberUpdate) { ?> ondblclick="this.readOnly=false" <?php } ?> required pattern="^(0|84)(2(0[3-9]|1[0-6|8|9]|2[0-2|5-9]|3[2-9]|4[0-9]|5[1|2|4-9]|6[0-3|9]|7[0-7]|8[0-9]|9[0-4|6|7|9])|3[2-9]|5[5|6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])([0-9]{7})$">
                                                </form>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Address</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <form class="was-validated" action="index.php?action=user&act=user&addressid=<?php echo $row[0] ?>" method="post"><input class="form-control" name="address" type="text" class="form-control" style="height:100px;" value="<?php echo $row[6]; ?>" readonly="true" <?php if (!$admin->hiddenMemberUpdate) { ?> ondblclick="this.readOnly=false" <?php } ?> required>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Membership category</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <form class="was-validated" action="index.php?action=user&act=user&roleid=<?php echo $row[0] ?>" method="post" id="role<?php echo $row[0] ?>"><select name="rode" class="form-select" <?php echo $admin->hiddenMemberUpdate ? "disabled" : ""; ?>onchange="submitForm(this.parentNode)"><?php $viewRole = $admin->viewRoles();
                                                                                                                                                                                                                                                                                                                                        while ($rowRole = $viewRole->fetch()) { ?><option value=" <?php echo $rowRole[0] ?>" <?php echo $admin->viewRole($row[8])[0] == $rowRole[0] ? " selected" : ""; ?>><?php echo $rowRole[1] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }


    if ($admin->countpage) {
        $paging->renderPaging($page, $admin->countpage, 3);
    }

    ?>


</div>
<?php if (!$admin->hiddenMemberImport) { ?>
    <button class="btn btn-success btn-lg position-fixed end-0  mb-4 me-4" data-bs-toggle="offcanvas" data-bs-target="#importMember" style="top:90%">Add new member</button>
    <!-- import Member -->
    <div class="offcanvas offcanvas-end " id="importMember">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title">Add New Member</h3>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form action="index.php?action=user&act=user&new" method="post" id="#update" class="was-validated">
                <div class="mb-3 mt-3 form-group">
                    <label for="username">Username: </label>
                    <input required class="form-control" id="username" type="text" name="username" pattern="(\w|\W){5,16}$">
                    <!-- <div class="valid-feedback">Valid.</div> -->
                    <div class="invalid-feedback">Invalid Username</div>
                </div>
                <div class="form-group mb-3 mt-3">
                    <label for="email">Email Address:</label>
                    <input required type="email" id="email" name="email" class="form-control email" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$">
                    <div class="invalid-feedback">Invalid Email</div>
                </div>
                <div class="form-group  mb-3 mt-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,32}$" title="Password must be at least 8 characters, one uppercase letter, one lowercase letter and one number">
                </div>

                <div class="form-group  mb-3 mt-3">
                    <label for="address"> Address:</label>
                    <input type="text" id="address" name="address" class="form-control">
                </div>
                <div class="form-group  mb-3 mt-3">
                    <label for="phonenumber">Phone Number:</label>
                    <input type="text" name="phonenumber" id="phonenumber" class="form-control phonenumber" pattern="^(0|84)(2(0[3-9]|1[0-6|8|9]|2[0-2|5-9]|3[2-9]|4[0-9]|5[1|2|4-9]|6[0-3|9]|7[0-7]|8[0-9]|9[0-4|6|7|9])|3[2-9]|5[5|6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])([0-9]{7})$">
                    <div class="invalid-feedback">Invalid Phonenumber</div>
                </div>
                <div class="form-group">

                    <label for="type">Membership category</label>
                    <select name="type" id="type" class="form-select">
                        <?php
                        $viewRole = $admin->viewRoles();
                        while ($rowRole = $viewRole->fetch()) { ?>
                            <option value=" <?php echo $rowRole[0] ?>" <?php echo 2 == $rowRole[0] ? " selected" : ""; ?>><?php echo $rowRole[1] ?></option>
                        <?php } ?>
                    </select>
                </div>



                <div class="form-group my-2">

                    <button type="submit" class="btn btn-success">Add Member</button>
                </div>

            </form>
            <div class="mb-3 mt-3">

            </div>
        </div>
    </div>
<?php } ?>