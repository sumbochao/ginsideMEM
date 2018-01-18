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
        $('#game').on('click', function (e) {
            window.location.href = "/?control=buyaccount&func=index&view=game&module=all";
        });
        $('#user').on('click', function (e) {
            window.location.href = "/?control=buyaccount&func=index&view=user&module=all";
        });
        $('#check_otp').on('click', function (e) {
            window.location.href = "/?control=buyaccount&func=index&view=check_otp&module=all";
        });
    });
</script>
<style>
    .loading {display: none;position: fixed;top: 0;left: 0;right: 0;bottom: 0;background-color: rgba(0,0,0,.7);z-index: 1000;text-align: center;padding-top: 20%;}
    .groupwall{
        font-weight: bold;
    }
    .nav.nav-tabs{
        margin-bottom: 10px;
    }
</style>
<div class="loading"><img src="/assets/img/loading.gif" /></div>
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" <?php echo $_GET['view'] == 'game' ? 'class="active"' : ''; ?>><a id="game" href="#game" aria-controls="game" role="tab" data-toggle="tab">DANH SÁCH GAME</a></li>
    <li role="presentation" <?php echo $_GET['view'] == 'user' ? 'class="active"' : ''; ?>><a id="user" href="#user" aria-controls="user" role="tab" data-toggle="tab">DANH SÁCH USER</a></li>
    <li role="presentation" <?php echo $_GET['view'] == 'check_otp' ? 'class="active"' : ''; ?>><a id="check_otp" href="#check_otp" aria-controls="check_otp" role="tab" data-toggle="tab">RULE OTP</a></li>
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