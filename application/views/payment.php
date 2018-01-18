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
    $(document).ready(function(){
        $('input').click(function(){
            var type=$(this).attr('type');
            if(type=='text' || type=='password')
                showNativeInput($(this).attr('id'), $(this).val());
        });
    });
    $(function() {

        $("#close_dialog").click(function() {
            hide_dialog();
        });

        $(".pick_card").click(function() {
            $("#nap_the").show();
            $(".blackscreen").show();
            var card = $(this).attr("data");
            $("#card_type").val(card);
        });

        $(".dong_y").click(function() {
            hide_dialog();
            paycard();
            return false;
        });
    });

    function check_exist(data, text) {
        
        if (typeof data === 'undefined' || data === 'textpage' || data === null || data === "") {
            show_dialog(text);
            return false;
        }
        return data;
    }

    function paycard() {
        var card_serial_number = check_exist($("#card_serial_number").val(), 'Vui lòng nhập số serial ');
        var card_code = check_exist($("#card_code").val(), 'Vui lòng nhập mã thẻ');
        var card_type = $("#card_type").val();
        
        if(!card_serial_number || !card_code){
            return false;
        }
        card_code=rsa_encrypt(card_code);
        card_serial_number=rsa_encrypt(card_serial_number);
        loading();
        $.ajax({
            dataType: "json",
            type: "GET",
            url: base_url + "ajax/?control=payment&func=paycard&serial=" + card_serial_number + "&code=" + card_code + "&cardtype=" + card_type + '&<?php echo $params; ?>',
            success: function(rs) {
                if (rs.code === 50) {
                    show_dialog(rs.data.data.msg);
                    $("#card_serial_number").val('');
                    $("#card_code").val('');
                    hide_nap_the();
                }
                else {
                    show_dialog('Nạp thẻ thất bại, thông tin thẻ không đúng hoặc đã được sử dụng');
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

    function hide_nap_the() {
        $("#nap_the").hide();
        $(".blackscreen").hide();
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
    function showNativeInput(textboxId, text) {
        console.log(textboxId + '=' + text);
        try {

            ANDROID.showNativeInput(textboxId, text)
        }
        catch (e) {

        }
    }
    function setText(textboxId, text) {
        console.log(textboxId + '=' + text);
        var tb = document.getElementById(textboxId);
        if (typeof (tb) != 'undefined')
            tb.value = text;
    }
</script>

<div id="page_wrapper">
    <div class="blackscreen"></div>
    <div id="nap_the" style="display:none">
        <div class="poup_nap">
            <div class="pay_header">
                <span class="title">Thông tin nạp</span>
            </div>

            <input id="card_type" type="hidden" value="" />
            <table>
                <tr>
                    <td width="60px" class="text">Số seri :</td>
                    <td class="input"><input id="card_serial_number" type="text" /></td>
                </tr>
                <tr>
                    <td class="text">Mã thẻ :</td>
                    <td class="input"><input id="card_code" type="text" /></td>
                </tr>
                <tr>
                    <td colspan="2" class="button"> 
                        <button class="dong_y">Đồng ý</button>
                        <button class="huy" onclick="hide_nap_the()">Thôi</button >
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="poup_payment">
        <div class="pay_header">
            <span class="title"></span>
        </div>
        <div class="poup_payment_inner">		
            <div class="pay_nav">
                <div class="cot1"><a href="javascript:;">Sự kiện</a></div>
                <div class="cot2"><a href="javascript:;">Radio</a></div>
                <div class="cot3"><a href="javascript:;">Hỗ trợ trực tuyến</a></div>
                <div class="clear"></div>
            </div>

            <?php if (!empty($paylist['card'])): ?>
                <div class="spe_sub">
                    Nạp bằng card điện thoại (<?php echo count($paylist['card']) ?>) - 1.000 VND = 10 KNB
                </div>
                <div class="list_card">
                    <ul>
                        <?php foreach ($paylist['card'] as $key => $value): ?>
                            <li>
                                <a href="#" data="<?php echo $value['card'] ?>" class="pick_card"><?php echo $value['description'] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if (!empty($paylist['sms'])): ?>
                <div class="spe_sub">
                    Nạp bằng SMS (<?php echo count($paylist['sms']) ?>)
                </div>
                <div class="list_sms">
                    <ul>
                        <?php foreach ($paylist['sms'] as $sms): ?>
                            <li>
                                <a href="<?php echo $urlSchema?>://method=sms&message=<?php echo $sms['content'] ?>&phone=<?php echo $sms['phone'] ?>" title="<?php echo $sms["message"] ?>" data-content="<?php echo str_replace("{transaction}", $this->transaction_id, $sms['content']) ?>" data-phone="<?php echo $sms['phone'] ?>">
                                    <span class="sms_title"><?php echo $sms['message'] ?> - 50 KNB</span>
                                    <span class="soantin"><?php echo $sms['description'] ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if (!empty($paylist['inapp_apple'])): ?>
                <div class="spe_sub">
                    Nạp thông qua Appstore (<?php echo count($paylist['inapp_apple']) ?>)
                </div>
                <div class="list_inapp">
                    <ul>
                        <?php foreach ($paylist['inapp_apple'] as $apple): ?>
                            <li>

                                <a href="<?php echo $urlSchema?>://method=apple&code=<?php echo $apple['code'] ?>" title="<?php echo $apple["message"] ?>" >
                                    <?php echo $apple['description'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>	
            <?php endif; ?>
        </div>
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
    <div id="error" style="width:100%;position: fixed;top: 0px;left: 0px;display: inline;background: red;color: yellow;padding: 3px 0 3px 0;text-align: center;font-weight: bold"><?php echo $error?></div>
<?php
}
?>