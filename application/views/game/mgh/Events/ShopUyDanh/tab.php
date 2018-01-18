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

		
		$('#quanlyqua').on('click', function (e) {
            window.location.href = "/?control=shopuydanh&func=quanlyqua&module=all#quanlyqua";
        });


        $('#logdoiqua').on('click', function (e) {
            window.location.href = "/?control=shopuydanh&func=get_log_doiqua&module=all#logdoiqua";
        });
        
        $('#logdoidiem').on('click', function (e) {
            window.location.href = "/?control=shopuydanh&func=get_log_doidiem&module=all#logdoidiem";
        });
		
		$('#configdoidiem').on('click', function (e) {
            window.location.href = "/?control=shopuydanh&func=get_config_doidiem&module=all#configdoidiem";
        });

        $('#quanlybangdiem').on('click', function (e) {
            window.location.href = "/?control=shopuydanh&func=quanlybangdiem&module=all#quanlybangdiem";
        });



    });
</script>
<style>
.loading {display: none;position: fixed;top: 0;left: 0;right: 0;bottom: 0;background-color: rgba(0,0,0,.7);z-index: 1000;text-align: center;padding-top: 20%;}
</style>
<div class="loading"><img src="/assets/img/loading.gif" /></div>
<h4 class="widget-name">QUẢN LÝ EVENT SHOP UY DANH</h4>
<!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a id="quanlyqua" href="#quanlyqua" aria-controls="quanlyqua" role="tab" data-toggle="tab">QUẢN LÝ QUÀ</a></li>
    <li role="presentation"><a id="logdoiqua" href="#logdoiqua" aria-controls="logdoiqua" role="tab" data-toggle="tab">LOG ĐỔI QUÀ</a></li>
    <li role="presentation"><a id="logdoidiem" href="#logdoidiem" aria-controls="logdoidiem" role="tab" data-toggle="tab">LOG ĐỔI ĐIỂM</a></li>
    <li role="presentation"><a id="configdoidiem" href="#configdoidiem" aria-controls="configdoidiem" role="tab" data-toggle="tab">CONFIG ĐỔI ĐIỂM</a></li>
    <li role="presentation"><a id="quanlybangdiem" href="#quanlybangdiem" aria-controls="quanlybangdiem" role="tab" data-toggle="tab">QUẢN LÝ BẢNG ĐIỂM</a></li>
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


<div id="modalConfirmYesNo" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="lblTitleConfirmYesNo" class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p id="lblMsgConfirmYesNo"></p>
            </div>
            <div class="modal-footer">
                <button id="btnYesConfirmYesNo"
                        type="button" class="btn btn-primary">Yes</button>
                <button id="btnNoConfirmYesNo"
                        type="button" class="btn btn-default">No</button>
            </div>
        </div>
    </div>
</div>