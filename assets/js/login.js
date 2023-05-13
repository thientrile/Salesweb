const formMain = `<input type="checkbox" id="chk" aria-hidden="true" >

<div class="signup">

    <form id="login" class="was-validated">
        <label for="chk" aria-hidden="true">Login</label>
        <input class="form-control" type="email" name="log-email" placeholder="Email" required="" value="">
        <span class="error">Email or password is incorrect</span>
        
        <input class="form-control" type="password" name="log-pswd" placeholder="Password" required="" value="">
        <a href="#" id="forgot" onclick="email()">Forgot password</a>

        <button type="submit" name="login">Login</button>
   


    </form>
</div>

<div class="login">
    <form id="signup">
        <label for="chk" aria-hidden="true">Sign up</label>
        <input type="text" name="username" placeholder="User name" required="" >

        <input type="email" name="email" placeholder="Email" required="" oninput="checkEmail(this.value)" >
        <span class="error">This email already exists</span>

        <input type="password" name="pswd" placeholder="Password" required=""  >


        <button type="submit" name="sign-up">Sign up</button>

    </form>
</div>`;
const formEmail = `<div class="email">
<form id="form-email">
    <label for="email">Enter your email</label>
    <input type="text" name="email" pattern="^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$" invalid="Email address is not valid">
    <button type="submit" name="btnEmail">Confirm</button>
    <a class="crike-return" href="#" id="return" onclick="Main()"><i class="fa-solid fa-circle-left"></i></a>
</form>
</div>`;
const formCode = `<div class="confirm">
<form id="form-code">
    <label for="code">Email confirmation code</label>
    <input type="number" name="codeConfirm" min="1000" max="9999">
    <?php
    echo $error_Confirm;
    ?>
    <button type="submit" name="btnConfirm">Confirm</button>
</form>
</div>`;
const formpswd = `<div class="password">
<form id="new-pswd" >
    <label for="pswd">Enter your new password</label>
    <input type="text" name="pswdConfirm">
    <?php echo $error_Confirm; ?>
    <button type="submit" name="btnPswd">Confirm</button>
</form>
</div>`;

function email() {
  $(".main").html(formEmail);
}

function Main() {
  $(".main").html(formMain);
}

function checkEmail(value) {
  return new Promise((resolve, reject) => {
    let formData = new FormData();
    formData.append("email", value);

    $.ajax({
      url: "server.php?action=checkmail",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (res, req) {
        if (res.data == true) {
          $("#signup > span").css("display", "flex");
        } else {
          $("#signup > span").css("display", "none");
        }
        resolve(res.data);
      },
      error: function (error) {
        reject(error);
      },
    });
  });
}

$(function () {
  $("#login > span").css("display", "none");
  Main();

  $("#login").submit(function (event) {
    event.preventDefault();

    let formData = new FormData(this);

    $.ajax({
      url: "server.php?action=login",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (res, req) {
        // handle the response from the PHP script

        if (res.status == "success") {
          $("#login > span").css("display", "none");
          window.location.replace("http://demo.local/index.php?action=home");
        } else {
          $("#login > span").css("display", "flex");
        }
      },
      error: function (xhr, status, error) {
        // handle errors
        console.log(xhr, status, error);
      },
    });
  });
  $("#signup").submit(function (event) {
    event.preventDefault();
    let formData = new FormData(this);
    checkEmail(formData.get("email")).then((data) => {
      if (!data) {
        $.ajax({
          url: "server.php?action=signup",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          dataType: "json",
          success: function (res, req) {
            console.log(true);
            window.location.replace("http://demo.local/index.php?action=home");
          },

          error: function (xhr, status, error) {
            // handle errors
            console.log(error);
          },
        });
      }
    });
  });
});
