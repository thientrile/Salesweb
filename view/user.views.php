<div class="img-top" style="background: url('./assets/img/pro/seamless-gold-rhombus-grid-pattern-black-background_53876-97589.jpg')">

    <div class="container">
        <h1 class="ps-5 heading-title animate__animated animate__fadeInUp text-white text-start"><?php
                                                                                                    $header = $userInfor->getInfor($_COOKIE['userId']);
                                                                                                    echo $header['fullname'];


                                                                                                    ?></h1>
        <h3 class="heading-sub animate__animated animate__fadeInUp text-start ps-5"><?php
                                                                                    $note = $header['role_id'] == 1 ? "Administrator" : "User";
                                                                                    echo $note;


                                                                                    ?></h3>

    </div>
</div>
<div class="creative">
    <div class="container translate-top shadow-lg p-5" style="background: white;">
        <div class="text-end">
            <a href="index.php?action=user&act=logout" class="btn btn-danger "><i class="fa-solid fa-arrow-right-from-bracket"></i>Log out</a>
        </div>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo !isset($_GET['act']) || $_GET['act'] == "history" ? "active" : "" ?>" href="index.php?action=user&act=history">Purchase History</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo isset($_GET['act']) && $_GET['act'] == 'info' ? "active" : ""; ?>" href="index.php?action=user&act=info">Edit Information</a>
            </li>

        </ul>

        <!-- Tab panes -->
        <div class="tab-content " style="min-height: 300px;">

            <?php
            $userDetail = isset($_GET['act']) ? $_GET['act'] : "history";
            include "view/user_detail/" . $userDetail . ".php" ?>

        </div>
    </div>

</div>