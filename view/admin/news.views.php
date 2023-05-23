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
                <input class="search_input" id="search" oninput=" views()" type="text" name="" placeholder="Search...">
                <button class="search_icon btn" onclick=""><i class="fas fa-search"></i></button>
            </div>
        </div>

    </div>
    <div class="shadow-lg  p-4 me-2">

        <div class="form-floating">
            <select class="form-select" id="cate" onchange="views()">
                `<option value="0" selected>All</option>

            </select>
            <label for="cate">Category</label>
        </div>
    </div>
    <div class="shadow-lg  p-4  d-flex justify-content-center">
        <button onclick="createNews()" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#myModal">Add news <i class="fa-solid fa-plus mx-2"></i></button>

    </div>

</div>
<div class="table-responsive-md shadow-lg mt-2 p-5 rounded-2 border-2">
    <table class="table table-hover  ">
        <thead class="table-success">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Avatar</th>
                <th scope="col">Category</th>

                <th scope="col">Author</th>
                <th scope="col">Date Created</th>



                <th colspan="3" scope="col" id="page">


                </th>

            </tr>
        </thead>
        <tbody id="news">

            <tr>
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
        <form id="form-data" class="modal-content needs-validation" onsubmit="">
            <input type="hidden" id="id">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <div class="row">
                    <div class="col-10">
                        <textarea id="content"></textarea>
                    </div>
                    <div class="col-2">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="title" required>
                            <label for="title">Title</label>
                            <div class="invalid-feedback">
                                The title must not be blank
                            </div>
                        </div>
                        <div class="border boder-1 mt-3 p-2 rounded-2">
                            <label class="btn btn-outline-success" for="img">Choose avatar</label>
                            <input class="form-control" type="file" name="img" id="img" onchange=" inputImage(this)" style="display:none" accept="image/*">
                            <div class="invalid-feedback">
                                Please enter a valid image of the news.
                            </div>
                            <img src="" class="mt-3" id="img-prev" alt="" width="100%" style="object-fit: cover;max-height:320px">

                        </div>
                        <div class="mt-3 p-2 rounded-2" id="Newscate">
                            <div class="input-group">
                                <span class="input-group-text">Category:</span>
                                <select class="form-select" id="category">

                                </select>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="true" id="flexCheckDefault" onchange="showAddCate(this)">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Add category news
                                </label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button id="function" type="submit" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-danger" id="reset">Reset</button>
            </div>

        </form>
    </div>
</div>

<script src="./assets/js/news.js"></script>