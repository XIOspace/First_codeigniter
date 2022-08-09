<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>

      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <!-- Optional theme -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-9 offset-4">
        <h4><?= $title ?></h4>
        <hr>
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Image</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">
                <img src="/images/<?= $userInfo[0]['avatar'] ?>" alt="" width="200" height="150">
                <form action="<?= base_url('auth/uploadImage'); ?>" enctype="multipart/form-data" method="post">
                  <input type="file" class="form-control" name="userImage" id="userImage" size="10">
                  <hr>
                  <input type="submit" class="btn btn-primary" value="上傳">
                </form>
              </th>
              <td><?= $userInfo[0]['username'] ?></td>
              <td><?= $userInfo[0]['email'] ?></td>
              <td><a href="<?= site_url('auth/logout') ?>">Log Out</a></td>
            </tr>
          </tbody>
        </table>


        <?php 
          if(!empty(session()->getFlashdata('success'))) {
            ?>
              <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
              </div>
            <?php 
          }else if(!empty(session()->getFlashdata('fail'))) {
            ?>
              <div class="alert alert-danger">
                <?= session()->getFlashdata('fail') ?>
              </div>
            <?php 
          }
        ?>


      </div>
    </div>
  </div>
</body>
</html>