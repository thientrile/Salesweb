<div class="img-top" style="background: url('./assets/img/pro/seamless-gold-rhombus-grid-pattern-black-background_53876-97589.jpg')">

    <div class="container">
        <h1 class="ps-5 heading-title animate__animated animate__fadeInUp text-white text-start">Check out</h1>
        <h3 class="heading-sub animate__animated animate__fadeInUp text-start ps-5">

            <?php
            if (isset($_COOKIE['userId'])) {

                $header = $userInfor->getInfor($_COOKIE['userId']);
                if ($header['balance'] > 0) {

                    echo  "balance(" . currency_format($header['balance']) . ")";
                } else {
                    echo "balance(0)";
                }
            }


            ?></h1>
        </h3>
    </div>
</div>
<div class="creative">
    <div class="container translate-top shadow-lg " style="background: white;">
        <?php
        if ($sl > 0 && isset($_COOKIE['userId'])) {
        ?>
            <div class="row">
                <div class="col-md-12 py-3">
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            while ($item = $c->fetch()) {
                                $count++;
                            ?>
                                <form action="index.php?action=cart" method="POST">
                                    <input type="hidden" name="cartId" value="<?php echo $item[0]; ?>">
                                    <tr>
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $item[4]; ?></td>
                                        <td><img src="assets/img/body/creative/<?php echo $item[5] ?>" style="width:100px" alt=""></td>
                                        <td>
                                            <?php
                                            if ($item[10] > 0) {
                                                echo '<sub style="text-decoration:line-through">' . currency_format($item[11]) . '</sub>';
                                                echo currency_format($item[11] - $item[10] * $item[11]);
                                            } else {
                                                if ($item[11] == 0) {
                                                    echo '<span class="badge bg-success">Free</span>';
                                                } else {

                                                    echo currency_format($item[11]);
                                                }
                                            }
                                            ?>

                                        </td>
                                        <td><button type="submit" class="btn btn-danger" name="cartRemove">Remove</button></td>

                                    </tr>
                                </form>
                            <?php } ?>

                        </tbody>
                    </table>
                    <div class="text-end">
                        <button data-bs-toggle="modal" data-bs-target="#payment" class="btn btn-primary ">Check out</button>
                        <a href="index.php?action=cart&act=removeAll" class="btn btn-warning">Remove All</a>
                    </div>
                </div>



            </div>
        <?php } else {


        ?>

            <div class="p-5 bg-white" style="height: 300px; width:100%;text-align:center;line-height:300px">
                <h3>Empty</h3>
            </div>

        <?php } ?>
    </div>

</div>
<?php

?>
<div class="modal fade" id="payment">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">PAY BILLS</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <?php
                $Balance = $userInfor->getInfor($_COOKIE['userId']);
                ?>
                <h5 class=" <?php
                            if ($Balance >= 0) {
                                echo "text-primary";
                                echo - ($cart->cartPrice($_COOKIE['userId']) - $cart->cartDiscount($_COOKIE['userId']));
                            }




                            ?>">Balance(
                    <?php

                    echo  currency_format($Balance['balance']);
                    if (isset($_COOKIE['userId'])) {
                        $kq =  $cart->countCart($_COOKIE['userId']);
                        $sl = $kq['COUNT(*)'];
                        $c = $cart->viewCart($_COOKIE['userId']);
                    }

                    ?>)</h5>

                <div class="container">

                    <div class="row">
                        <div class="col-md-9 py-3">
                            <table class="table table-striped ">
                                <thead>
                                    <tr>

                                        <th>Title</th>
                                        <th>Image</th>
                                        <th>Price</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    while ($item = $c->fetch()) {

                                    ?>
                                        <form action="index.php?action=cart" method="POST">
                                            <input type="hidden" name="cartId" value="<?php echo $item[0]; ?>">
                                            <tr>

                                                <td><?php echo $item[4]; ?></td>
                                                <td><img src="assets/img/body/creative/<?php echo $item[5] ?>" style="width:100px" alt=""></td>
                                                <td>
                                                    <?php
                                                    if ($item[10] > 0) {
                                                        echo '<sub style="text-decoration:line-through">' . currency_format($item[11]) . '</sub>';
                                                        echo currency_format($item[11] - $item[10] * $item[11]);
                                                    } else {
                                                        if ($item[11] == 0) {
                                                            echo '<span class="badge bg-success">Free</span>';
                                                        } else {

                                                            echo currency_format($item[11]);
                                                        }
                                                    }
                                                    ?>

                                                </td>

                                        </form>
                                    <?php } ?>

                                </tbody>
                            </table>

                        </div>
                        <div class="col-md-3">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <h4 class="card-title">Payment Invoice</h4>
                                    <div class="card-text" style="display:flex;justify-content:space-between;"><span>Price:</span>
                                        <span><?php echo currency_format($cart->cartPrice($_COOKIE['userId'])); ?></span>
                                    </div>
                                    <div class="card-text" style="display:flex;justify-content:space-between;"><span>Sale Discount:</span>
                                        <span>-<?php echo currency_format($cart->cartDiscount($_COOKIE['userId'])); ?></span>
                                    </div>
                                    <div class="card-text" style="display:flex;justify-content:space-between;"><span>Subtotal:
                                        </span>
                                        <span><?php echo currency_format($cart->cartPrice($_COOKIE['userId']) - $cart->cartDiscount($_COOKIE['userId'])); ?></span>
                                    </div>
                                    <a href="index.php?action=checkout&act=all" class="btn btn-primary w-100">Payment</a>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>