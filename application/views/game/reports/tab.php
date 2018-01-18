<style>
    .nav > li > a{
        padding: 5px;
    }
</style>
<?php
    switch ($_GET['game']){
        case 'eden':
            $title = 'EDEN';
            break;
        case 'tethien':
            $title = 'TỀ THIÊN';
            break;
        case 'mgh':
            $title = 'MỘNG GIANG HỒ';
            break;
        case 'langkhach':
            $title = 'LÃNG KHÁCH';
            break;
        case 'bog':
            $title = 'BOG';
            break;
		case 'giangma':
            $title = 'GIÁNG MA';
            break;
		case 'ifish':
            $title = 'Bắn cá';
            break;
		case 'koa':
            $title = 'Lục Giới';
            break;
    }
	if($_GET['game']=='ifish'){
        $datatitle = 'Dữ liệu được cập nhật vào lúc 8:00 mỗi ngày';
    }else{
		if($_GET['game']=='eden'){
			$datatitle = 'Dữ liệu được cập nhật vào lúc 9:00 mỗi ngày';
		}else{
			if($_GET['func']=='card_statistics' && $_GET['game']=='mgh'){
				$datatitle = 'Dữ liệu sẽ được làm mới mỗi 6h';
			}else{
				$datatitle = 'Dữ liệu được cập nhật vào lúc 0:00 mỗi ngày';
			}
		}
	}
?>
<h4><?php echo strtoupper($title);?> <span style="color: red;"><?php echo $datatitle; ?></span></h4>
<?php
    switch ($_GET['game']){
        case 'bog':
            include_once 'bog/tab.php';
            break;
        case 'tethien':
            include_once 'tethien/tab.php';
            break;
        case 'langkhach':
            include_once 'langkhach/tab.php';
            break;
		case 'giangma':
            include_once 'giangma/tab.php';
            break;
		case 'ifish':
            include_once 'ifish/tab.php';
            break;
		case 'koa':
            include_once 'koa/tab.php';
            break;
        default :
            include_once 'default/tab.php';
            break;
    }
?>
