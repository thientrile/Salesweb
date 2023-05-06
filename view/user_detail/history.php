<div class="tab-pane container active">
    <div id="accordion">
        <?php
        while ($item = $viewOrder->fetch()) {

        ?>
            <style>
                .card .card-header a span i {
                    transition: all .5s;

                }

                .card .card-header a[aria-expanded=true] span i {
                    transform: rotate(90deg);
                }

                .card .card-header a:hover {
                    color: black;
                }

                .card .card-header:hover {
                    background: #ececec;

                }
            </style>
            <div class="card">
                <div class="card-header">
                    <a class="d-flex w-100" data-bs-toggle="collapse" href="#History<?php echo $item[0] ?>">
                        <span class="text-start col-6">

                            <i class="fa-solid fa-angle-right"></i>
                        </span>
                        <span class="text-end col-6">

                            <?php
                            echo $item[3];
                            ?>
                        </span>
                    </a>
                </div>

                <div id="History<?php echo $item[0] ?>" class="collapse " data-bs-parent="#accordion">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $childs = $checkout->view_OrderDetail($item[0]);
                                while ($childsItem = $childs->fetch()) {
                                ?>
                                    <tr onclick="window.location.href='index.php?action=shop&act=detail&id=<?php
                                    echo  $childsItem[2] ?>'">
                                        <td>
                                            <h6><?php echo $childsItem[0] ?></h6>
                                        </td>
                                        <td><img src="assets/img/body/creative/<?php echo  $childsItem[1] ?>" style="width:100px" alt=""></td>
                                        <td></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <h6 class="text-end">Total bill:$<?php echo $item[1] ?></h6>
                    </div>
                </div>
            </div>

        <?php } ?>


    </div>


</div>
<?php
if ($checkout->countOrder > 1) {
    $paging->renderPaging($page, $checkout->countOrder, 3);
?>

<?php
} ?>