<style>
    .searchbar {
        margin-bottom: auto;
        margin-top: auto;
        height: 40px;
        background-color: #d0f8f1;
        border-radius: 30px;
        padding: 10px;
    }

    .search_input {
        translate: all .5s;
        color: black;
        border: 0;
        outline: 0;
        background: none;
        width: 0;
        caret-color: transparent;
        line-height: 20px;
        transition: width 0.4s linear;

    }

    .searchbar:hover>.search_input {
        padding: 0 10px;
        width: 350px;
        caret-color: red;
        transition: width 0.4s linear;
    }

    .searchbar:hover>.search_icon {
        background: white;
        color: #e74c3c;
    }

    .search_icon {
        height: 20px;
        width: 20px;
        float: right;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
        color: #333;

    }
</style>
<div class="d-flex justify-content-end ">

    <div class="shadow-lg  p-4 ">
        <div class="d-flex justify-content-center h-100">
            <div class="searchbar">
                <input class="search_input" id="search" oninput="loads()" type="text" name="" placeholder="Search...">
                <button class="search_icon btn" onclick="loads()"><i class="fas fa-search"></i></button>
            </div>
        </div>

    </div>
    <div class="shadow-lg  p-4 me-2">

        <div class="form-floating">
            <select class="form-select" id="cate" onchange="loads()">
                `<option value="0" selected>All</option>

            </select>
            <label for="cate">Category</label>
        </div>
    </div>
    <div class="shadow-lg  p-4  d-flex justify-content-center">
        <button onclick="Reset()" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#myModal">Add product <i class="fa-solid fa-plus mx-2"></i></button>

    </div>

</div>
<div class="table-responsive-md shadow-lg mt-2 p-5 rounded-2 border-2">
    <table class="table table-hover  ">
        <thead class="table-success">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Image</th>

                <th scope="col">Category</th>
                <th scope="col">Discount</th>
                <th scope="col">Price</th>
                <th scope="col"></th>
                <th scope="col"></th>

            </tr>
        </thead>
        <tbody id="product">

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td scope="row">
                    <div class="spinner-border text-secondary"></div>
                </td>
                <td></td>
                <td></td>
                <td></td>

            </tr>

        </tbody>
    </table>
</div>
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form id="form-data" class="container" onsubmit="update(event)">
                    <input type="hidden" id="id">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">Title</span>
                                <input required type="text" id="title" class="form-control" placeholder="Enter product title">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">Category:</span>
                                <select class="form-select" id="category">

                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">Price</span>
                                <input type="text" value="0" id="price" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">Discount</span>
                                <input type="text" value="0" min=0 max=1 id="discount" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="sdesc" class="form-label">Product summary</label>
                            <textarea id="sdesc"></textarea>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="border border-1 p-2 rounded-2">
                                <label class="btn btn-info" for="src">Choose source</label>
                                <input type="file" id="src" class="form-control" onchange="inputSrc(this)" style="display:none">
                                <span class="src"></span>


                            </div>
                            <div class="border boder-1 mt-3 p-2 rounded-2">
                                <label class="btn btn-outline-success" for="img">Choose a representative image of the product</label>
                                <input type="file" id="img" onchange=" inputImage(this)" style="display:none" accept="image/*">
                                <img src="" class="mt-3" id="img-prev" alt="" width="100%" style="object-fit: cover;max-height:320px">

                            </div>
                        </div>
                    </div>
                    <div class="mt-3">

                        <label for="desc" class="form-label">Detailed product description</label>
                        <textarea id="desc"></textarea>

                    </div>
                    <div class="mt-3">

                        <label class="h5" for="gallery">Gallery</label>
                        <br>
                        <label class="btn btn-outline-primary" for="gallery">Select image gallery</label>
                        <input onchange="inputGallery(this)" type="file" name="gallery" id="gallery" multiple accept="image/*, video/*, audio/*" style="display:none">

                    </div>
                    <div class="row mt-3 border border-3 p-3" id="gallery-prev">

                    </div>
                    <div class="d-flex justify-content-end mt-3">


                    </div>
                </form>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button id="function" type="button" class="btn btn-success" data-bs-dismiss="modal">Update</button>
                <button type="button" class="btn btn-danger" id="reset">Reset</button>
            </div>

        </div>
    </div>
</div>

<script src="./assets/js/product.js"></script>