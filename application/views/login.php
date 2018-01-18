<script src="<?php echo base_url('assets/account/scripts/rsa.min.js') ?>"></script>
<script>
    // Create the encryption object and set the key.
    function rsa_encrypt(str){
        var crypt = new RSA;
        crypt.setKey('<?php echo $rsa_pub_key?>');
        var enc = crypt.encrypt(str);
        return enc;
    }
</script>

<script type="text/javascript">
    function check_exist(data) {
        if (typeof data === 'undefined' || data === 'textpage') {
            return false;
        }
    }
    $(function() {
        $("#close_dialog").click(function() {
            hide_dialog();
        });
        $(".btntrial").click(function() {
            trial();
            return false;
        });
        $("#login_form").submit(function() {
            login();
            return false;
        });

        var inputs = $("#login_form :input");
        $(inputs).keypress(function(e) {
            if (e.keyCode === 13) {
                inputs[inputs.index(this) + 1].focus();
                if ($(this).attr("id") === "strPassword") {
                    inputs[inputs.index(this) + 1].click();
                }
                return false;
            }

        });
    });
    function login() {
        var username = $("#strUsername").val();
        var password = ($("#strPassword").val());
        password=rsa_encrypt(password);
        loading();
        $.ajax({
            dataType: "json",
            type: "GET",
            url: base_url + "ajax/?control=user&func=authorize&username=" + username + "&password=" + password + '&<?php echo $params; ?>',
            success: function(rs) {
                if (rs.code === 10) {
                    window.location = rs.data.redirect_uri;
                }
                else {
                    show_dialog(rs.message);
                }
                hide_loading();
            }
        });
        return false;
    }

    function trial() {
        loading();
        $.ajax({
            dataType: "json",
            type: "GET",
            url: base_url + "ajax/?control=user&func=trial&<?php echo $params; ?>",
            success: function(rs) {
                if (rs.code === 10) {
                    window.location = rs.data.redirect_uri;
                }
                else {
                    show_dialog(rs.message);
                }
                hide_loading();
            }
        });
        return false;
    }

    function show_dialog(_string) {
        $("#dialog").show();
        $("#dialog_message").html(_string);
    }
    function hide_dialog() {
        $("#dialog").hide();
        $("#dialog_message").html("");
    }

    function loading() {
        $("#overlay").show();
        $("#loading").css({left: ($(window).width() / 2 - $("#loading").width() / 2) + 'px'})
        $("#loading").show();
    }
    function hide_loading() {
        $("#overlay").hide();
        $("#loading").hide();
    }
</script>
<div class="page_wrapper"> 
    <div class="title_sub">
        <span class="num1">Hãy đăng ký tài khoản MoBo trước khi xóa ứng dụng tránh mất tài khoản Chơi Thử</span>
        <div class="logout"></div>
    </div>
    <div class="login_block">
        <form id="login_form" method="POST">
            <table class="login">
                <tr>
                    <td class="colum1">Tài khoản</td>
                    <td class="colum2"><input autocorrect="off" autocapitalize="off" type="text" id="strUsername" name="username" placeholder="Nhập SĐT hoặc TK IWIN" /></td>
                    <td class="colum3"></td>
                </tr>
                <tr>
                    <td class="colum1">Mật khẩu</td>
                    <td class="colum2"><input autocorrect="off" autocapitalize="off" name="password" id="strPassword" type="password" placeholder="********" value="" /></td>
                    <td class="colum3"><input id="submit_btn" value="Vào game" type="submit" class="submit" /></td>
                </tr>
        </form>
        </table>
        <div class="facebook_login">
            Đăng nhập và vào game tại đây bằng <a href="<?php echo base_url('account/facebook?' . $params); ?>" class="fb_btn"></a>
        </div>
    </div>

    <div class="spe_gradient"></div>
    <div class="dn_dk_2">
        <div class="note">Lưu ý: Hãy đăng ký tài khoản MoBo trước khi xóa ứng dụng tránh mất tài khoản Chơi Thử.</div>
        <a href="#" class="btntrial">Chơi thử</a>
        <a href="<?php echo $urlSchema?>://method=register" class="dangky">Đăng ký</a>
    </div>
</div>

<div id="overlay"></div>
<div id="loading"></div>
<div id="dialog" class="dialog">
    <div class="pay_header">
        <div class="poup_nap">
            <span class="title">Thông báo</span>
        </div>
        <div class="poup_nap">
            <table>
                <tr><td colspan="2" class="text"><div id="dialog_message"></div></td></tr>
                <tr>
                    <td colspan="2" class="button">
                        <button class="huy" id="close_dialog">Đồng Ý</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php
if(isset($error)){
    ?>
    <div id="error" style="z-index:1000;width:100%;position: fixed;top: 0px;left: 0px;display: inline;background: red;color: yellow;padding: 3px 0 3px 0;text-align: center;font-weight: bold"><?php echo $error?></div>
<?php
}
?>