<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login Page</title>
        <meta name="msapplication-TileColor" content="#5bc0de" />
        <meta name="msapplication-TileImage" content="assets/img/metis-tile.png" />

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php echo base_url('assets/lib/bootstrap/css/bootstrap.min.css') ?>" />

        <!-- Metis core stylesheet -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/lib/magic/magic.css') ?>">
        <script src="<?php echo base_url('assets/lib/jquery.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/lib/bootstrap/js/bootstrap.min.js') ?>"></script>
    </head>
    <body class="login">
		<style>
            .form_remember{
                background: #FFF;
                border-radius: 2px;
                padding: 10px;
                margin-top: 5px;
            }
        </style>
        <script>
            $(document).ready(function() {
                $('.remember').click(function(){
                    $('.remember').val($(this).is(':checked') ? '1' : '0' );
                });
				$('.testaccount').click(function(){
                    $('.testaccount').val($(this).is(':checked') ? '1' : '0' );
                });
            });
        </script>
        <div class="container">
            <div class="text-center">
                <img src="assets/img/logo.png" alt="Metis Logo">
            </div>
            <div class="tab-content">
                <div id="login" class="tab-pane active">
                    <form action="<?php echo base_url('?control=login&func=index') ?>" method="POST" class="form-signin">
                        <p class="text-muted text-center">
                            <?php echo $error_string ?>
                        </p>
                        <input type="text" placeholder="Tên đăng nhập" name="username" class="form-control">
                        <input type="password" placeholder="Mật khẩu" name="password" class="form-control">
                        <input type="text" placeholder="Mã xác thực" name="captcha" class="form-control" autocomplete="off">
                        <div  class="form-control" style="background-color: white;text-align: center;height: 60px;">
                            <!--<img src="<?php echo base_url('?control=login&func=captcha') ?>&<?php echo time() ?>.jpg" />-->
							<img src="<?php echo '/captcha' ?>" />
                        </div>
						<div class="form_remember">
                            <input type="checkbox" class="remember" name="remember" value="0"/> Ghi nhớ
							<?php
								if($_GET['a']==1){
							?>
							<input type="checkbox" value="0" name="testaccount" class="testaccount"> Test
							<?php
								}
							?>
                        </div>
                        <p class="text-muted text-center"></p>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Đăng nhập</button>
                    </form>
                </div>

            </div>

        </div><!-- /container -->

        <script>
            $('.list-inline li > a').click(function() {
                var activeForm = $(this).attr('href') + ' > form';
                //console.log(activeForm);
                $(activeForm).addClass('magictime swap');
                //set timer to 1 seconds, after that, unload the magic animation
                setTimeout(function() {
                    $(activeForm).removeClass('magictime swap');
                }, 1000);
            });
        </script>
    </body>
</html>
