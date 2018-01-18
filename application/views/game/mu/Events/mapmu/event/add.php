<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height: 500px; padding-top: 10px">
    <style>
        #loading {
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            position: fixed;
            display: block;
            z-index: 99;
        }

        #loading-image {
            position: absolute;
            top: 40%;
            left: 45%;
            z-index: 100;
        }

        label {
            width: auto !important;
            color: #f36926;
        }
        .form-group {
            float: left;
            width: 22%;
        }
        .form-group input {
            width: 70%;
        }
        .form-horizontal .form-group{
            margin-left: 0px;
            margin-right: 0px;
        }
        .form-horizontal .listItem .control-label{
            padding-right: 5px;
            width: 27% !important;
            color: green;
        }
        .form-horizontal .listItem .sublistItem .control-label{
            color: #f36926;
        }
        .form-horizontal .sublistItem{
            margin-left: 15px;
        }
        .remove_field,.remove_field_receive{
            cursor: pointer;
            color: green;
        }
        .input_fields .control-group{
            padding-top: 23px; padding-bottom: 0px;margin-left: 0px; padding-left: 0px;border: 1px solid #ccc; margin-top: 10px; margin-bottom: 10px;
        }
        .input_fields_wrap .control-group .form-group{
            padding-bottom: 0px; margin-bottom: 0px;
        }
        
        .input_fields_wrap .control-group .sublistItem .remove_sub{
            top:4px;
        }
        .loadContent{
            text-align: center;
            color: red;
        }
        .input_fields_wrap .control-group .sublistItem .remove_sub .remove_field{
            color: #f36926 !important;
        }
        .form-horizontal .control-label{
            text-align: center;
        }
        .form-group.remove{
            width: 10%;
            position: relative;
            top:6px;
        }
        .subItems{
            margin-left: 20px;
        }
    </style>
	
<style>
    .btn{
        cursor:pointer;
        border-radius: 5px;
    }
    .item_rule input{
        height: auto !important;
        width: 160px;
    }
    .rule_item{
        margin:0px 10px;
    }
    .item_rule > .rows{
        float: left;
    }
    .item_rule > .rows > .title,.sub_item_rule > .rows > .title{
        float: left;
        margin-right: 10px;
        margin-top:5px;
    }
    .item_rule > .rows > .input,.sub_item_rule > .rows > .input{
        float: left;
        padding-right: 5px;
    }
    .item_rule > .btn_remove,.sub_item_rule > .btn_remove{
        float: left;
        margin-top: 5px;
        cursor: pointer;
        color: green;
    }
    .item_rule > .btn_addsub{
        margin-top: 5px;
        cursor: pointer;
        margin-bottom:5px;
    }
    .item_rule{
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 10px;
    }
    .sub_item_rule{
        margin-left: 10px;
    }
    .clr{
        clear: both;
    }
    .sub_item_rule .rows{
        float: left;
        margin-right: 10px;
    }
    #sub_item_rule{
        padding:10px 10px 0px 10px;
    }
    .btn_addsubsub{
        margin-right: 10px;
        float: left;
    }
    .btncoppy{
        margin-right: 10px;
    }
    .subsublist{
        margin-top: 10px;
    }
