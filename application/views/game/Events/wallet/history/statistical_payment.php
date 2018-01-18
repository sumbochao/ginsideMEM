<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/currency.js'); ?>"></script>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
        .dataTables_wrapper.no-footer .dataTables_scrollBody{
            border-bottom: 0px;
            padding-top: 5px;
        }
        .scroolbar{
            width: 2000px;
        }
        .btn{
            position: relative;
            top:-5px;
        }
    </style>
    <?php
        $start = date('d-m-Y G:i:s',  strtotime('-15 day'));
        $end = date('d-m-Y G:i:s');
        if(isset($_POST['start'])){
            $datetime = "start=".strtotime($_POST['start'])."&end=".strtotime($_POST['end']);
            $start = $_POST['start'];
            $end = $_POST['end'];
        }else{
            $datetime = "start=".strtotime($start)."&end=".strtotime($end);
        }
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
			
			//get list event by game
			var game = $(this).val();
			if(game != '-1'){
				$.post('/?control=wallet&func=getEventsByGame',{game:game},function(response){
					$('#event').html(response);
				})
				
				var event = $(this).val();
				$.post('/?control=wallet&func=getServers',{game:game},function(response){
					$('#server').html(response);
				})
			}
            getData();
			
			//get list event by game
			$('#game').change(function(){
				var game = $(this).val();
				$.post('/?control=wallet&func=getEventsByGame',{game:game},function(response){
					$('#event').html(response);
				})
				
				var event = $(this).val();
				$.post('/?control=wallet&func=getServers',{game:game},function(response){
					$('#server').html(response);
				})
			});
			
        });
        function getData() {
            $('#data_table').DataTable({
				scrollX: true,
                "aaData": <?php echo $payment_history;?>,
                aoColumns: [
                    {
                        sTitle: "Server",
                        mData: "server_id"
                    },
                    {
                        sTitle: "Event",
                        mData: "event"
                    },
                    {
                        sTitle: "Money",
                        mData: "money"
                    },
                    {
                        sTitle: "Create Date",
                        mData: "create_date"
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
    </script>
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include APPPATH . 'views/game/Events/wallet/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                         <div style="margin-top: 10px; margin-bottom: 10px;">
                             <form action="" method="post">
							 <select id="game" name="game">
                                   <option value="-1">Chọn game</option>
                                   <?php 
                                       if(count($slbGame)>0){
                                           foreach($slbGame as $v){
                                               if((@in_array($v['app_name'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2) || (@in_array($v['app_name'], $_SESSION['permission']) && $_SESSION['account']['id_group']==3) || $_SESSION['account']['id_group']==1){
                                   ?>
                                   <option value="<?php echo $v['service_id'];?>" <?php //echo $_POST['game']==$v['service_id']?'selected="selected"':'';;?>><?php echo $v['app_fullname'].' ('.$v['service_id'].')';?></option>
                                   <?php
                                               }
                                           }
                                       }
                                   ?>
                               </select>
							   <select name="event" id="event">
									<option value="-1">--Event--</option>
							   </select>
							   
							   <select name="server" id="server">
									<option value="-1">--Server--</option>
							   </select>
							   
                                <input type="text" class="datetimer" name="start" value="<?php echo $start;?>"/>
                                <input type="text" class="datetimer" name="end" value="<?php echo $end;?>"/>
                                <button name="filter_payment" id="submit"  class="btn btn-primary"><span>Tìm kiếm</span></button>
                                <button name="exportPaymentHistory" id="create"  class="btn btn-primary"><span>Xuất Excel</span></button>
                            </form>
                        </div>
                        <div class="wrapper_scroolbar">
                            <div class="scroolbar">
                                <table class="table table-striped table-bordered" id="data_table"></table>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>
<script>
    $('.datetimer').datetimepicker({
        dateFormat: 'dd-mm-yy',
        timeFormat: 'hh:mm:ss'//
    });
</script>
