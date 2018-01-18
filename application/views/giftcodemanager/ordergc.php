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
	.remove_field{font-weight: bold;color: blue;}
</style>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/ui/jquery.easytabs.min.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/ui/jquery.collapsible.min.js"></script>
<!--<script type="text/javascript" src="/libraries/bootstrap/plugins/bootbox/bootbox.js"></script>-->
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/ui/jquery.jgrowl.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.uniform.min.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.select2.min.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validation.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/tables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/files/bootstrap.min.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/functions/components.js"></script>


<link href="/libraries/pannonia/pannonia/css/bootstrap.css" rel="stylesheet" type="text/css" />





<script>
    function submitajax(typeParnets,typeGames){
        $.ajax({
            type: "POST",
            url:  "/?control=giftcodemanager&func=ordergc",
            data:{typeParnet:typeParnets,typeGame:typeGames},
            dataType: 'json'
        }).done(function (data) {
            console.log("binh");
            return;
            if (data.code == 0) {
                $(e).hide();
                $("#atimes").text(data.data.times);
                $("#ctimes").val(data.data.times);
                $('#reg-msg').addClass("success");
            }
            $('#reg-msg').text(data.message);
        }).fail(function (data) {
            console.log("eee");
            return;
            $('#reg-msg').text('Hiện tại hệ thống quá tải vui lòng thử lại sau.');
        });
    }
    function checkType(){
        typeParnet = $('#typeParnet').val();
        typeGame = $('#typeGame').val();
        if (typeParnet == 0 || typeGame == 0) {
            $('.control-group .error').text('Thông tin nhập không chính xác vui lòng nhập lại');
            return false;
        }
        return true;
    }
    $(document).ready(function () {
        $('#save').click(function () {
            typeParnet = $('#typeParnet').val();
            typeGame = $('#typeGame').val();
            if (typeParnet == 0 || typeGame == 0) {
                $('#reg-msg').text('Thông tin nhập không chính xác vui lòng nhập lại');
                console.log("sss");
                return false;
            } else {
                //submitajax(typeParnet,typeGame);
                $("form").submit();
                return false;
            }
            console.log("ssss");
            $('#typeCode').html(html);
        });


        $('#typeGame').change(function() {
            groupmenu = $(this).val();
            html = "";
            html += "<option value='0' selected>---Chon GiftCode---</option>";
            if(groupmenu ==0){
                alert('Vui lòng chọn Game');
                return false;
            }
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/?control=giftcodemanager&func=ajaxloadgame",
                data: {idgame:groupmenu},
                beforeSend: function(  ) {
                    console.log('starting...');
                }
            }).done(function(result) {
                console.log(result);
                //hide your loading file here
                $.each(result.data,function(key, el) {
                    html += "<option value='"+el.idx+"' >"+ el.display_name+"</option>";
                });

                $('#typegiftcode').html(html);

            });
        });

        $('#onSubmit').on('click',function(){
            if(checkType() == false ){
                return false;
            }

            if( $('#frmSendChest').validationEngine('validate') === false)
                return false;

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/?control=giftcodemanager&func=ordergc",
                data: $("#frmSendChest").serializeArray(),
                beforeSend: function(  ) {
                    // load your loading fiel here
                    $('#message').attr("style","color:green");
                    $('#message').html('Đang xử lý ...');
                    //disable button
                    $('#searchuid').attr("disabled","disabled");
                }
            }).done(function(result) {
                console.log(result);
                //hide your loading file here
                if (result.status == false)
                    $('#message').attr("style","color:red");

                $('#message').html(result.message);
                //enable button
                $('#searchuid').removeAttr('disabled');

            });
        });

        $(document).ready(function() {
            $(".datepicker").datepicker();
            $('#endDate').datetimepicker({
                showSecond: true,
                timeFormat: 'hh:mm:ss',
                dateFormat: 'dd/mm/yy',
                stepHour: 1,
                stepMinute: 1,
                stepSecond: 1
            });


            var i = 2;
            function createHtml(){
                htmlAppent = '<div class="group'+i+'">'+
                '<div class="form-group span3">'+
                '<label class="control-label">ITEM_ID_'+i+':</label>'+
                '<input id="item_id'+i+'" name="item_id'+i+'" type="text" value="1" class="span4 validate[required]">'+
                '</div>'+
                '<div class="form-group span3">'+
                '<label class="control-label">ITEM_NAME_'+i+':</label>'+
                '<input id="item_name'+i+'" name="item_name'+i+'" type="text" value="" class="span4 validate[required]">'+
                '</div>'+
                '<div class="form-group span3">'+
                '<label class="control-label">ITEM_COUNT_'+i+':</label>'+
                '<input id="item_count'+i+'" name="item_count'+i+'" type="text" value="1" class="span4 validate[required,custom[onlyNumberSp]]">'+
                '</div>'+
				'<div class="form-group span3">'+
                '<label class="control-label">ITEM_TYPE_'+i+':</label>'+
                '<input id="item_type'+i+'" name="item_type'+i+'" type="text" value="0" class="span4 validate[required]">'+
                '</div>'+
				'<div class="form-group remove span3">'+
				'<span class="remove_field">Remove</span>'+
				'</div>'+
                '<div class="clear"></div>'+
                '</div>';
                return htmlAppent;
            }
            $('#addgroup').click(function() {
                getHtml = createHtml();
                $('.totalchest').append(getHtml);
                i++;
            });
			$('.input_fields_wrap').on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault(); $(this).parent().parent().remove(); x--;
            })
        });

    });



