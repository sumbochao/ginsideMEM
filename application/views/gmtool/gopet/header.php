<link href="/bog/template_crosssale/sub/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/bog/template_crosssale/sub/style.css">
<script type="text/javascript">
    function show_loading() {
        $("#loading").fadeIn("fast");
        return true;
    }
</script>
<style>
    #main-menu-bt ul {
        margin: 0;
        padding: 0;
        list-style: none;
        text-align: center;
        background: #fff url(/bog/template_crosssale/listgame/bg_menu.jpg) left bottom repeat-x;
        overflow: hidden;
        padding-bottom: 0px;
    }
    #main-menu-bt ul li a {
        border-right: 1px solid #b04b05;
        border-left: 1px solid #f69f5b;
    }
	.infotest .form-horizontal .controls{
		margin-left: 0%;
	}
	.infotest .form-horizontal .control-label{
		float: initial;
		width: 100%; 
		padding-top: 0px;
	}
</style>
<div class="container">
    <div class="row">

        <script src="/bog/js/bootstrap.min.js"></script>
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
				<?php 
					if(empty($slider) === FALSE){
					$iks = 1;
					foreach($slider as $val){
					
				?>	
					<div class="item <?php if($iks==1){ echo "active";$iks++;} ?>">
						<img src="<?php echo $val['url']?>" alt="<?php echo $val['name'];?>">
					</div>
				<?php 
					}
				}
				?>
            </div>

            <!-- Controls -->
            <!--
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>-->
        </div> <!-- Carousel -->
        <div id="main-menu-bt">
            <ul>
                <li class="col-xs-6"><a href="/bog/event/event_hot/view?ids=1517&<?php echo http_build_query($_GET) ?>">Giới thiệu</a></li>
                <li class="col-xs-6"><a href="/bog/event/event_hot/view?ids=1675&<?php echo http_build_query($_GET) ?>">Hướng dẫn</a></li>
            </ul>
        </div>