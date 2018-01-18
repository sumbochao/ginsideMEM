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

    $(function () {        
        $('#config').on('click', function (e) {
            window.location.href = "/?control=crosssale&func=index&view=config#config";
        });
        $('#listgame').on('click', function (e) {
            window.location.href = "/?control=crosssale&func=index&view=listgame#listgame";
        });
        $('#requestcat').on('click', function (e) {
            window.location.href = "/?control=crosssale&func=index&view=requestcat#requestcat";
        });
        $('#history').on('click', function (e) {
            window.location.href = "/?control=crosssale&func=history#history";
        });
    });
</script>
<style>
.loading {display: none;position: fixed;top: 0;left: 0;right: 0;bottom: 0;background-color: rgba(0,0,0,.7);z-index: 1000;text-align: center;padding-top: 20%;}
</style>
<div class="loading"><img src="/assets/img/loading.gif" /></div>
<h4 class="widget-name"><?php echo $title;?></h4>
<ul class="nav nav-tabs" role="tablist">
	<?php
		$account = $this->Session->get_session('account');
		$permission = $this->Session->get_session('permission');
		if(count($account)>0 && $account['id_group']==2){
	?>
		<?php if(in_array($_GET['control'].'-index', $permission)){?>
		<li role="presentation" class="active"><a id="config" href="#config" aria-controls="config" role="tab" data-toggle="tab">CẤU HÌNH</a></li>
		<?php } ?>
		<?php if(in_array($_GET['control'].'-index', $permission)){?>
		<li role="presentation"><a id="listgame" href="#listgame" aria-controls="listgame" role="tab" data-toggle="tab">Game</a></li>
		<?php } ?>
		<?php if(in_array($_GET['control'].'-index', $permission)){?>
		<li role="presentation"><a id="requestcat" href="#requestcat" aria-controls="requestcat" role="tab" data-toggle="tab">Request Cat</a></li>
		<?php } ?>
		<?php if(in_array($_GET['control'].'-history', $permission)){?>
		<li role="presentation"><a id="history" href="#history" aria-controls="history" role="tab" data-toggle="tab">Lịch sử</a></li>
		<?php } ?>
	<?php
		}else{
	?>
	<li role="presentation" class="active"><a id="config" href="#config" aria-controls="config" role="tab" data-toggle="tab">CẤU HÌNH</a></li>
    <li role="presentation"><a id="listgame" href="#listgame" aria-controls="listgame" role="tab" data-toggle="tab">Game</a></li>
    <li role="presentation"><a id="requestcat" href="#requestcat" aria-controls="requestcat" role="tab" data-toggle="tab">Request Cat</a></li>
    <li role="presentation"><a id="history" href="#history" aria-controls="history" role="tab" data-toggle="tab">Lịch sử</a></li>
	<?php
		}
	?>
    
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