</script>
<div id="content-t" style="width: 100%;min-height:500px;text-align: center;">

    <!--BEGIN CONTROL ADD CHEST-->
    <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
        <div class="widget row-fluid">
            <div class="form-horizontal input_fields_wrap">
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
                    <label class="control-label">Type Game:</label>
                    <div class="controls">
                        <select name="typeGame" id="typeGame" class="span4 validate[required]">
                            <option value="0" selected>---Chon Game---</option>
                            <?php
                            foreach ($menu_game as $g) {
                                ?>
                                <option value="<?php echo $g['alias'] ?>"><?php echo $g['display_name'] ?></option>

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
                    <label class="control-label">PREFIX:</label>
                    <div class="controls">
                        <textarea name="prefix" id="prefix" type="text" class="span4 validate[required]"></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">DESCRIPTION:</label>
                    <div class="controls">
                        <textarea name="description" id="description" type="text" class="span4 validate[required]"></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label for="quantity"  class="control-label">QUANTITY</label>
                    <div class="controls">
                        <input type="text" name="quantity" id="quantity" placeholder="0"  class="span4 validate[required,custom[onlyNumberSp]]">
                    </div>
                </div>
				<div class="control-group frmedit totalchest2">
					<div class="group1">
						<div class="form-group span6 ">
							<label for="ismultiple"  class="control-label">ISMULTIPLE</label>
							<input type="checkbox" name="ismultiple" id="ismultiple"  placeholder="0"  class="span4">
							
						</div>
						
						<div class="form-group span6 ">
							<label for="maxreceive"  class="control-label">Max Receive</label>
							<input type="input" name="maxreceive" id="maxreceive" value="0" placeholder="Nhận tối đa"  class="span6">
						</div>
						
					</div>
                </div>
				
				<div class="control-group frmedit totalchest2">
					<div class="group1">
						<div class="form-group span6 col-xs-6">
							<label for="forlevel"  class="control-label">FOR LEVEL MIN</label>
							<input type="input" name="forlevel" id="forlevel" value="" placeholder="Level"  class="span6 validate[custom[onlyNumberSp]]">
							
						</div>
						<div class="form-group span6 col-xs-6">
							<label for="forlevelmax"  class="control-label">FOR LEVEL MAX</label>
							<input type="input" name="forlevelmax" id="forlevelmax" value="" placeholder="Level"  class="span6 validate[custom[onlyNumberSp]]">
							
						</div>
						
					</div>
				</div>
				<div class="control-group frmedit totalchest2">				
					<div class="group1">
						<div class="form-group span6 col-xs-6">
							<label for="forvip"  class="control-label">FOR VIP MIN</label>
							<input type="input" name="forvip" id="forvip" value="" placeholder="Vip"  class="span6 validate[custom[onlyNumberSp]]">
						</div>
						<div class="form-group span6 col-xs-6">
							<label for="forvipmax"  class="control-label">FOR VIP MAX</label>
							<input type="input" name="forvipmax" id="forvipmax" value="" placeholder="Vip"  class="span6 validate[custom[onlyNumberSp]]">
						</div>
						
					</div>
                </div>
				
				 <div class="control-group">
                    <label for="server_id"  class="control-label">SERVER</label>
                    <div class="controls">
                        <input type="text" name="server_id" id="server_id" placeholder="1,2,3"  class="span4">
                    </div>
                </div>
				
                <div class="control-group">
                    <label class="control-label">ENDDATE:</label>
                    <div class="controls">
                        <input type="text" name="endDate" id="endDate" placeholder="18/05/2015"  class="span4 validate[required]"/>
                    </div>
                </div>





                <div class="control-group frmedit totalchest">
                    <div class="group1">
                        <div class="form-group span3">
                            <label class="control-label">ITEM_ID_1:</label>
                            <input id="item_id1" name="item_id1" type="text" value="1" class="span4 validate[required]">
                            </div>
                        <div class="form-group span3">
                            <label class="control-label">ITEM_NAME_1:</label>
                            <input id="item_name1" name="item_name1" type="text" value="" class="span4 validate[required]">
                            </div>
                        <div class="form-group span3">
                            <label class="control-label">ITEM_COUNT_1:</label>
                            <input id="item_count1" name="item_count1" type="text" value="1" class="span4 validate[required,custom[onlyNumberSp]]">
                            </div>
						<div class="form-group span3">
                            <label class="control-label">ITEM_TYPE_1:</label>
                            <input id="item_count1" name="item_type1" type="text" value="0" class="span4 validate[required]">
                            </div>
                        <div class="clear"></div>
                    </div>

                </div>
                <div class="control-group">
                    <div class="form-group">
                        <button id="addgroup" class="base_button base_green base-small-border-radius"><span>ADD MORE GIFTCODE</span></button>
                    </div>
                </div>


                <div class="control-group" style="text-align: left">
                    <span class="error"></span>
                </div>

                <div class="control-group">
                    <div style="padding-left: 20%; text-align:left;">
                        <input type="hidden" name='actorOrder' value="<?php echo $_SESSION['account']['username'];?>">
                        <button id="onSubmit" class="base_button base_green base-small-border-radius game-button"><span>Thực hiện</span></button>
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