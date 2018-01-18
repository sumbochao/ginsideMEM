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
        $('#bangdau').on('click', function (e) {
            window.location.href = "/?control=bangdau_lol&func=bangdau&module=all";
        });
		$('#bangdauv1').on('click', function (e) {
            window.location.href = "/?control=bangdau_lol&func=bangdauv1&module=all";
        });
		$('#config').on('click', function (e) {
            window.location.href = "/?control=bangdau_lol&func=config&module=all";
        });
    });
</script>
<style>
.loading {display: none;position: fixed;top: 0;left: 0;right: 0;bottom: 0;background-color: rgba(0,0,0,.7);z-index: 1000;text-align: center;padding-top: 20%;}
.groupwall{
    font-weight: bold;
}
</style>
<div class="loading"><img src="/assets/img/loading.gif" /></div>
<h4 class="widget-name"><?php echo $title;?></h4>
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" <?php echo $_GET['func']=='bangdau'?'class="active"':'';?>><a id="bangdau" href="#bangdau" aria-controls="bangdau" role="tab" data-toggle="tab">BẢNG ĐẤU</a></li>
	<li role="presentation" <?php echo $_GET['func']=='bangdauv1'?'class="active"':'';?>><a id="bangdauv1" href="#bangdauv1" aria-controls="bangdauv1" role="tab" data-toggle="tab">BẢNG ĐẤU V1</a></li>
	<li role="presentation" <?php echo $_GET['func']=='config'?'class="active"':'';?>><a id="config" href="#config" aria-controls="config" role="tab" data-toggle="tab">BẢNG ĐẤU LCS2016</a></li>
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