</style>
    <script type="text/javascript">
	
	function htmlItem(keyrule,y){
        var subhtml = '<div id="sub_item_rule" class="sub_item_rule">';
        subhtml += '<div class="rows">';
        subhtml += '    <div class="title">Item ID</div>';
        subhtml += '    <div class="input">';
        subhtml += '        <input type="text" size="20" name="item_id[]" value="1" placeholder="Nhập Item ID" />';
        subhtml += '    </div>';
        subhtml += '</div>';
        subhtml += '<div class="rows">';
        subhtml += '    <div class="title">Name</div>';
        subhtml += '    <div class="input">';
        subhtml += '        <input type="text" size="20" name="item_name[]" value="1" placeholder="Nhập Item Name" />';
        subhtml += '    </div>';
        subhtml += '</div>';
        subhtml += '<div class="rows">';
        subhtml += '    <div class="title">Count</div>';
        subhtml += '    <div class="input">';
        subhtml += '        <input type="text" style="width:75px;" name="count[]" value="1" placeholder="Nhập Count" />';
        subhtml += '    </div>';
        subhtml += '</div>';
        subhtml += '<div id="remVar" class="btn_remove">Remove</div>';
        subhtml += '<div class="clr"></div>';
        subhtml += '</div>';
        return subhtml;
    }
	
        $(document).ready(function () {
			$('.sublist ').on('click','#remScnt', function () {
				$(this).parents('div.item_rule').remove();
				return false;
			});
			//cap 2
			var y = 0;
			$('.sublist ').on('click','#addVar', function () {
				y++;
				var keyrule = $(this).attr('keyrule');
				var subhtml = htmlItem(keyrule,y);
				$(subhtml).appendTo($(this).next());
				return false;
			});
			$('.sublist ').on('click','#remVar', function () {
				$(this).parent('div#sub_item_rule').remove();
				return false;
			});
			
			$(".createdSub").click(function () {
				var idSub = $(this).attr('dataID');
				var countSub = $(".countSublist_" + idSub + " #sub_item_rule").length;
				countSub++;
				var subhtml = htmlItem(idSub,countSub);
				$(subhtml).appendTo($(this).next());
				return false;
			});
            $('#comeback').on('click', function () {
                window.history.go(-1); return false;
            });

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false)
                    return false;

                $.ajax({
                    type: "POST",
                    dataType: 'jsonp',
                    url: "<?php echo $url_service;?>/event/map/<?php echo $_GET['id']>0?'edit_'.$_GET['view'].'?id='.$_GET['id']:'add_'.$_GET['view'];?>",
                    data: $("#frmSendChest").serializeArray(),
                    beforeSend: function () {
                        $(".loading").fadeIn("fast");
                    }
                }).done(function (result) {
                    console.log(result);
                    $(".modal-body #messgage").html(result.message);
                    $('.bs-example-modal-sm').modal('show');
                    $(".loading").fadeOut("fast");

                });
            });
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/mu/Events/mapmu/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                        <div class="well form-horizontal">
                            <h5 class="widget-name">
                            <?php
                                $statusOn = 'checked';
                                $testerOff = 'checked';
                                if($_GET['id']>0){
                                    $statusOn =  $items[0]['status']==1 ? 'checked="checked"':'';
                                    $statusOff =  $items[0]['status']==0 ? 'checked="checked"':'';
                                    
                                }
                            ?>
                            <div class="control-group">
                                <label class="control-label">Tên:</label>
                                <div class="controls">
                                    <input name="name" id="name" value="<?php echo $items[0]['name'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Mốc:</label>
                                <div class="controls">
                                    <input name="day" id="day" value="<?php echo $items[0]['count'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Type:[0: day;1:week; 2: month]</label>
                                <div class="controls">
                                    <input name="type" id="type" value="<?php echo $items[0]['type'];?>" type="text" class="span3 validate[required]" style="width: 80%"/>
                                </div>
                            </div>
							
							
							<div class="control-group">
							
							<div class="btn_addsub btn btn-warning createdSub" dataID="<?php echo $i; ?>">Thêm items</div>
							<div class="sublist countSublist_<?php echo $i; ?>">
							<?php
								if (count($items[0]['items']) > 0) {
									$parse_item = json_decode($items[0]['items'],true);
									foreach ($parse_item as $k => $v) {
										
							?>
								<div class="sub_item_rule" id="sub_item_rule">
									<div class="rows">
										<div class="title">Item ID</div>
										<div class="input"><input type="text" placeholder="Nhập Item ID" value="<?php echo $v['item_id']; ?>" name="item_id[]" size="20"/></div>
									</div>
									<div class="rows">
										<div class="title">Name</div>
										<div class="input"><input type="text" placeholder="Nhập Item Name" value="<?php echo $v['item_name']; ?>" name="item_name[]" size="20"/></div>
									</div>
									<div class="rows">
										<div class="title">Count</div>
										<div class="input"><input type="text" placeholder="Nhập Count" value="<?php echo $v['count']; ?>" name="count[]" style="width:75px;"/></div>
									</div>
									<div class="btn_remove" id="remVar">Remove</div>
									<div class="clr"></div>
								</div>  
								<?php
										}
									}
								?>
							</div>
							
							</div>
							
                            
                            <div class="control-group">
                                <label class="control-label">Trạng thái:</label>
                                <div class="controls">
                                    Enable:<input type="radio" name="status" id="status" value="1" <?php echo $statusOn;?>/>
                                    &nbsp;&nbsp;
                                    Disable:<input type="radio" name="status" id="status" value="0" <?php echo $statusOff;?>/>
                                </div>
                            </div>
                            <div class="control-group">
                                <div style="padding-left: 20%; text-align: left;">
                                    <input type="hidden" name='email' value="<?php echo $_SESSION['auth']['user']->ause_username;?>">
                                    <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                    <button id="comeback" class="btn btn-primary"><span>Quay lại</span></button>
                                    <div style="display: inline-block">
                                        <span id="message" style="color: green"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<script>
    $('.datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'
    });
</script>