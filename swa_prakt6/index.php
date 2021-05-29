<?php
  session_start();

  if ($_FILES["dispic"]["error"] > 0) {
    echo '<div class="container alert alert-danger alert-dismissible fade show" role="alert" style="position:absolute; top: 1rem;">Error '. $_FILES["dispic"]["error"] .'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
  }
  else {
# ---------------------------------- FIX ----------------------------------
    # restrict filesize to max 200kB
    $maxSize = 200000;
    # restrict file-upload to .jpg and .png files
    $allowed_ext = array("jpg", "jpeg", "png");
    # getting extension of file to upload
    $info = new SplFileInfo($_FILES["dispic"]["name"]);
    $ext = $info->getExtension();
    # check if file extension is allowed
    if ($ext != "") {
      if (!in_array($ext, $allowed_ext) || $_FILES["dispic"]["size"] > $maxSize) {
        echo '<div class="container alert alert-danger alert-dismissible fade show" role="alert" style="position:absolute; top: 1rem;">Oops, something went wrong. Please try uploading a valid JPG- or PNG-File (200kB max.).<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
      } else {
        $dest_dir = "uploads/";
        $dest = $dest_dir . bin2hex(uniqid(rand(), true)) . '.' . $ext;
        $src = $_FILES["dispic"]["tmp_name"];
        if (move_uploaded_file($src, $dest)) {
          $_SESSION["dispic_url"] = $dest;
          chmod($dest, 0644);
          echo '<div class="container alert alert-success alert-dismissible fade show" role="alert" style="position:absolute; top: 1rem;">Successfully uploaded your profile picture.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    }
  }
}
# ---------------------------------- END FIX ----------------------------------

  $url = "./default.png";
  if (isset($_SESSION["dispic_url"])) {
    $url = $_SESSION["dispic_url"];
  }

?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>SWA Social Network</title>
  </head>
  <style>
    body {
      width: 100%;
      height: 100vh;
      display: grid;
      place-items: center;
    }
    .bg-soft{
      background: #fbfbfd;
    }
  </style>
  <body class="">
    <div class="container rounded p-5 bg-soft" style="position: relative;">
      <h1 class="display-5 mb-5 text-center">Welcome to the <span class="badge bg-primary">SWA</span> Social Network!</h1>
        <img src=<?php echo $url; ?> class="rounded mx-auto mb-5 d-block shadow-lg" width=250 height=auto />
        <?php
          if (!isset($_SESSION["dispic_url"])) {
            echo '<div class="mt-3 alert alert-info alert-dismissible fade show" role="alert">Oh, looks like you don\'t have a profile image -- upload one now!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
          }
        ?>
        <form class="input-group mt-3 col-md-3" method="post" enctype="multipart/form-data">
          <input type="file" name="dispic" class="form-control">
          <input class="btn btn-primary" type="submit" value="Upload!">
        </form>
        <p class="container text-center text-black-50" style="position:absolute; bottom:-3rem;left:0;">status: <span class="badge bg-success text-light">secure</span> | <a href="https://github.com/NicolaiKuertoes/swa-writeups/tree/master/swa_prakt6#swa---praktikum-6" target="_blank">write-up</a> </p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  </body>
</html>
