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
        var hash = window.location.hash;
        $('#home').on('click', function (e) {
            if(hash != "#home"){
                $(".loading").fadeIn("fast");
            }
            window.location.href = "/?control=managercontributor&func=managesalary#home";
        });

        $('#duyetluong').on('click', function (e) {
            if(hash != "#duyetluong"){
                $(".loading").fadeIn("fast");
            }
            window.location.href = "/?control=managercontributor&func=managesalary&view=approvalsalary#duyetluong";
            
        });
        
        $('#duyetluong2').on('click', function (e) {
            if(hash != "#duyetluong2"){
                $(".loading").fadeIn("fast");
            }
            window.location.href = "/?control=managercontributor&func=managesalary&view=approvalsalarylvl2#duyetluong2";
        });

//        
//        $('#quanlyqua').on('click', function (e) {
//            window.location.href = "/?control=khongdoitroichung_mt&module=all&func=quanlyqua#quanlyqua";
//        }); 

        $('#lichsu').on('click', function (e) {
            if(hash != "#lichsu"){
                $(".loading").fadeIn("fast");
            }
            window.location.href = "/?control=managercontributor&func=managesalary&view=history#lichsu";
        });
    });
</script>
<style>
    .loading {display: none;position: fixed;top: 0;left: 0;right: 0;bottom: 0;background-color: rgba(0,0,0,.7);z-index: 1000;text-align: center;padding-top: 20%;}
</style>
<div class="loading"><img src="/assets/img/loading.gif" /></div>
<h4 class="widget-name">QUẢN LÝ LƯƠNG CỘNG TÁC VIÊN</h4>   
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a id="home" href="#home" aria-controls="home" role="tab" data-toggle="tab">DANH SÁCH</a></li>
    <?php if ((@in_array('managercontributor-managesalary-approvalsalary', $_SESSION['permission']) && $_SESSION['account']['id_group'] == 2) || $_SESSION['account']['id_group'] == 1): ?>
        <li role="presentation"><a id="duyetluong" href="#duyetluong" aria-controls="duyetluong" role="tab" data-toggle="tab">DUYỆT LƯƠNG CẤP 1</a></li>
    <?php endif; ?>
    <?php if ((@in_array('managercontributor-managesalary-approvalsalarylvl2', $_SESSION['permission']) && $_SESSION['account']['id_group'] == 2) || $_SESSION['account']['id_group'] == 1): ?>
        <li role="presentation"><a id="duyetluong2" href="#duyetluong2" aria-controls="duyetluong2" role="tab" data-toggle="tab">DUYỆT LƯƠNG CẤP 2</a></li>
    <?php endif; ?>
    <li role="presentation"><a id="lichsu" href="#lichsu" aria-controls="lichsu" role="tab" data-toggle="tab">LỊCH SỬ</a></li>
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