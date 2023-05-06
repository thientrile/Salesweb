<div class="img-top"
    style="background: url('./assets/img/pro/seamless-gold-rhombus-grid-pattern-black-background_53876-97589.jpg')">
    <div class="container">
        <h1 class="ps-5 heading-title animate__animated animate__fadeInUp text-white text-center">
           
        <p class="heading-sub animate__animated animate__fadeInUp text-start ps-5 text-center" style="font-size: 1em;">
           
    </div>
</div>
<div class="creative ">
    <div class="container translate-top shadow-lg" style="background: white;">
        <div class="row p-3">
            <div class="col-md-8">
                <div id="media-carousel" class="carousel slide" data-bs-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators" style="bottom:auto;top:0">

                      

                    </ol>
                    <!-- Slides -->

                    <div class="carousel-inner">


                    </div>


                </div>

            </div>
            <div class="col-md-4">
                <div class="card mt-4 border border-3" style="width:100%;">
                    <div class="card-header text-center">Item Details</div>
                    <div class="card-body d-flex justify-content-center align-items-center flex-column">
                        <h3 class="">

                        </h3>

                    </div>
                </div>
                <div class="card mt-4 border border-3" style="width:100%;">
                    <div class="card-header text-center">DETAILS</div>
                    <div class="card-body d-flex justify-content-start align-items-center flex-column">
                        <ul class="list-group" style="width:100%">
                            <li class="list-group-item">Category:<a href="index.php?action=shop&cate="
                                    style="font-size:1em;text-decoration: none;" class="text-success">

                                </a></li>
                            <li class="list-group-item">Released Date:</li>
                            <li class="list-group-item">Last Updated:</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mt-5">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#description">Description</a>
                    </li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane container active" id="description">


                    </div>

                </div>
            </div>





        </div>
    </div>

</div>
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



                                    <tr>

                                        <td><?php echo $new['title']; ?></td>
                                        <td><img src="assets/img/body/creative/<?php echo $new['img'] ?>"
                                                style="width:100px" alt=""></td>
                                        <td>
                                            <?php
											if ($new['discount'] > 0) {
												echo '<sub style="text-decoration:line-through">' . currency_format($new['price']) . '</sub>';
												echo currency_format($new['price'] - $new['discount'] * $new['price']);
											} else {
												if ($new['price'] == 0) {
													echo '<span class="badge bg-success">Free</span>';
												} else {

													echo currency_format($new['price']);
												}
											}
											?>

                                        </td>




                                </tbody>
                            </table>

                        </div>
                        <div class="col-md-3">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <h4 class="card-title">Payment Invoice</h4>
                                    <div class="card-text" style="display:flex;justify-content:space-between;">
                                        <span>Price:</span>
                                        <span><?php echo currency_format($new['price']); ?></span>
                                    </div>
                                    <?php if ($new['discount'] * $new['price'] > 0) { ?>
                                    <div class="card-text" style="display:flex;justify-content:space-between;">
                                        <span>Sale Discount:</span>
                                        <span>-<?php echo currency_format($new['discount'] * $new['price']); ?></span>
                                    </div>
                                    <?php } ?>
                                    <div class="card-text" style="display:flex;justify-content:space-between;">
                                        <span>Subtotal:
                                        </span>
                                        <span><?php echo currency_format($new['price'] - $new['discount'] * $new['price']); ?></span>
                                    </div>
                                    <form action="index.php?action=checkout&act=one" method="post">
                                        <input type="hidden" name="product_id" value="<?php echo $new['id'] ?>">
                                        <input type="hidden" name="discount" value="<?php echo $new['discount'] ?>">
                                        <input type="hidden" name="price" value="<?php echo $new['price'] ?>">
                                        <button class="btn btn-primary w-100" type="submit">Payment</button>
                                    </form>

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