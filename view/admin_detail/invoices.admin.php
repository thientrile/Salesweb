  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Invoices</h1>
      <form class="  shadow-sm p-3" method="get" action="">
          <input type="hidden" name="action" value="user" style="display: none;">
          <input type="hidden" name="act" value="invoices" style="display: none;">


          <input type="month" name="date" max="<?php echo date("Y-m"); ?>">
          <button class="btn btn-info">Fillter</button>
      </form>
  </div>
  <div id="invoices" class="shadow p-3">
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

              <div id="History<?php echo $item[0] ?>" class="collapse " data-bs-parent="#invoices">
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
                                $childs = $admin->view_OrderDetail($item[0]);
                                while ($childsItem = $childs->fetch()) {
                                ?>
                                  <tr onclick="window.location.href='index.php?action=shop&act=detail&id=<?php
                                                                                                            echo  $childsItem[2] ?>'">
                                      <td>
                                          <h6><?php echo $childsItem[0] ?></h6>
                                      </td>
                                      <td><img src="assets/products/<?php echo md5($childsItem[2]) . "/img/" . $childsItem['img'] ?>" style="width:100px" alt=""></td>
                                      <td></td>
                                  </tr>
                              <?php } ?>
                          </tbody>
                      </table>
                      <h6 class="text-end">Total bill:$<?php echo $item[1] ?></h6>
                  </div>
              </div>
          </div>

      <?php }
        if ($admin->countOrder > 1) {
            $paging->renderPaging($page, $admin->countOrder, 3);
        }

        ?>


  </div>