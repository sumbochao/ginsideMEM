<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Authen Page</title>
        <meta name="msapplication-TileColor" content="#5bc0de" />
        <meta name="msapplication-TileImage" content="assets/img/metis-tile.png" />

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php echo base_url('assets/lib/bootstrap/css/bootstrap.min.css') ?>" />

        <!-- Metis core stylesheet -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css') ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/lib/magic/magic.css') ?>">
        <script src="<?php echo base_url('assets/lib/jquery.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/lib/bootstrap/js/bootstrap.min.js') ?>"></script>
		<style>
			.form-signin{
				background: #fff;
				border-radius: 6px; 
				-webkit-border-radius: 6px; 
				-moz-border-radius: 6px; 
				
				-webkit-box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);
				-moz-box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);
				-o-box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);
				-khtml-box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);
				box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);
			}
			.login{
				background: #fafafa!important;
			}
		</style>
    </head>
    <body class="login">
        <div class="container">
            <div class="text-center">
                <img src="assets/img/logo.png" alt="Metis Logo">
            </div>
			<br>
            <div class="tab-content">
                <div id="login" class="tab-pane active">
                    <form action="<?php echo base_url('?control=login&func=googleauthencator') ?>" method="POST" class="form-signin">
                        <p class="text-muted text-center">
                            <?php echo @$error_string ?>
                        </p>
						<h3>Xác minh bước 2</h3>
                        <div style="font-weight: bold">
							<img src="assets/img/phone.png" style="float: left">
							Nhập mã xác minh được tạo bởi ứng dụng dành cho điện thoại di động của bạn
						</div>
						<input type="text" placeholder="Nhập mã" name="code" id="code" class="form-control" autocomplete="off" style="border-radius:0" value="<?php echo $_POST['code']?>">
                        
                        <p class="text-muted text-center"></p>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Xác minh</button>
                    </form>
                </div>

            </div>

        </div><!-- /container -->

        <script>
			window.onload=function(){
				document.getElementById('code').focus(); 
			};
			
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
