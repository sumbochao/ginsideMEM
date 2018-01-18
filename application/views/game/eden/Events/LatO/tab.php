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
            window.location.href = "/?control=event_lato_eden&func=index#home";
        });

        $('#thongke').on('click', function (e) {
            window.location.href = "/?control=event_lato_eden&func=thongke#thongke";
        });

        $('#logdoiqua').on('click', function (e) {
            window.location.href = "/?control=event_lato_eden&func=logdoiqua#logdoiqua";
        });

        $('#logthamgia').on('click', function (e) {
            window.location.href = "/?control=event_lato_eden&func=logthamgia#logthamgia";
        });

        $('#logdoiluotbangtien').on('click', function (e) {
            window.location.href = "/?control=event_lato_eden&func=logdoiluotbangtien#logdoiluotbangtien";
        });

        $('#clearcached').on('click', function (e) {
            window.location.href = "/?control=event_lato_eden&func=clearcached#clearcached";
        });
    });
</script>
<style>
.loading {display: none;position: fixed;top: 0;left: 0;right: 0;bottom: 0;background-color: rgba(0,0,0,.7);z-index: 1000;text-align: center;padding-top: 20%;}
</style>
<div class="loading"><img src="/assets/img/loading.gif" /></div>
<h4 class="widget-name">QUẢN LÝ EVENT VÒNG QUAY</h4>   
<!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a id="home" href="#home" aria-controls="home" role="tab" data-toggle="tab">QUẢN LÝ ITEM</a></li>
    <li role="presentation"><a id="thongke" href="#thongke" aria-controls="thongke" role="tab" data-toggle="tab">THỐNG KÊ</a></li>
    <li role="presentation"><a id="logdoiqua" href="#logdoiqua" aria-controls="logdoiqua" role="tab" data-toggle="tab">LOG ĐỔI QUÀ</a></li>
    <li role="presentation"><a id="logthamgia" href="#logthamgia" aria-controls="logthamgia" role="tab" data-toggle="tab">LOG THAM GIA</a></li>
      <li role="presentation"><a id="logdoiluotbangtien" href="#logdoiluotbangtien" aria-controls="logdoiluotbangtien" role="tab" data-toggle="tab">LOG ĐỔI LƯỢT BẰNG TIỀN</a></li>
    <li role="presentation"><a id="clearcached" href="#clearcached" aria-controls="clearcached" role="tab" data-toggle="tab">CLEAR CACHE</a></li>
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