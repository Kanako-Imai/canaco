<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>canaco Signin</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.0/examples/sign-in/signin.css" rel="stylesheet">
</head>

<body class="text-center">
    
    <form class="form-signin" method="POST" id="signinForm"> <!-- フォームにIDを追加 -->
        <!-- <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
        <img class="mb-4" src="./upload/canacoちゃん.jpeg" alt="" width="120" height="160"> 
        <h1>Welcome to canaco</h1>
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="text" name="lid" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="lpw" class="form-control" placeholder="Password" required>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" data-action="login">Sign in</button>
        <button class="btn btn-lg btn-primary btn-block" type="submit" data-action="register">メールアドレスで登録</button>
        <!-- <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p> -->
    </form>

    <script>
        document.getElementById('signinForm').addEventListener('submit', function(event) {
            // ボタンのdata-action属性を取得
            var action = event.submitter.getAttribute('data-action');

            // ボタンによって異なるアクションを実行
            if (action === 'login') {
                this.action = 'login_act.php';
            } else if (action === 'register') {
                this.action = 'user.php';
            }
        });
    </script>
</body>

</html>