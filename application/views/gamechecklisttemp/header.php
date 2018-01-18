<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<!--<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<script type="text/javascript">
    function loadPage(area, url){
        $(area).load(url);
    }
	
</script>-->

<!--fancybox-->
<script src="<?php echo base_url('assets/fancybox/lib/jquery-1.10.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js'); ?>"></script>
<script src="<?php echo base_url('assets/fancybox/source/jquery.fancybox.js?v=2.1.5'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/fancybox/source/jquery.fancybox.css?v=2.1.5'); ?>" type="text/css" media="screen"/>
<link rel="stylesheet" href="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5'); ?>" type="text/css" media="screen"/>
<script src="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7'); ?>" type="text/css" media="screen"/>
<script src="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7'); ?>"></script>
<script src="<?php echo base_url('assets/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6'); ?>"></script>
<script type="text/javascript">
		$(document).ready(function() {
			$(".various").fancybox({
				title:'Thông tin mô tả',
				maxWidth	: 800,
				maxHeight	: 400,
				fitToView	: false,
				width		: '100%',
				height		: '100%',
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});
			
			$(".variouslog").fancybox({
				title:'Nhật ký',
				maxWidth	: 500,
				maxHeight	: 300,
				fitToView	: false,
				width		: '100%',
				height		: '100%',
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});
			
			$(".variousMail").fancybox({
				title:'Gửi Mail',
				maxWidth	: 550,
				maxHeight	: 450,
				fitToView	: false,
				width		: '100%',
				height		: '100%',
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});
			
		});
	</script>
<!--end fancybox-->
<style>
.fancybox-custom .fancybox-skin {
			box-shadow: 0 0 50px #222;
}

.textinputplus{
	border:none !important;
}

.wrapper_scroolbar table tbody tr td{
	text-align:left !important;
	vertical-align:top;
}
.head{
	display:none !important;
}
#left{
	display:none !important;
}
#tblsort tr th{
	background-color:#A25391;
}
</style>