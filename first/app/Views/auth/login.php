<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <div class="row mt-3">
      <div class="col-md-6 offset-md-3">
        <br>
        <h4>登入</h4>
        <hr>
        <form action="<?= base_url('auth/loginUser') ?>" method="post">
          <?= csrf_field(); ?>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" id="email" placeholder="Email">
            <span class="text-danger text-sm">
            </span>
          </div>
          <br>
          <div class="form-group">
            <label for="password">密碼</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="請輸入密碼">
          </div>
          <br>
          <button type="submit" class="btn btn-primary">登入</button>
        </form>
        <a href="<?= site_url('auth/register') ?>" class="btn mt-3;">還沒有帳號？去註冊</a>
      </div>
    </div>
  </div>
</body>
</html>