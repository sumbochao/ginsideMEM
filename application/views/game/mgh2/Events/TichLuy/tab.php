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
        $('#home').on('click', function (e) {
            window.location.href = "/?control=tichluy_mgh2&func=index&module=all#home";
        });

        $('#giaidau').on('click', function (e) {
            window.location.href = "/?control=tichluy_mgh2&func=giaidau&module=all#giaidau";
        });  
        
        $('#giaidau_totaldate').on('click', function (e) {
            window.location.href = "/?control=tichluy_mgh2&func=giaidau_totaldate&module=all#giaidau_totaldate";
        });

        $('#giaithuong').on('click', function (e) {
            window.location.href = "/?control=tichluy_mgh2&func=giaithuong&module=all#giaithuong";
        });
        
         $('#giaithuongtop').on('click', function (e) {
            window.location.href = "/?control=tichluy_mgh2&func=giaithuongtop&module=all#giaithuongtop";
        });

        $('#giaithuongpremiership').on('click', function (e) {
            window.location.href = "/?control=tichluy_mgh2&func=giaithuongpremiership&module=all#giaithuongpremiership";
        });

        $('#lichsu_sendnl').on('click', function (e) {
            window.location.href = "/?control=tichluy_mgh2&func=lichsu_sendnl&module=all#lichsu_sendnl";
        });
        
        $('#sendnl').on('click', function (e) {
            window.location.href = "/?control=tichluy_mgh2&func=sendnl&module=all#sendnl";
        });
        
        
    });
</script>
<style>
.loading {display: none;position: fixed;top: 0;left: 0;right: 0;bottom: 0;background-color: rgba(0,0,0,.7);z-index: 1000;text-align: center;padding-top: 20%;}
</style>
<div class="loading"><img src="/assets/img/loading.gif" /></div>
<h4 class="widget-name">QUẢN LÝ EVENT TÍCH LŨY SERVER</h4>   
<!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a id="home" href="#home" aria-controls="home" role="tab" data-toggle="tab">ĐÓNG MỞ EVENT</a></li>
    <li role="presentation"><a id="giaidau" href="#giaidau" aria-controls="giaidau" role="tab" data-toggle="tab">GIẢI ĐẤU</a></li>    
    <li role="presentation"><a id="giaidau_totaldate" href="#giaidau_totaldate" aria-controls="giaidau_totaldate" role="tab" data-toggle="tab">TOTAL DATE CONFIG</a></li>
    <li role="presentation"><a id="sendnl" href="#sendnl" aria-controls="sendnl" role="tab" data-toggle="tab">SEND NGÂN LƯỢNG</a></li>
    <li role="presentation"><a id="lichsu_sendnl" href="#lichsu_sendnl" aria-controls="lichsu_sendnl" role="tab" data-toggle="tab">LỊCH SỬ SEND NGÂN LƯỢNG</a></li>
    <!--<li role="presentation"><a id="giaithuongtop" href="#giaithuongtop" aria-controls="giaithuongtop" role="tab" data-toggle="tab">GIẢI THƯỞNG TOP</a></li>
    <li role="presentation"><a id="giaithuongpremiership" href="#giaithuongpremiership" aria-controls="giaithuongpremiership" role="tab" data-toggle="tab">GIẢI THƯỞNG NGOẠI HẠNG</a></li>
    -->
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