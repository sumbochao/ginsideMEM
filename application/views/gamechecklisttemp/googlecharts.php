<?php include('class.php'); ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
		['Checklist', 'Admin', 'User'],
		<?php
		$i=1;
		$tt_count=0;
			if(count($categories_child) >0 && !empty($categories_child)){
				foreach($categories_child as $k=>$v){
					$c=$catego->CountRequest($v['id_game'],$v['id']);
					$i++;
					$tt_count=$tt_count + $c;
		  ?>
          ['<?php echo $v['names']; ?>',<?php echo $c; ?>,<?php echo $c; ?>],
		   <?php 	}//end for
			}//end if
			if($i>=1 && $i<=3){
				$w=800;
				$h=500;
			}elseif($i>3 && $i<=10){
				$w=810;
				$h=510;
			}else{
				$w=820;
				$h=1000;
			}
		   ?>
		  ['tt_request',<?php echo $tt_count; ?>,<?php echo $tt_count; ?>]
        ]);

        var options = {
          width: <?php echo $w; ?>,
		  height: <?php echo $h; ?>,
          chart: {
            title: '<?php echo $namecate." .Tổng số yêu cầu : ".$tt_count; ?>',
            subtitle: 'Admin màu xanh, User màu đỏ'
          },
          series: {
            0: { axis: 'Admin' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'User' } // Bind series 1 to an axis named 'brightness'.
          },
		  bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            y: {
              distance: {label: 'parsecs'}, // Left y-axis.
              brightness: {side: 'right', label: 'apparent magnitude'} // Right y-axis.
            }
          }
        };

      var chart = new google.charts.Bar(document.getElementById('dual_y_div'));
      chart.draw(data, options);
    };
    </script>
   <div id="dual_y_div" style="width: 900px; height: 500px;"></div>
  