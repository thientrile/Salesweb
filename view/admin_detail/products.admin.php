<script>
    function reviewImage(id1, id2) {
        let fileInputIm = id1;
        let imageElementIm = id2;

        fileInputIm.addEventListener('change', (event) => {
            const selectedFile = event.target.files[0];
            const reader = new FileReader();

            reader.addEventListener('load', () => {
                imageElementIm.src = reader.result;
            });

            reader.readAsDataURL(selectedFile);
        });
    }

    function reviewGallery(id1, id2) {
        const galleryIm = id1
        const previewIm = id2;

        galleryIm.addEventListener('change', () => {
            previewIm.innerHTML = '';




            for (const file of galleryIm.files) {
                let col = document.createElement('div');
                col.classList.add('col-3');
                previewIm.appendChild(col);
                if (file.type.startsWith('image/')) {
                    const readerIm = new FileReader();
                    readerIm.readAsDataURL(file);
                    readerIm.onload = () => {
                        col.innerHTML += `<img " class="w-100" src="${readerIm.result}" alt="${file.name}">`;
                    };
                } else if (file.type.startsWith('video/')) {
                    const videoIm = document.createElement('video');
                    videoIm.src = URL.createObjectURL(file);
                    videoIm.classList.add('w-100');
                    videoIm.controls = true;
                    videoIm.addEventListener('loadedmetadata', () => {
                        // previewIm.innerHTML += `<p>${file.name} (Duration: ${video.duration.toFixed(2)} seconds)</p>`;
                        col.appendChild(videoIm);
                    });
                } else if (file.type.startsWith('audio/')) {
                    const audioIM = document.createElement('audio');
                    audioIm.src = URL.createObjectURL(file)
                    audioIm.classList.add('w-100');
                    audioIm.controls = true;
                    audioIm.addEventListener('loadedmetadata', () => {

                        col.appendChild(audioIm);
                    });

                }
            }
        });
    }
</script>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800" onclick="document.location.href='index.php?action=user&act=products'" style="cursor:pointer">Products</h1>
    <form class="  shadow-sm p-3" method="get" action="">
        <input type="hidden" name="action" value="user" style="display: none;">
        <input type="hidden" name="act" value="products" style="display: none;">


        <select class="form-select" name="cate" onchange="submitForm(this.parentNode)">
            <option value="0">All</option>
            <?php
            while ($item = $optionCate->fetch()) {
            ?>
                <option value="<?php echo $item[0] ?>" <?php echo isset($_GET['cate']) && $_GET['cate'] == $item[0] ? "selected" : ""; ?>><?php echo $item[1] ?></option>
            <?php } ?>
        </select>

    </form>
