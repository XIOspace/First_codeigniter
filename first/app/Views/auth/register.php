<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <div class="row mt-3">
      <div class="col-md-6 offset-md-3">
        <br>
        <h4>註冊</h4>
        <hr>
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
        <form action="<?= base_url('auth/registerUser') ?>" method="post" class="form mb-3">
          <?= csrf_field(); ?>
          <div class="form-group">
            <label for="username">名字</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="請輸入名字" value="<?= set_value('username') ?>">
            <span class="text-danger text-sm">
              <?= isset($validation) ? display_form_error($validation, 'username','名字'):''; ?>
            </span>
          </div>
          
          <br>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?= set_value('email') ?>">
            <span class="text-danger text-sm">
              <?= isset($validation) ? display_form_error($validation, 'email','Email'):''; ?>
            </span>
          </div>
          <br>
          <div class="form-group">
            <label for="password">密碼</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="請輸入密碼" value="<?= set_value('password') ?>">
            <span class="text-danger text-sm">
              <?= isset($validation) ? display_form_error($validation, 'password','密碼'):''; ?>
            </span>
          </div>
          <br>
          <div class="form-group">
            <label for="confirm_password">確認密碼</label>
            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="再輸入一次密碼" value="<?= set_value('confirm_password') ?>">
            <span class="text-danger text-sm">
              <?= isset($validation) ? display_form_error($validation, 'confirm_password','密碼確認'):''; ?>
            </span>
          </div>
          <br>
          <button type="submit" class="btn btn-primary">註冊</button>
        </form>
        <a href="<?= site_url('auth'); ?>" class="btn mt-3">已經有帳號？登入吧</a>
      </div>
    </div>
  </div>
</body>
</html>