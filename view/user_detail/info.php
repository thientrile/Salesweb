<div class="tab-pane container active ">
    <div class=" row">
        <div class="col-md-4 ">
            <div class="card w-100">

                <div class="text-center">
                    <img id="avatar-img" class="card-img-top" src="assets/user/<?php echo md5($_COOKIE['userId']) ?>/avatar/<?php echo $userInfor->getInfor($_COOKIE['userId'])[1]; ?>" alt="Card image" style="height:200px;width:200px;object-fit: cover;border-radius: 50%;background: linear-gradient(315deg, #f0f0f0, #cacaca);box-shadow:  -20px -20px 60px #bebebe,     20px 20px 60px #ffffff;">
                </div>

                <div class="card-body ">


                    <form action="index.php?action=user&act=info" method="post" enctype="multipart/form-data" style="background:none;">

                        <input class="form-control" type="file" id="myfile" name="avatar" accept="image/png, image/gif, image/jpeg" id="updateFile">
                        <input class="btn btn-success" type="submit" name="upavatar" value="Update Avatar">
                    </form>
                    <script>
                        const fileInput = document.querySelector("#myfile")
                        const imageElement = document.querySelector("#avatar-img")

                        fileInput.addEventListener('change', (event) => {
                            const selectedFile = event.target.files[0];
                            const reader = new FileReader();

                            reader.addEventListener('load', () => {
                                imageElement.src = reader.result;
                            });

                            reader.readAsDataURL(selectedFile);
                        });
                    </script>

                </div>
            </div>
        </div>
        <div class="col-md-8  p-2" style="border-radius: 11px;background: #ededed;box-shadow:  35px 35px 70px #c9c9c9, -35px -35px 70px #ffffff;">
            <div class="container">
                <h1 class="text-center">The Information</h1>
                <form action="index.php?action=user&act=info" method="post">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Username: </span>
                        <input name="username" type="text" class="form-control" value="<?php echo $userInfor->getInfor($_COOKIE['userId'])[2]; ?>" readonly="true" ondblclick="this.readOnly=false" required>

                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Email </span>
                        <input name="email" type="text" class="form-control" value="<?php echo $userInfor->getInfor($_COOKIE['userId'])[4]; ?>" readonly="true">

                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Phone Number:</span>

                        <input type="text" class="form-control" value="<?php echo $userInfor->getInfor($_COOKIE['userId'])[5]; ?>" readonly="true" name="phonenumber" ondblclick="this.readOnly=false" id="phonenumber">

                    </div>

                    <div class="alert alert-danger" id="checkphone" style="display:none">
                        <strong>Wrong Format!</strong> Please enter the correct phone number
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Your Address:</span>

                        <input type="text" class="form-control" value="<?php echo $userInfor->getInfor($_COOKIE['userId'])[6]; ?>" readonly="true" name="address" ondblclick="this.readOnly=false">
                    </div>
                    <button type="submit" name="updateInfor" class="btn btn-primary" id="updateInfor" style="display:none">Update</button>

                </form>
            </div>
        </div>
    </div>

</div>
<script>
    document.querySelector("#phonenumber").addEventListener('input', () => {
        if (/^(0|84)(2(0[3-9]|1[0-6|8|9]|2[0-2|5-9]|3[2-9]|4[0-9]|5[1|2|4-9]|6[0-3|9]|7[0-7]|8[0-9]|9[0-4|6|7|9])|3[2-9]|5[5|6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])([0-9]{7})$/.test(document.querySelector("#phonenumber").value.trim())) {
            document.querySelector("#checkphone").style.display = "none";
        } else {
            document.querySelector("#checkphone").style.display = "block";
        }
    })
    const inputs = document.querySelectorAll("#body > div.creative > div > div.tab-content > div > div > div.col-md-8 > div > form > div > input");
    inputs.forEach((e) => {
        e.addEventListener('input', () => {
            document.querySelector("#updateInfor").style.display = "block";
        })


    })
</script>