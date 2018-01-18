<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script type="text/javascript" src="<?php echo base_url('/libraries/cms/jquery.form.js')?>"></script>
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
		.col-md-6,.col-md-4,.col-xs-12,.col-md-3{padding:0}
		.clearfix:after{clear:both;width:100%;display:block;}
		.control-group input[type="text"]{width: 152px;}
		.enablefile{display:none;}
		.disablefile{display:none;}
    </style>
    <script type="text/javascript">
        
        $(document).ready(function () {
            //Set DateTime Format
            $("#startdate").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
			$("#enddate").jqxDateTimeInput({ width: '150px', height: '28px', formatString: 'yyyy-MM-dd HH:mm:ss' });
			$('#frmSendChest').ajaxForm(function (data) {
                if ($('#frmSendChest').validationEngine('validate') === false){
					return false;
                }
				console.log(data);
				var obj = JSON.parse(data);
				if(obj.code == 0){
					 $('#message').attr("style", "color:green");
				}
				$('#message').html(obj.message);
				//url: "http://game.mobo.vn/phongthan/cms/gmtool/addeventitems",
				/*
				$.ajax({
                    method: "POST",
                    dataType: 'jsonp',
                    url: "http://local.service.phongthan.mobo.vn/cms/gmtool/addeventitems",
                    data: $("#frmSendChest").serializeArray(),
                    beforeSend: function () {
                        // load your loading fiel here
                        $('#message').attr("style", "color:green");
                        $('#message').html('Đang xử lý ...');
                    }
                }).done(function (result) {
					console.log(result);
                    $('#message').html(result.message);
                });
				*/
            });
			
			$('.tournament_enable').change(function(){
				value = $(this).val();
				if(value ==0){
					$('.serverenable').hide();
					$('.enablefile').show();
				}else{
					$('.enablefile').hide();
					$('.serverenable').show();
				}
			});
			
			$('#addgroup').click(function() {
                getHtml = createHtml();
                $('.totalchest').append(getHtml);
                i++;
            });
			
			
			var max_fields      = 10; //maximum input boxes allowed
            var wrapper         = $(".input_fields_wrap"); //Fields wrapper
            var add_button      = $(".add_field_button"); //Add button ID
            var x = 1; //initlal text box count
            $(add_button).click(function(e){ //on add input button click
                e.preventDefault();
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    var xhtml="";
                    xhtml += '<div class="control-group frmedit totalchest">';
                    xhtml += '<div class="group1 w25 clearfix">';
                    xhtml +='<div class="control-group">';
                    xhtml +='<label class="control-label">Items ID:</label>';
                    xhtml +='<div class="controls">';
                    xhtml +='<input id="item_id" name="item_id[]" type="text" value="1" class="span3 validate[required]">';
                    xhtml +='</div>';
                    xhtml +='</div>';
                    xhtml +='<div class="control-group">';
                    xhtml +='<label class="control-label">Items Name:</label>';
                    xhtml +='<div class="controls">';
                    xhtml +='<input id="name" name="name[]" type="text" value="1" class="span3 validate[required]">';
                    xhtml +='</div>';
                    xhtml +='</div>';
                    xhtml +='<div class="control-group">';
                    xhtml +='<label class="control-label">Count:</label>';
                    xhtml +='<div class="controls">';
                    xhtml +='<input id="count" name="count[]" type="text" value="1" class="span3 validate[required]">';
                    xhtml +='</div>';
                    xhtml +='</div>';
                    xhtml +='<div class="control-group">';
                    xhtml +='<label class="control-label">Type:</label>';
                    xhtml +='<div class="controls">';
                    xhtml +='<input id="type" name="type[]" type="text" value="0" class="span3 validate[required]">';
                    xhtml +='</div>';
                    xhtml +='</div>';
                    xhtml +='<div class="control-group remove">';
                    xhtml +='<span class="remove_field">Remove</span>';
                    xhtml +='</div>';
                    xhtml +='</div>';
                    xhtml +='<div class="clear"></div>';
                    xhtml +='</div>';
                    $(wrapper).append(xhtml); //add input box
                }
            });

            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
            })

        });
		
		

        
    </script>
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/gmtool/tab.php'; ?>
            <div class="widget-name">

                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
			<?php 
				$statusOn = "checked";
				$statusOff = "";
				$disablefile = 'disablefile';
				
				$ispublicOn = "checked";
				$ispublicOff = "";
				
				if($detail){
					$ispublicOn = (isset($detail['ispublic']) && $detail['ispublic']==1) ? "checked": "";
					$ispublicOff = (isset($detail['ispublic']) && $detail['ispublic']==0) ? "checked": "";
					
					$statusOn = (isset($detail['status']) && $detail['status']==1) ? "checked": "";
					$statusOff = (isset($detail['status']) && $detail['status']==0) ? "checked": "";
					
				}
		   ?>
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <form id="frmSendChest" action="http://local.ginside.mobo.vn/?control=gmtool&func=submiteventitems" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <div class="control-group">
                            <label class="control-label">Game:</label>
                            <div class="controls">
							<!--validate[required]-->
							
                                <select id="game" name="game" class="span4 " />
									<?php
                                    if($listgame) {
                                        foreach ($listgame as $key => $val) {
                                            if ($val['idapp'] == $detail['game']) {
                                                echo '<option value="' . $val['idapp'] . '" selected>' . $val['game'] . '</option>';
                                            } else {
                                                echo '<option value="' . $val['idapp'] . '">' . $val['game'] . '</option>';
                                            }
                                        }
                                    }
									?>
								</select> 
                            </div>
                        </div>
						<div class="control-group col-xs-12 clearfix">
							<div class="control-group col-md-3">
								<label class="control-label">Title:</label>
								<div class="controls">
									<input type="text" id="title" name="title" value="<?php echo $detail['title'];?>" class="span3" />
								</div>
							</div>
							<div class="control-group col-md-3">
								<label class="control-label">Content:</label>
								<div class="controls">
									<input type="text" id="content" name="content" value="<?php echo $detail['content'];?>" class="span3" />
								</div>
							</div>	
							<div class="control-group col-md-3">
								<label class="control-label">Description:</label>
								<div class="controls">
									<input type="text" id="description" name="description" value="<?php echo $detail['des'];?>" class="span3" />
								</div>
							</div>	
						</div>	
						
						<div class="control-group col-xs-12 clearfix">
							<div class="control-group col-md-3">
								<label class="control-label">Bắt đầu:</label>
								<div class="controls">
									<div id="startdate" name="start" value="<?php echo (isset($detail['start']) && !empty($detail['start'])) ? $detail['start']: "";?>"></div>
								</div>
							</div>
							<div class="control-group col-md-3">
								<label class="control-label">Kết thúc:</label>
								<div class="controls">
									<div id="enddate" name="end" value="<?php echo (isset($detail['end']) && !empty($detail['end'])) ? $detail['end']: "";?>"></div>
								</div>
							</div>
							<?php 
							if($statusOn == 'checked'){
							?>
								<div class="control-group col-md-3 serverenable">
									<label class="control-label">Server:</label>
								   <div class="controls">
										<input name="server_id" id="tournament_server_list" type="text" class="span3" style="margin: 0px;" value="<?php echo (isset($detail['server_id']) && !empty($detail['server_id'])) ? $detail['server_id']: "";?>"/>
										([1],[2],[3])
									</div>
								</div>
							<?php }
							if(!$detail){
								$disablefile = "enablefile";
							}
							?>
								<div class="control-group col-md-3 <?php echo $disablefile; ?>">
									<label class="control-label">Import:</label>
								   <div class="controls">
										<input name="listgamer" id="listgamer" type="file" class="span3" style="margin: 0px;"/>
									</div>
								</div>
							
						</div>

                       
						

                        <div class="control-group">
                            <label class="control-label">Publis All:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="ispublic" class="tournament_enable" value="1" <?php echo $ispublicOn;?>>
                                    &nbsp;&nbsp;
                                Disable:<input type="radio" name="ispublic" class="tournament_enable" value="0" <?php echo $ispublicOff; ?>>
                            </div>
                        </div>
						<br/>
						<div class="control-group">
                            <label class="control-label">Status:</label>
                            <div class="controls">
                                Enable:<input type="radio" name="status" class="" value="1" <?php echo $statusOn;?>>
                                    &nbsp;&nbsp;
                                Disable:<input type="radio" name="status" class="" value="0" <?php echo $statusOff; ?>>
                            </div>
                        </div>
						
						<div class="input_fields_wrap">	
                            <div class="btn_morefield">
                                <button class="add_field_button base_button base_green base-small-border-radius btn btn-primary btn-sm">Add More Fields</button>
                            </div>

                            <br/>
                            <?php
                            if($detail['items']){
                                $listItems = json_decode($detail['items'],true);
                                if(count($listItems)>0){
                                    $i=0;
                                    foreach($listItems as $v){
                                        $i++;
                                        ?>
                                        <div class="control-group frmedit totalchest">
                                            <div class="group1 w25 clearfix">
                                                <div class="control-group">
                                                    <label class="control-label">Items ID:</label>
                                                    <input id="item_id" name="item_id[]" type="text" value="<?php echo $v['item_id'];?>" class="span3 validate[required]">
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Items name:</label>
                                                    <input id="name" name="name[]" type="text" value="<?php echo $v['name'];?>" class="span3 validate[required]">
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Count:</label>
                                                    <input id="count" name="count[]" type="text" value="<?php echo $v['count'];?>" class="span3 validate[required]">
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Type:</label>
                                                    <input id="type" name="type[]" type="text" value="<?php echo $v['type'];?>" class="span3 validate[required]">
                                                </div>
                                                <?php
                                                if($i!=1){
                                                    ?>
                                                    <div class="control-group remove">
                                                        <span class="remove_field">Remove</span>
                                                    </div>
                                                <?php } ?>
												
                                                <div class="clear"></div>
                                            </div>
											
                                                
                                        </div>
										
                                    <?php
                                    }
                                }
                            }else{
                                ?>
                                <div class="control-group frmedit totalchest">
                                    <div class="group1 w25 clearfix">
                                        <div class="control-group">
                                            <label class="control-label">Items ID:</label>
                                            <div class="controls">
                                                <input id="item_id" name="item_id[]" type="text" value="1" class="span3 validate[required]">
                                            </div>

                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Items Name:</label>
                                            <div class="controls">
                                                <input id="name" name="name[]" type="text" value="1" class="span3 validate[required]">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Count:</label>
                                            <div class="controls">
                                                <input id="count" name="count[]" type="text" value="1" class="span3 validate[required]">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Type:</label>
                                            <div class="controls">
                                                <input id="type" name="type[]" type="text" value="0" class="span3 validate[required]">
                                            </div>
                                        </div>

                                        
                                        <div class="clear"></div>
                                    </div>
									
                                </div>
                            <?php } ?>
						</div>


                        <div class="control-group">
                            <div style="padding-left: 20%; text-align: left;">
                                <?php 
									if($detail){
								?>
								<input type="hidden" id="id" name="id" value="<?php echo $detail['idx'];?>" class="span3 validate[custom[onlyNumberSp]]" />
								<?php 
									}
								?>
								<input type="hidden" id="email" name="email" value="<?php echo $_SESSION['account']['username'];?>" class="span3" />
                                <button id="onSubmit" class="btn btn-primary"><span>Thực hiện</span></button>
                                <div style="display: inline-block">
                                    <span id="message" style="color: green"></span>
                                </div>
                            </div>
						</div>	
                    </form>
					
                </div>
				
					
					
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
