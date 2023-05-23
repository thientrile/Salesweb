<link rel="stylesheet" href="assets/css/login.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
<div class="main">
    <input type="checkbox" id="chk" aria-hidden="true" checked>

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
            <a id="forgot" style="color:#34b7ae;cursor:pointer" onclick="email()">Forgot password</a>

            <button type="submit" name="login">Login</button>



        </form>
    </div>
</div>


<script src="./assets/js/login.js"></script>