</div>
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4" onclick="document.location.href='index.php?action=user&act=products&cate=1'" style="cursor:pointer">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Audio
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $product->countCategory(1)[0]; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-headphones"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4" onclick="document.location.href='index.php?action=user&act=products&cate=2'" style="cursor:pointer">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Graphics
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $product->countCategory(2)[0]; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-image"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4" onclick="document.location.href='index.php?action=user&act=products&cate=3'" style="cursor:pointer">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Themes
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    <?php echo $product->countCategory(3)[0]; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-regular fa-file"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function submitForm(id) {
            // console.log("🚀 ~ file: user.admin.php:157 ~ submitForm ~ id:", id)
            id.submit();


        }
    </script>
    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4" onclick="document.location.href='index.php?action=user&act=products&cate=4'" style="cursor:pointer">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Videos
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $product->countCategory(4)[0]; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-photo-film  text-gray-800"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="products">

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8">
                    <div class="row text-primary font-weight-bold">
                        <div class="col-3">Id</div>
                        <div class="col-3">Title</div>
                        <div class="col-3">Price</div>
                        <div class="col-3">Category</div>
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
    <?php while ($row = $products->fetch()) {
        array_push(
            $data,
            array($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11])
        )
    ?>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-3"><?php echo crc32($row[0]) ?></div>
                            <div class="col-3"><?php echo $row[1]; ?></div>
                            <div class="col-3"> <?php
                                                if ($row['discount'] > 0) {
                                                    echo '         <sub style="text-decoration:line-through">' . currency_format($row['price']) . '</sub>';
                                                    echo currency_format($row['price'] - $row['price'] * $row['discount']);
                                                } else if ($row['price'] > 0) {
                                                    echo currency_format($row['price']);
                                                } else {
                                                    echo "Free";
                                                }
                                                ?></div>
                            <div class="col-3"><?php echo $product->viewCategory($row[4])[1]; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-6">
                                <a class="collapsed btn btn-primary" data-bs-toggle="collapse" href="#product<?php echo crc32($row[0]) ?>">
                                    Edit
                                </a>
                            </div>
                            <div class="col-6">
                                <?php if (!$admin->hiddenProductDelete) { ?>
                                    <button type="button" class=" btn btn-danger" data-bs-toggle="modal" data-bs-target="#Delproduct<?php echo crc32($row[0]); ?>">
                                        Delete
                                    </button>
                                    <div class="modal fade" id="Delproduct<?php echo crc32($row[0]); ?>">
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
                                                    <form action="index.php?action=user&act=products&deletedId=<?php echo $row[0]; ?>" method="post">

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

            </div>
            <div id="product<?php echo crc32($row[0]) ?>" class="collapse <?php echo isset($_GET['id']) && $_GET['id'] == crc32($row[0]) ? "show" : ""; ?>" data-bs-parent="#products">
                <div class="card-body">
                    <form action="index.php?action=user&act=products&id=<?php echo crc32($row[0]) ?>&updated" method="post" class="was-validated" enctype="multipart/form-data">
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label for="title<?php echo crc32($row[0]) ?>" class="form-label h5">Product title:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" id="title<?php echo crc32($row[0]) ?>" name="title" required class="form-control w-50" placeholder="Enter the title of the product" value="<?php echo $row[1] ?>" <?php echo $admin->hiddenProductUpdate ? "readonly" : ""; ?>>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label for="avatarFile<?php echo crc32($row[0]) ?>" class="form-label h5">Avatar image of the product:</label>
                            </div>
                            <?php if (!$admin->hiddenProductUpdate) {

                            ?>
                                <div class="col-md-3">
                                    <input type="file" name="img" id="avatarFile<?php echo crc32($row[0]) ?>" class="form-control" placeholder="Enter the title of the product" accept="image/png, image/gif, image/jpeg">
                                </div>
                            <?php } ?>
                            <div class="col-md-3 text-center">
                                <img class="w-25" src="assets/products/<?php echo md5($row['id']) . "/img/" . $row['img'] ?>" alt="">
                            </div>
                            <script>
                                reviewImage(document.querySelector("#product<?php echo crc32($row[0]) ?> > div > form > div:nth-child(2) > div:nth-child(2) > input"), document.querySelector("#product<?php echo crc32($row[0]) ?> > div > form > div:nth-child(2) > div.col-md-3.text-center > img"));
                            </script>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label for="src<?php echo crc32($row[0]) ?>">Source of product</label>
                            </div>
                            <div class="col-md-3">
                                <input type="file" id="src<?php echo crc32($row[0]) ?>" name="src" class="form-control">

                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label for="type<?php echo crc32($row[0]) ?>" class="form-label">Selectable type of product:</label>
                            </div>
                            <div class="col-md-6">
                                <select class="form-select w-50" name="type" id="type<?php echo crc32($row[0]) ?>" required>
                                    <?php $type = $product->viewCategory();
                                    while ($item = $type->fetch()) {

                                    ?>
                                        <option value="<?php echo $item[0] ?>"> <?php echo $item[1]; ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label for="desc<?php echo crc32($row[0]) ?>" class="form-label">Product Description:</label>
                            </div>
                            <div class="col-md-9">
                                <textarea class="form-control w-100" id="desc<?php echo crc32($row[0]) ?>" name="desc" <?php if ($admin->hiddenProductUpdate) {
                                                                                                                            echo "disabled";
                                                                                                                        } ?>><?php echo $row['5'] ?></textarea>
                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label for="sdesc<?php echo crc32($row[0]) ?>" class="form-label">Short Description:</label>
                            </div>
                            <div class="col-md-6">
                                <textarea class="form-control w-100" id="sdesc<?php echo crc32($row[0]) ?>" name="sdesc" <?php echo $admin->hiddenProductUpdate ? "disabled" : ""; ?>><?php echo $row['6'] ?></textarea>
                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label for="discount<?php echo crc32($row[0]) ?>" class="form-label">
                                    Price reduction (percentage reduction written as divided by one hundred):
                                </label>

                            </div>
                            <div class="col-md-3">
                                <input type="text" name="discount" id="discount<?php echo crc32($row[0]) ?>" value="<?php echo $row[7] ?>" class="form-control" <?php echo $admin->hiddenProductUpdate ? "readonly" : ""; ?>>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label for="price<?php echo crc32($row[0]) ?>" class="form-label">
                                    Enter the price of the product:
                                </label>

                            </div>
                            <div class="col-md-3">
                                <input type="text" name="price" id="price<?php echo crc32($row[0]) ?>" value="<?php echo $row['8'] ?>" class="form-control" <?php echo $admin->hiddenProductUpdate ? "readonly" : ""; ?>>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label for="gallery<?php echo crc32($row[0]) ?>" class="form-label">Update images to product gallery:</label>
                            </div>
                            <?php if (!$admin->hiddenProductUpdate) { ?>
                                <div class="col-md-3">
                                    <input type="file" id="gallery<?php echo crc32($row[0]) ?>" name="gallery[]" class="form-control" multiple>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row mt-2 justify-content-center">
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>

                        </div>
                    </form>
                    <div class="row mt-2">
                        <div class="col-6">
                            <div class="row">

                                <?php
                                $items = $product->viewProductGallery($row[0]);
                                while ($set = $items->fetch()) {

                                    $fileType = getFileType($set[3]);
                                    if ($fileType == 'audio') {
                                        echo ' <div class="col-3">
                                         <form action="index.php?action=user&act=products&id=' . crc32($row[0]) . '&delgallery=' . $set[0] . '" method="post">
                                    <button type="submit" class="btn btn-close"></button>
                                </form>
                                    <audio class=" w-100" src="assets/products/' . md5($row[0]) . '/gallery/' . $set[2] . '" controls></audio>
                                </div>';
                                    } elseif ($fileType == 'image') {
                                        echo '  <div class="col-3">
                                        <form action="index.php?action=user&act=products&id=' . crc32($row[0]) . '&delgallery=' . $set[0] . '" method="post">
                                    <button type="submit" class="btn btn-close"></button>
                                </form>
                                    <img  class="w-100" src="assets/products/' . md5($row[0]) . '/gallery/' . $set[2] . '" alt="">
                                </div>';
                                    } elseif ($fileType == 'video') {
                                        echo ' <div class="col-3">
                                        <form action="index.php?action=user&act=products&id=' . crc32($row[0]) . '&delgallery=' . $set[0] . '" method="post">
                                    <button type="submit" class="btn btn-close"></button>
                                </form>
                                   
                                    <video class=" w-100"  src="assets/products/' . md5($row[0]) . '/gallery/' . $set[2] . '" controls></video>
                                </div>';
                                    }
                                }

                                ?>

                            </div>

                        </div>
                        <div class="col-6">
                            <div class="row " id="UpGallery<?php echo crc32($row[0]); ?>"></div>

                        </div>
                        <script>
                            reviewGallery(document.querySelector("#gallery<?php echo crc32($row[0]); ?>"), document.querySelector("#UpGallery<?php echo crc32($row[0]); ?>"))
                        </script>


                    </div>

                </div>
            </div>
        </div>
    <?php }
    foreach ($data as $row) {
        fputcsv($file, $row);
    }

    // Close the file
    fclose($file);

    ?>

    <?php $paging->renderPaging($page, $product->countpage, 3); ?>
</div>
<?php if (!$admin->hiddenProductImport) { ?>
    <button class="btn btn-success  position-fixed end-0  mb-4 me-4" data-bs-toggle="offcanvas" data-bs-target="#newProduct" style="top:90%">More new products</button>
    <div class="offcanvas offcanvas-bottom " id="newProduct" style="min-height:100vh">


        <div class="offcanvas-header">
            <h1 class="offcanvas-title text-center">More new products</h1>
            <button type="button" class="btn btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form action="index.php?action=user&act=products&import" method="post" class="was-validated" enctype="multipart/form-data">
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for="title" class="form-label h5">Product title:</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" id="title" name="title" required class="form-control" placeholder="Enter the title of the product">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for="avatarFile" class="form-label h5">Avatar image of the product:</label>
                    </div>
                    <div class="col-md-3">
                        <input type="file" name="img" required class="form-control" placeholder="Enter the title of the product" accept="image/png, image/gif, image/jpeg" id="avatarFileIm">
                    </div>
                    <div class="col-md-3 text-center">
                        <img class="w-25" src="" alt="" id="avatarImageIm">
                    </div>
                    <script>
                        const fileInputIm = document.querySelector("#avatarFileIm")
                        const imageElementIm = document.querySelector("#avatarImageIm")

                        fileInputIm.addEventListener('change', (event) => {
                            const selectedFile = event.target.files[0];
                            const reader = new FileReader();

                            reader.addEventListener('load', () => {
                                imageElementIm.src = reader.result;
                            });

                            reader.readAsDataURL(selectedFile);
                        });
                    </script>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for="src">Source of product</label>
                    </div>
                    <div class="col-md-3">
                        <input type="file" id="src" name="src" required class="form-control">
                    </div>


                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for="type" class="form-label">Selectable type of product:</label>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" name="type" required>
                            <?php $type = $product->viewCategory();
                            while ($item = $type->fetch()) {

                            ?>
                                <option value="<?php echo $item[0] ?>"> <?php echo $item[1]; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for="desc" class="form-label">Product Description:</label>
                    </div>
                    <div class="col-md-9">
                        <textarea class="form-control w-100" id="desc" name="desc"></textarea>
                    </div>

                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for="sdesc" class="form-label">Summary of product information:</label>
                    </div>
                    <div class="col-md-6">
                        <textarea class="form-control w-100" id="sdesc" name="sdesc"></textarea>
                    </div>

                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for="discount" class="form-label">
                            Enter product discount percentage (if any):
                        </label>

                    </div>
                    <div class="col-md-3">
                        <input type="text" name="discount" id="discount" value="0" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for="price" class="form-label">
                            Enter the price of the product:
                        </label>

                    </div>
                    <div class="col-md-3">
                        <input type="text" name="price" id="price" value="0" class="form-control" required>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for="galleryIm" class="form-label">Add images to product gallery:</label>
                    </div>
                    <div class="col-md-3">
                        <input type="file" id="galleryIm" name="gallery[]" class="form-control" multiple required>
                    </div>
                    <div class="col-md-6" style="position: relative;">
                        <div class="row" id="previewIm"></div>
                    </div>
                    <script>
                        reviewGallery(document.querySelector("#galleryIm"), document.querySelector("#previewIm"));
                    </script>
                </div>
                <div class="row mt-2 justify-content-center">
                    <div class="col-3">
                        <button type="submit" class="btn btn-primary">Add new products</button>
                    </div>
                </div>



            </form>
        </div>
    </div>
<?php } ?>