const formMain = `   <input type="checkbox" id="chk" aria-hidden="true" checked>

<div class="signup">
    <form class="form-data" onsubmit=" Sigin(this, event)">
        <label for="chk" aria-hidden="true">Sign up</label>
        <input type="text" name="username" placeholder="User name" required="" oninput="checkusername(this)">
        <span class="error username">Invalid username</span>

        <input type="email" name="email" placeholder="Email" required="" oninput="checkEmail(this)">

        <input type="password" name="pswd" placeholder="Password" required="" oninput="checkpswd(this)">
        <span class="error pswd"></span>


        <button type="submit" name="sign-up">Sign up</button>

    </form>

</div>

<div class="login">
    <form class=" form-data" onsubmit="Login(this,event)">
        <label for="chk" aria-hidden="true">Login</label>
        <input class="form-control" type="email" name="email" placeholder="Email" required="" value="">
        <span class="error">Email or password is incorrect</span>

        <input class="form-control" type="password" name="pswd" placeholder="Password" required="" value="" oninput="checkpswd(this)">
        <a id="forgot" style="color:#34b7ae" onclick="email()">Forgot password</a>

        <button type="submit" name="login">Login</button>



    </form>
</div>`;
const formEmail = `<div class="email">
<form id="form-email">
    <label for="email">Enter your email</label>
    <input type="text" name="email" id="email">
    <button type="submit" name="btnEmail">Confirm</button>
    <button type="button" name="return" onclick="Main()">Log in to your account</button>

</form>
</div>`;
const formCode = `<div class="confirm">
<form id="form-code">
    <label for="code">Email confirmation code</label>
    <input type="number" name="code" min="1000" max="9999" id="code">
    
    <button type="submit" name="btnConfirm">Confirm</button>
</form>
</div>`;
const formpswd = `<div class="password">
<form id="new-pswd" >
    <label for="pswd">Enter your new password</label>
    <input type="text" name="pswdConfirm">
    
    <button type="submit" name="btnPswd">Confirm</button>
</form>
</div>`;

function email() {
  $(".main").html(formEmail);
}

function Main() {
  $(".main").html(formMain);
}
function code() {
  $(".main").html(formCode);
}
function checkEmail(e) {
  let Server = new server();
  let data = new FormData();
  data.append("email", e.value);
  Server.post("action=checkvalid&function=email", data)
    .then((res, rep) => {
      if (res.status) {
        e.setCustomValidity("This email already exists");
        e.reportValidity();
      } else {
        e.setCustomValidity("");
        e.reportValidity();
      }
    })
    .catch((xhr, status, error) => {
      console.log(xhr.responseText, status, error);
    });
}
function checkusername(e) {
  let regex = /^[^0-9\W]\S{4,}$/;
  let value = e.value;
  if (!regex.test(value)) {
    e.setCustomValidity("Invalid username");
    e.reportValidity();
  } else {
    e.setCustomValidity("");
    e.reportValidity();
  }
}
function checkpswd(e) {
  const lower = new RegExp("(?=.*[a-z])");
  const upper = new RegExp("(?=.*[A-Z])");
  const number = new RegExp("(?=.*[0-9])");
  const special = new RegExp("(?=.*[!@#$%^&*])");
  const length = new RegExp("(?=.{8,})");
  let value = e.value;
  if (!lower.test(value)) {
    e.setCustomValidity("At least one lowercase character");
    e.reportValidity();
  } else if (!upper.test(value)) {
    e.setCustomValidity("At least one uppercase character");
    e.reportValidity();
  } else if (!number.test(value)) {
    e.setCustomValidity("At least one number");
    e.reportValidity();
  } else if (!special.test(value)) {
    e.setCustomValidity("At least one special characte");
    e.reportValidity();
  } else if (!length.test(value)) {
    e.setCustomValidity("At least 8 characters");
    e.reportValidity();
  } else {
    e.setCustomValidity("");
    e.reportValidity();
  }
}
function Login(element, e) {
  if (element.checkValidity()) {
    e.preventDefault();
    let data = new FormData(element);

    let Server = new server();
    Server.post("action=login", data)
      .then((res, req) => {
        if (res.status == "success") {
          window.location.replace("index.php?action=user");
        } else {
          element.querySelector(".error").style.display = "flex";
        }
      })
      .catch((xhr, status, error) => {
        console.log(xhr, status, error);
      });
  }
}

function Sigin(element, e) {
  let data = new FormData(element);
  e.preventDefault();
  let Server = new server();
  Server.post("action=checkvalid&function=codeSigup", data)
    .then((res, req) => {
      if (res.status == "success") {
        code();
        $("#form-code").attr({ onsubmit: "checkSign(this,event)" });
      }
    })
    .catch((xhr, status, error) => {
      console.log(xhr.responseText, status, error);
    });
}
function checkSign(element, e) {
  e.preventDefault();
  let data = new FormData(element);
  let Server = new server();
  Server.post("action=signup", data)
    .then((res, req) => {
      console.log(res);
      window.location.replace("index.php?action=user");
    })
    .catch((xhr, status, error) => {
      console.log((xhr, status, error));
    })
    .finally(() => {
      window.location.replace("index.php?action=login");
    });
}
