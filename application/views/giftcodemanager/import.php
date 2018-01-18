<?php 
error_reporting(0);
?>
<style>
    .textinput {
        width: 300px;
        border: 1px solid #c5c5c5;
        padding: 6px 7px;
        color: #323232;
        margin: 0;

        background-color: #ffffff;
        outline: none;

        /* CSS 3 */

        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        -o-border-radius: 4px;
        -khtml-border-radius: 4px;
        border-radius: 4px;

        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -khtml-box-sizing: border-box;

        -moz-box-shadow: inset 0px 1px 3px rgba(128, 128, 128, 0.1);
        -o-box-shadow: inset 0px 1px 3px rgba(128, 128, 128, 0.1);
        -webkit-box-shadow: inset 0px 1px 3px rgba(128, 128, 128, 0.1);
        -khtml-box-shadow: inset 0px 1px 3px rgba(128, 128, 128, 0.1);
        box-shadow: inset 0px 1px 3px rgba(128, 128, 128, 0.1);
    }

    input:focus.textinput {
        box-shadow: 0 0 10px #cdec96;
        background-color: #d6f8ff;
        color: #6d7e81;
    }

    label {
        width: 150px;
        color: #f36926;
    }

    .game-button {
        border: 0;
        outline: none;
        padding: 6px 9px;
        margin: 2px;
        cursor: pointer;
        font-family: 'PTSansRegular', Arial, Helvetica, sans-serif;
        /* CSS 3 */
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px !important;
        -o-border-radius: 3px;
        -khtml-border-radius: 3px;
        border-radius: 3px;

        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.4);

        color: #fff;
        text-shadow: 0 -1px 1px rgba(0, 0, 0, .25);
        background-color: #019ad2;
        background-repeat: repeat-x;
        background-image: -moz-linear-gradient(#33bcef, #019ad2);
        background-image: -ms-linear-gradient(#33bcef, #019ad2);
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #33bcef), color-stop(100%, #019ad2));
        background-image: -webkit-linear-gradient(#33bcef, #019ad2);
        background-image: -o-linear-gradient(#33bcef, #019ad2);
        background-image: linear-gradient(#33bcef, #019ad2);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bcef', endColorstr='#019ad2', GradientType=0);
        border-color: #057ed0;
        -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1);
    }

    .game-button:hover {
        border: 0;
        outline: none;
        padding: 6px 9px;
        margin: 2px;
        cursor: pointer;
        font-family: 'PTSansRegular', Arial, Helvetica, sans-serif;
        /* CSS 3 */
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px !important;
        -o-border-radius: 3px;
        -khtml-border-radius: 3px;
        border-radius: 3px;

        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.4);

        color: #fff;
        text-shadow: 0 -1px 1px rgba(0, 0, 0, .25);
        background-color: #019ad2;
        background-repeat: repeat-x;
        background-image: -moz-linear-gradient(#019ad2, #33bcef);
        background-image: -ms-linear-gradient(#019ad2, #33bcef);
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #33bcef), color-stop(100%, #019ad2));
        background-image: -webkit-linear-gradient(#019ad2, #33bcef);
        background-image: -o-linear-gradient(#019ad2, #33bcef);
        background-image: linear-gradient(#019ad2, #33bcef);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bcef', endColorstr='#019ad2', GradientType=0);
        border-color: #057ed0;
        -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1);
    }

    .game-button-cancel {
        border: 0;
        outline: none;
        padding: 6px 9px;
        margin: 2px;
        cursor: pointer;
        font-family: 'PTSansRegular', Arial, Helvetica, sans-serif;
        /* CSS 3 */
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px !important;
        -o-border-radius: 3px;
        -khtml-border-radius: 3px;
        border-radius: 3px;

        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.4);

        color: #fff;
        text-shadow: 0 -1px 1px rgba(0, 0, 0, .25);
        background-color: #019ad2;
        background-repeat: repeat-x;
        background-image: -moz-linear-gradient(#555555, #000000);
        background-image: -ms-linear-gradient(#555555, #000000);
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #555555), color-stop(100%, #000000));
        background-image: -webkit-linear-gradient(#555555, #000000);
        background-image: -o-linear-gradient(#555555, #000000);
        background-image: linear-gradient(#555555, #000000);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#555555', endColorstr='#000000', GradientType=0);
        border-color: #057ed0;
        -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1);
    }

    .game-button-cancel:hover {
        border: 0;
        outline: none;
        padding: 6px 9px;
        margin: 2px;
        cursor: pointer;
        font-family: 'PTSansRegular', Arial, Helvetica, sans-serif;
        /* CSS 3 */
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px !important;
        -o-border-radius: 3px;
        -khtml-border-radius: 3px;
        border-radius: 3px;

        text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.4);

        color: #fff;
        text-shadow: 0 -1px 1px rgba(0, 0, 0, .25);
        background-color: #019ad2;
        background-repeat: repeat-x;
        background-image: -moz-linear-gradient(#000000, #555555);
        background-image: -ms-linear-gradient(#000000, #555555);
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #000000), color-stop(100%, #555555));
        background-image: -webkit-linear-gradient(#000000, #555555);
        background-image: -o-linear-gradient(#000000, #555555);
        background-image: linear-gradient(#000000, #555555);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bcef', endColorstr='#019ad2', GradientType=0);
        border-color: #057ed0;
        -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .1);
    }

    ul.error {
        padding: 5px;
        background: #f36926;
        margin-bottom: 30px;
    }

    ul.error li {
        margin-left: 20px;
        color: #eee;
    }

    #content-t input[type="checkbox"] {
        text-align: left;
        width: 20px;
    }
</style>
<style>
    #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
    #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100}
    .frmedit .form-group {float: left;width: 25%;}
    .frmedit .form-group label {/*width: 35%;*/}
    .frmedit .form-group input {/*width: 50%;*/}
    .contronls-lab label{color: red;font-weight: bold;}
    .totalchest>div{margin-bottom: 10px}
    .error{color: red;font-weight: bold;}
    .clear{clear: both}
    .percent{color: blue;font-weight: bold}
</style>
<!--<script type="text/javascript" src="/libraries/bootstrap/plugins/bootbox/bootbox.js"></script>-->
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/files/bootstrap.min.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/functions/components.js"></script>


<link href="/libraries/pannonia/pannonia/css/bootstrap.css" rel="stylesheet" type="text/css" />



<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/ui/jquery.easytabs.min.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/ui/jquery.collapsible.min.js"></script>
<!--<script type="text/javascript" src="/libraries/bootstrap/plugins/bootbox/bootbox.js"></script>-->
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/ui/jquery.jgrowl.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.uniform.min.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.select2.min.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validation.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/tables/jquery.dataTables.min.js"></script>



<script>
    $(document).ready(function () {
        $('#typeGame').change(function () {
            groupmenu = $(this).val();
            html = "";
            html += "<option value='0' selected>---Chon GiftCode---</option>";
            if (groupmenu == 0) {
                alert('Vui lòng chọn Game');
                return false;
            }
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/?control=giftcodemanager&func=ajaxloadgame",
                data: {idgame: groupmenu},
                beforeSend: function () {
                    console.log('starting...');
                }
            }).done(function (result) {
                console.log(result);
                //hide your loading file here
                $.each(result.data, function (key, el) {
                    html += "<option value='" + el.idx + "' >" + el.display_name + "</option>";
                });

                $('#typegiftcode').html(html);

            });
        });

        $('#onSubmit').on('click',function() {

            if ($('#frmSendChest').validationEngine('validate') === false)
                return false;

            $('#frmSendChest').submit();
        });

    });

</script>

<div id="content-t" style="width: 100%;min-height:500px;text-align: center;">

    <!--BEGIN CONTROL ADD CHEST-->
    <form id="frmSendChest" name="frmSendChest" action="" method="POST"  autocomplete="off"  enctype="multipart/form-data">
        <div class="widget row-fluid">
            <div class="form-horizontal">

                <div class="control-group">
                    <label class="control-label">Type Game:</label>
                    <div class="controls">
                        <select name="typeGame" id="typeGame" class="span4 validate[required]">
                            <option value="0" selected>---Chon Game---</option>
                            <?php
                            foreach ($menu_game as $g) {
                                ?>
                                <option value="<?php echo $g['alias'] ?>" selected><?php echo $g['display_name'] ?></option>

                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
				
				
                <div class="control-group">
                    <label class="control-label">Type GiftCode:</label>
                    <div class="controls">
                        <select name="typegiftcode" id="typegiftcode" class="span4 validate[required]">

                        </select>
                    </div>
                </div>
				
				<div class="control-group">
                    <label for="typeParnet" class="control-label">Type Genaral</label>
                    <div class="controls">
                        <select name="typeParnet" id="typeParnet" class=" span4 validate[required]">
                            <option value="0" selected>---Chon Loại GiftCode---</option>
                            <?php
                            foreach ($group_menu as $g) {
                                ?>
                                <?php
                                if ($g['id'] == $menu_group_id) {
                                    ?>
                                    <option value="<?php echo $g['id'] ?>" selected><?php echo $g['name'] ?></option>
                                <?php
                                } else {
                                    ?>
                                    <option value="<?php echo $g['id'] ?>"><?php echo $g['name'] ?></option>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        </select>
                    </div>



                </div>
				

                <div class="control-group">
                    <label class="control-label">FILES:</label>
                    <div class="controls">
                       <input type="file" name="file_source" id="file_source" class="edt span4 validate[required]" value="">
                    </div>
                </div>






                <div class="control-group" style="text-align: left">
                    <span class="error"><?php echo (!empty($message))?$message:""; ?></span>
                </div>

                <div class="control-group">
                    <div style="padding-left: 20%; text-align:left;">
                        <input type="hidden" name='actorOrder' value="<?php echo $_SESSION['account']['username'];?>">
                        <input id="onSubmit" name="Go" type="submit" class="base_button base_green base-small-border-radius game-button" value="Thực hiện" /></button>
                        <button id="comeback" class="base_button base_green base-small-border-radius game-button-cancel" onclick='onCancel()'><span>Quay lại</span></button>
                        <div style="display: inline-block">
                            <span id="message" style="color: green"></span>
                        </div>
                    </div>
                </div>


                <div class="control-group">
                    <div style="clear: both"></div>
                    <br>
                    <?php echo $menuId ?>
                    <?php echo $button ?>

                </div>

            </div>
    </form>
    <!--END CONTROL ADD CHEST-->


</div>
<script>
    function onCancel() {
        var theform = document.frmadd;
        theform.action = "<?php echo base_url()?>?control=menu&func=index";
        theform.submit();
        return true;
    }
</script>

<style>
    .row-fluid [class*="span"]:first-child {
        margin-left: 0;
    }
    .row-fluid .span4 {
        width: 31.914893617021278%;
    }
    @media (max-width: 1024px) {
        [class*="span"], .uneditable-input[class*="span"], .row-fluid [class*="span"] {
            display: block;
            float: none;
            width: 100%;
            margin-left: 0;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
    }
    .form-horizontal .control-label{font-size: 13px;font-weight: bold;}
</style>