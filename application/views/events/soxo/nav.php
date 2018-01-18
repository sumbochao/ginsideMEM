 <link rel="stylesheet" href="http://ginside.mobo.vn/assets/datetime/css/style.css"/>
<link rel="stylesheet" href="http://ginside.mobo.vn/assets/datetime/css/bootstrap.css"/>
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
<script type="text/javascript" src="/libraries/jqwidgets32/jqx-all.js"></script>
<link href='/libraries/jqwidgets32/styles/jqx.base.css' rel='stylesheet' type='text/css'>
<link href='/libraries/jqwidgets32/styles/jqx.classic.css' rel='stylesheet' type='text/css'>
<link href='/libraries/pannonia/pannonia/css/plugins.css' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validation.js"></script>
<script type="text/javascript" src="/libraries/pannonia/pannonia/js/plugins/forms/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="/libraries/cms/jquery.form.js"></script>
<script>
    $(document).ready(function () {
    // Javascript to enable link to tab
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href=#' + url.split('#')[1] + ']').tab('show');
    }

    // Change hash for page-reload
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    });
    });

   
</script>

	
<style>
.loading {display: none;position: fixed;top: 0;left: 0;right: 0;bottom: 0;background-color: rgba(0,0,0,.7);z-index: 1000;text-align: center;padding-top: 20%;}
.control-group input[type="text"] {
border-radius: 0;
box-shadow: none;
width: 90%;
}

</style>
<div class="loading"><img src="/assets/img/loading.gif" /></div>
<h4 class="widget-name">QUẢN LÝ EVENT XỔ XỐ</h4>
<!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="<?php  echo $_GET['func']=='index'?'active':'';?>">
	<a id="home" href="/?control=mobo_event_conso&func=index" aria-controls="home" >DANH SÁCH CONFIG</a></li>
	
	<!--<li role="presentation" class="<?php  echo $_GET['func']=='index'?'active':'';?>">
	<a id="home" href="/?control=mobo_event_conso&func=index" aria-controls="home" >ĐÓNG MỞ EVENT</a></li>-->
	
    <li role="presentation" class="<?php  echo $_GET['func']=='importlotteryresult'?'active':'';?>">
	
	<a id="giaidau"  href="/?control=mobo_event_conso&func=importlotteryresult" aria-controls="giaidau">CẬP NHẬT KẾT QUẢ</a></li>
    <li role="presentation" class="<?php  echo $_GET['func']=='displayLotteryResult'?'active':'';?>">
	<a id="trandau" href="/?control=mobo_event_conso&func=displayLotteryResult" aria-controls="trandau">DANH SÁCH KẾT QUẢ</a></li>
	
	<li role="presentation" class="<?php  echo $_GET['func']=='history'?'active':'';?>">
	<a id="trandau" href="/?control=mobo_event_conso&func=history" aria-controls="trandau">LỊCH SỬ</a></li>
  </ul>

 <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="mySmallModalLabel">Thông báo</h4>
        </div>
        <div class="modal-body"><div id="messgage" style="text-align: center;"></div></div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  
  
  