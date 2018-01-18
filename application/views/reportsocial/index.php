<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>


<!--
<link rel="stylesheet" type="text/css" href="/jchart/css/jquery.jqChart.css" />
<link rel="stylesheet" type="text/css" href="/jchart/css/jquery.jqRangeSlider.css" />
<link rel="stylesheet" type="text/css" href="/jchart/themes/smoothness/jquery-ui-1.10.4.css" />

<script src="/jchart/js/jquery.mousewheel.js" type="text/javascript"></script>
<script src="/jchart/js/jquery.jqChart.min.js" type="text/javascript"></script>
<script src="/jchart/js/jquery.jqRangeSlider.min.js" type="text/javascript"></script>
-->
<script src="/assets/js/highcharts.js"></script>
<script src="/assets/js/exporting.js"></script>

<style>
.loadserver .textinput{
    width:205px;
	margin-top:-10px;
}
</style>
<div class="loading_warning"></div>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <div class="filter">
            <input type="text" name="access_token" value="" class="textinput" placeholder="Access_token" title="Access_token"/>
            <input type="button" value="Nhập" onclick="onSubmitFormAjax()" class="btnB btn-primary btnAccessToken"/>
        </div>
        <div class="wrapper_scroolbar">
            <?php
            if($inforule){
                $fanpage_cat = '';
				$games = array();
				$game2s = array();
				$game3s = array();
				$i= 1;
				$daynow = date('Y-m-d',strtotime(date('Y-m-d',time())."-6day"));
				foreach($inforule['page_fans'] as $key=>$val)
                {
					if($daynow < date('Y-m-d',strtotime($val['insertdate'])) ){
						if(!strpos($fanpage_cat,date('Y-m-d',strtotime($val['insertdate']) ) ) ){
							$fanpage_cat.="'".date('Y-m-d',strtotime($val['insertdate'])) ."',";
						}
						continue;
					}
					//$games[$val['game']][] = $val;
                }
				foreach($inforule['page_fans'] as $key=>$val)
                {
					$games[$val['game']][] = $val;
				}
				$fancat  = substr($fanpage_cat,0,strlen($fanpage_cat)-1);
				
				foreach($inforule['page_positive_feedback_by_type'] as $key=>$val)
                {
					$game2s[$val['game']][] = $val;
                }
				
				foreach($inforule['page_impressions_organic'] as $key=>$val)
                {
					$game3s[$val['game']][] = $val;
                }
				
            ?>
            <div>
                <div id="jqChart" style="width: 800px; height: 300px;" class="fangrouth"></div>
            </div>
			<div>
                <div id="jqChart2" style="width: 800px; height: 300px;" class="fangrouth"></div>
            </div>
			<div>
                <div id="jqChart3" style="width: 800px; height: 300px;" class="fangrouth"></div>
            </div>
            <?php } ?>
        </div>
    </form>
</div>

<script lang="javascript" type="text/javascript">
    $(document).ready(function () {
		$('#jqChart').highcharts({
			title: {
				text: 'FANGROWTH',
				x: -20 //center
			},
			xAxis: {
				categories: [<?php echo $fancat;?>]
			},
			yAxis: {
				title: {
					text: 'Mốc Like'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				valueSuffix: ''
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				borderWidth: 0
			},
			series: [
			<?php 	if($games){
					foreach($games as $key=>$val){
					 $game_cat = '';
					 $totalgame = 0;
					 foreach($val as $key1=>$val1){
						 
						if($daynow >= date('Y-m-d',strtotime($val1['insertdate']) ) ){
							$totalgame = $val1['day_likefanpage'];
							continue;
						}
						$game_cat.=($val1['day_likefanpage'] - $totalgame) .",";
						$totalgame = $val1['day_likefanpage'];
						$gameinfo  = substr($game_cat,0,strlen($game_cat)-1);
					 }
					
				?>
				{
                    name: '<?php echo $key; ?>',
                    data: [<?php echo $gameinfo;?>]
                },
			<?php } 
			}?>
			]
		});
		
		$('#jqChart2').highcharts({
			title: {
				text: 'ENGAGEMENT',
				x: -60 //center
			},
			xAxis: {
				categories: [<?php echo $fancat;?>]
			},
			yAxis: {
				title: {
					text: 'Mốc Like'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				valueSuffix: ''
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				borderWidth: 0
			},
			series: [
			<?php 
			if($game2s)
					foreach($game2s as $key=>$val){
					 $game_cat = '';
					 foreach($val as $key1=>$val1){
						 if($daynow >= date('Y-m-d',strtotime($val1['insertdate']) ) ){
							continue;
						 }
						$game_cat.=($val1['day_like'] + $val1['day_comment'] + $val1['day_share'] ).",";
						$gameinfo  = substr($game_cat,0,strlen($game_cat)-1);
					 }
					
				?>
				{
                    name: '<?php echo $key; ?>',
                    data: [<?php echo $gameinfo;?>]
                },
			<?php } ?>
			]
			
        });
		
		$('#jqChart3').highcharts({
			title: {
				text: 'ORGANIC PAGE RESEACH',
				x: -20 //center
			},
			xAxis: {
				categories: [<?php echo $fancat;?>]
			},
			yAxis: {
				title: {
					text: 'Mốc Like'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				valueSuffix: ''
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				borderWidth: 0
			},
			series: [
			<?php 
				if($game3s)
					foreach($game3s as $key=>$val){
					 $game_cat = '';
					 foreach($val as $key1=>$val1){
						  if($daynow >= date('Y-m-d',strtotime($val1['insertdate']) ) ){
							continue;
						 }
						$game_cat.=$val1['day_reseach'] .",";
						$gameinfo  = substr($game_cat,0,strlen($game_cat)-1);
					 }
					
				?>
				{
                    name: '<?php echo $key; ?>',
                    data: [<?php echo $gameinfo;?>]
                },
			<?php } ?>
			]
        });
		
		
    });
</script>
<script type="text/javascript">
    function onSubmitFormAjax(formName,url){
        var access_token = $('input[name=access_token]').val();
        $.ajax({
            url:baseUrl+'?control=reportsocial&func=getdata',
            type:"POST",
            data:{access_token:access_token},
            async:false,
            dataType:"json",
            beforeSend:function(){
                $('.loading_warning').show();
            },
            success:function(f){
                    Lightboxt.showemsg('Thông báo', '<b>'+f.message+'</b>', 'Đóng');
                    $('.loading_warning').hide();
            }
        });
        
    }
</script>
<div id="loading" class="dialog">
    <div class="loading">
        <img class="icon-loading" src="/phongthan/assets/efacebook/images/loading_1.gif"></img>
    </div>
</div>

