<html>
<head>
    <title>Login with Facebook | arjunphp.com</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
</head>
<body>

    <div class="container">

        <form class="form-signin" role="form">
            <?php if (@$user_profile):  // call var_dump($user_profile) to view all data ?>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <img class="img-thumbnail" data-src="holder.js/140x140" alt="140x140" src="https://graph.facebook.com/<?=$user_profile['id']?>/picture?type=large" style="width: 140px; height: 140px;">
                        <h2><?=$user_profile['name']?></h2>
                        <a href="<?=$user_profile['link']?>" class="btn btn-lg btn-default btn-block" role="button">View Profile</a>
                        <a href="<?= $logout_url ?>" class="btn btn-lg btn-primary btn-block" role="button">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <h2 class="form-signin-heading">Login with Facebook</h2>
                <a href="<?= $login_url ?>" class="btn btn-lg btn-success btn-block" role="button">Login</a>
            <?php endif; ?>
           

       
        </form>

 

    </div> <!-- /container -->
    <script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>