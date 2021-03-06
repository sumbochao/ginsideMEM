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
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#startdate").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
            $("#enddate").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });

            $('#comeback').on('click', function () {
                //window.location.href = '/?control=event_covu_pt&func=giaidau#giaidau';
                window.history.go(-1); return false;
            });

            $('#onSubmit').on('click', function () {
                if ($('#frmSendChest').validationEngine('validate') === false){
                    return false;
                }

                $.ajax({
                    method: "POST",
                    dataType: 'jsonp',
                    url: "http://game.mobo.vn/phongthan/cms/consomayman/update_config",
                    data: $("#frmSendChest").serializeArray(),
                    beforeSend: function () {
                        // load your loading fiel here
                        $('#message').attr("style", "color:green");
                        $('#message').html('Đang xử lý ...');
                    }
                }).done(function (result) {
                    $('#message').html(result.message);
                });
            });
        });
    </script>

    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/pt/Events/consomayman/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
			<?php 
				$statusisgold = "checked='checked'";
				$statusissilve = '';
				
				$statusOn = "checked='checked'";
				$statusOff = "";
				
				if($detail){
					$minuitem = json_decode($detail['minuteitem'],true);
					$parseitem = array_values($minuitem)[0];
					
					$jsonruleparse = json_decode($detail['jsonrule'],true);
					$jsonparse = array_keys($jsonruleparse)[0];
					
					$statusisgold = (isset($minuitem[0]) && is_array($minuitem[0])) ? "checked='checked'": "";
					$statusissilve = (isset($minuitem[1]) && is_array($minuitem[1])) ? "checked='checked'": "";
					
					$statusOn = (isset($detail['status']) && $detail['status']==1) ? "checked='checked'": "";
					$statusOff = (isset($detail['status']) && $detail['status']==0) ? "checked='checked'": "";
				}
				
				
				
				$itemid = (isset($parseitem["item_id"]) && !empty($parseitem["item_id"])) ? $parseitem["item_id"]: 0;
				$count = (isset($parseitem["count"]) && !empty($parseitem["count"])) ? $parseitem["count"]: 0;
			?>
            <div class="widget" id="viewport">
                <form id="frmSendChest" name="frmSendChest" action="" method="POST" onsubmit="return false;" autocomplete="off">
                        <div class="well form-horizontal">
                            <h5 class="widget-name">
                                <i class=" ico-th-large"></i>THÊM MỚI CONFIG</h5>
                            <div class="control-group">
                                <label class="control-label">Game:</label>
								<div class="controls">
                                    <select id="game" name="game" class="span4 validate[required]" />
                                    <?php
									
                                    foreach($listgame as $key=>$val){
                                        if($val['idapp'] == $detail['game']){
                                            echo '<option value="'.$val['idapp'].'" selected>'.$val['game'].'</option>';
                                        }else{
                                            echo '<option value="'.$val['idapp'].'">'.$val['game'].'</option>';
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">ContentID:</label>
                                <div class="controls">
                                    <input type="text" id="content_id" name="content_id" value="<?php echo (isset($detail['content_id']) && !empty($detail['content_id'])) ? $detail['content_id']: "";?>" class="span3 validate[required,custom[onlyNumberSp]]" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Bắt đầu:</label>
                                <div class="controls">
                                    <div id="startdate" name="start" value="<?php echo (isset($detail['start']) && !empty($detail['start'])) ? $detail['start']: "";?>"></div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Kết thúc:</label>
                                <div class="controls">
                                    <div id="enddate" name="end" value="<?php echo (isset($detail['end']) && !empty($detail['end'])) ? $detail['end']: "";?>"></div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Server:</label>
                                <div class="controls">
                                    <input name="server_id" id="tournament_server_list" type="text" class="span3 validate[required]" style="margin: 0px;" value="<?php echo (isset($detail['server_id']) && !empty($detail['server_id'])) ? $detail['server_id']: "";?>"/>
                                    ([1],[2],[3])
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Type Minute:</label>
                                <div class="controls">
                                    Vàng:<input type="radio" name="minuteitem" class="isgold" id="groupminute" value="0" <?php echo $statusisgold;?>>
                                    &nbsp;&nbsp;
                                    Bạc:<input type="radio" name="minuteitem" class="issilve" id="groupminute" value="1" <?php echo $statusissilve; ?>>
                                    <!--Tích lũy money:<input type="radio" name="status" class="moneyfrom" id="groupminute" value="2" <?php //echo $statusOff; ?>>-->
                                    <div class="control-group infoshowminute">
                                        <label class="control-label">ITEMID(Minute):</label>
                                        <div class="controls">
                                            <input type="text" id="itemid" name="itemid" value="<?php echo $itemid;?>" class="span3 validate[custom[onlyNumberSp]]" />
                                        </div>

                                        <label class="control-label">COUNT(Minute):</label>
                                        <div class="controls">
                                            <input type="text" id="count" name="count" value="<?php echo $count;?>" class="span3 validate[custom[onlyNumberSp]]" />
                                        </div>

                                    </div>
                                    <!--
                                    <div class="control-group infotichluy">
                                        <label class="control-label">Bắt đầu:</label>
                                        <div class="controls">
                                            <div id="tournament_date_start" name="start"></div>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Kết thúc:</label>
                                        <div class="controls">
                                            <div id="tournament_date_end" name="end"></div>
                                        </div>
                                    </div>
                                    -->

                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">JsonRule:</label>
                                <div class="controls">
									<select id="jsonrule" name="jsonrule" class="span4 validate[required]" />
                                    <?php
									
                                    foreach($jsonrule as $key=>$val){
                                        if($val == $jsonparse){
                                            echo '<option value="'.$key.'" selected>'.$val.'</option>';
                                        }else{
                                            echo '<option value="'.$key.'">'.$val.'</option>';
                                        }
                                    }
                                    ?>
                                    </select>
									<input type="text" id="itemjson" name="itemjson" value="<?php echo (isset($jsonruleparse[$jsonparse]) && !empty($jsonruleparse[$jsonparse]))?$jsonruleparse[$jsonparse]:""; ?>"class="span3 validate[custom[onlyNumberSp]]" />
                                </div>
                            </div>



                            <div class="control-group">
                                <label class="control-label">Trạng thái:</label>
                                <div class="controls">
                                    Enable:<input type="radio" name="status" id="tournament_enable" value="1" <?php echo $statusOn;?>>
                                    &nbsp;&nbsp;
                                    Disable:<input type="radio" name="status" id="tournament_disable" value="0" <?php echo $statusOff; ?>>
                                </div>
                            </div>
                            <div class="control-group">
                                <div style="padding-left: 20%; text-align: left;">
								<?php 
									if($detail){
								?>
								<input type="hidden" id="id" name="id" value="<?php echo $detail['id'];?>" class="span3 validate[custom[onlyNumberSp]]" />
								<?php 
									}
								?>
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

