<div class="table-responsive-md shadow-lg mt-4 p-5 rounded-2 border-2" style="min-height: 600px;">
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
                <form class="container">
                    <input type="hidden" id="id">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">Title</span>
                                <input type="text" id="title" class="form-control" placeholder="Enter product title">
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
                                <input type="text" id="price" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">Discount</span>
                                <input type="text" id="discount" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="sdesc" class="form-label">Product summary</label>
                            <textarea id="sdesc"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="btn btn-info" for="src">Choose another source</label>
                            <input type="file" id="src" class="form-control" style="display:none">
                            <span class="src"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="desc" class="form-label">Product summary</label>
                            <textarea id="desc"></textarea>
                        </div>
                    </div>
                </form>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<script src="./assets/js/product.js"></script>