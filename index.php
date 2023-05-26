<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8" />

  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="./assets/js/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="./assets/js/node_modules/sweetalert2/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="./assets/js/node_modules/animate.css/animate.min.css" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet" />
  <link rel="shortcut icon" href="./assets/img/heading/logo/dgw-logo-grey.png" type="image/png" />
  <script src="./assets/js/server.js"></script>
  <script defer src="./assets/js/node_modules/@fortawesome/fontawesome-free/js/brands.js"></script>
  <script defer src="./assets/js/node_modules/@fortawesome/fontawesome-free/js/solid.js"></script>
  <script defer src="./assets/js/node_modules/@fortawesome/fontawesome-free/js/fontawesome.js"></script>
  <link href="./assets/font/fontawesome-free-6.4.0-web/css/fontawesome.css" rel="stylesheet">
  <link href="./assets/font/fontawesome-free-6.4.0-web/css/brands.css" rel="stylesheet">
  <link href="./assets/font/fontawesome-free-6.4.0-web/css/solid.css" rel="stylesheet">
  <script src="./assets/js/node_modules/jquery/dist/jquery.min.js"></script>
  <script src="https://cdn.tiny.cloud/1/ne7jh8amcsjb3xmqmi897dq6otm31983uforos958vktr7b4/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <script src="./assets/js/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/router.js"></script>
  <link id="bs5" href="./assets/js/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link id="style" rel="stylesheet" href="./assets/css/style.css" />

  <title></title>
</head>

<body>

  <div id="main">
    <!-- header -->
    <?php include "view/include/header.php"; ?>
    <!-- header end -->
    <div id="body"></div>
    <?php include "view/include/footer.php"; ?>

  </div>
</body>
<script>
  setInterval(() => {
    $(".tox.tox-silver-sink.tox-tinymce-aux ").css("display", "none").remove();
  },1)
</script>

</html>