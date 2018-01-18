<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
        var url = 'http://game.mobo.vn/bog/cms/tool_crosssale/';
        $(document).ready(function () {
            game_id = '<?php echo $_GET['game_id'];?>';
			if(game_id != null && game_id != 0 && game_id != '' ){
				getData(game_id);	
			}
			$('#game').on('change', function() {
				window.location.href = "/?control=crosssale_bog&func=report&module=all&game_id="+this.value;
			});
        });

        function getData(game) {
            $.ajax({
                url: url + "get_total_cross?game_id="+game,
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        "aaData": data
                        ,
                        aoColumns: [
                            {
                                sTitle: "Game",
                                mData: "gameID",
								mRender: function (data) {
                                   msg = '';
								   if(data == 108)
								   {
									   msg = data +' [BOG]';
								   }else if(data == 106){
									   msg = data +' [MGH]';
								   }else if(data == 125){
									   msg = data +' [QHV]';
								   }else if(data == 128){
									   msg = data +' [LOL]';
								   }else if(data == 139){
									   msg = data +' [Hải Tặc]';
								   }else if(data == 103){
									   msg = data +' [Eden]';
								   }else if(data == 119){
									   msg = data +' [PhongThan]';
								   }else if(data == 101){
									   msg = data +' [Holywar]';
								   }else if(data == 133){
									   msg = data +' [CTT]';
								   }else{
									   msg = data;
								   }
								   return msg;
								   ;
                               }
                            },
                            {
                                sTitle: "Tổng tham gia",
                                mData: "total"
                            },
                            {
                                sTitle: "Tổng cài đặt",
                                mData: "install"
                            }

                        ],
                        bProcessing: true,

                        bPaginate: true,

                        bJQueryUI: false,

                        bAutoWidth: false,

                        bSort: false,
                        bRetrieve: true,
                        bDestroy: true,

                        sPaginationType: "full_numbers"
                    });
                }
            });
        }


    </script>
    
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include 'tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>


            <div>
                <form style="margin: 20px;" class="form-inline" method="post" action="/?control=crosssale_bog&func=export#lichsu">
				
							<div class="form-group">
								<!--validate[required]-->
								
									<select id="game" name="game" class="span4 " />
										<?php
										if($listgame) {
											foreach ($listgame as $key => $val) {
												if ($val['alias'] == $infodetail[0]['game'] || $val['alias'] == $_GET['game_id']) {
													echo '<option value="' . $val['alias'] . '" selected>' . $val['game'] . '</option>';
												} else {
													echo '<option value="' . $val['alias'] . '">' . $val['game'] . '</option>';
												}
											}
										}
										?>
									</select> 
							</div>	
							
					 <div class="form-group">
                    <button type="submit" class="btn btn-primary">Xuất Excel</button>
					</div>

                </form>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">
                    <table class="table table-striped table-bordered" id="data_table">
                    </table>
                </div>
                    </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<script type="text/javascript">
    (new TableDnD).init("tblsort");
</script>