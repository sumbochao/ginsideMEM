<style>
.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
  /*background-color: #dff0d8;*/
  background-color: #b0bed9;
 }


#content-t table tbody tr:nth-child(even){
    background: #eee;
}
#content-t table tbody tr:nth-child(odd){
    background: #fff;
}

.tool-head{
    background-color: #D1D119!important;
    padding:5px;
    font-weight: bold;
    color:#f3631e;
    text-transform:uppercase;
}
table tbody tr td.selected {
  background-color: #b0bed9!important;
}

label{
    color: #f36926;
}
</style>

<div id="content-t" style="min-height:500px; padding-top:10px">
<?php
    if(isset($_POST['date_log'])){
        $d = $_POST['date_log'];
    }else{
        $d = date('m/d/Y');
    }

    if(isset($_POST['server'])){
        $srv = $_POST['server'];
    }else{
        //$srv = end(array_keys($server));
		$srv = $srvItem;
    }
    $serverDropDown = GMDropDown(array('label' => 'Server', 'name' => 'server', 'id' => 'server', 'option' => $server, 'value' => $srv));
    
    $GMDate = GMText(array('label' => 'Date', 'class' => 'datepicker', 'name' => 'date_log', 'id' => 'date_log', 'value' => $d));
    
    $logDropDown = GMDropDown(array('label' => 'Log Name', 'name' => 'log_name', 'id' => 'log_name', 'option' => $logs, 'value'=>$_POST['log_name']));
    
    $moboaccountText = GMText(array('label' => 'Mobo Account', 'name' => 'mobo_account', 'value' => $_POST['mobo_account'], 'id' => 'mobo_account'));
    $moboidText = GMText(array('label' => 'Mobo ID', 'name' => 'mobo_id', 'value' => $_POST['mobo_id'], 'id' => 'mobo_id'));
    $charnameText = GMText(array('label' => 'Character Name', 'name' => 'character_name', 'value' => $_POST['character_name'], 'id' => 'charactor_name'));
    $charidText = GMText(array('label' => 'Character ID', 'name' => 'character_id', 'value' => $_POST['character_id'], 'id' => 'charactor_id'));
    $Button = GMButton(array('button' => array(
        array('name' => 'btnSubmit', 'type' => 'submit', 'id' => 'btnSubmit', 'value' => 'Search'),
        )));
    
    $pageHidden = "<input type='hidden' name='page' id='page' value='".$page."'>";
    
    $content = "<br>".$serverDropDown.$GMDate.$logDropDown.$moboaccountText.$charnameText.$charidText.$Button.$pageHidden;
    $xhtml = GMGenView(array('content' => $content, 'action' => base_url('?control=game&func=infolog'), 'method' => 'POST', 'legend' => 'FORM SEARCH LOG', 'id'=>'frmtop'));
    echo $xhtml;
       
    $chestH = array('createTime','chestName','roleName','serverId','boxCode','openType','boxName');
    $clienterrorlogH = array('createTime','roleId','roleName','errorStr');
    $currencyH = array('createTime','roleId','roleName','currencyType','count','consumeType','desc');
    $helperH = array('createTime','roleId','roleName','roleReg','helpCode','helpName');
    $logincountH = array('createTime','roleId','roleName','loginTime','channel');
    $mallH = array('createTime','roleId','roleName','name','number','payType','payMoney');
    $missionH = array('createTime','missionName','roleName','roleReg');
    $rolelevelH = array('createTime','roleId','roleName','roleReg','level','channel');
    $roleopenboxlogH = array('date','roleId','roleName','openBoxCount','boxType','memberChipId','randWeiSuijiEventCount','memberName','vipLevel');
    if($_POST['log_name'] == 'mission'){
    $result_gridview = GMGridViewM($logs[$_POST['log_name']],'11',$result,${$_POST['log_name'].'H'});
    }else{
    $result_gridview = GMGridView($logs[$_POST['log_name']],'10',$result);
    }
    echo $result_gridview;
      
?>
    
<?php echo $pages?>
<br><br>  
</div>
<script>
   $(document).ready(function() {
    $('#tbl_10').dataTable( {
        "paging":   false,
        //"ordering": false,
        "info":     false,
        //"searchable": false
    } );
    $("#tbl_10_filter label").hide();
    /*
    $('#tbl_11').dataTable( {
       "info":     false,
    } );
    $("#tbl_11_filter label").hide();
    
    $('#tbl_12').dataTable( {
       "info":     false,
    } );
    $("#tbl_12_filter label").hide();
    
    $('#tbl_13').dataTable( {
       "info":     false,
    } );
    $("#tbl_13_filter label").hide();
    
    $('#tbl_14').dataTable( {
       "info":     false,
    } );
    $("#tbl_14_filter label").hide();
    
    $('#tbl_15').dataTable( {
       "info":     false,
    } );
    $("#tbl_15_filter label").hide();
    
    $('#tbl_16').dataTable( {
       "info":     false,
    } );
    $("#tbl_16_filter label").hide();
    */
   
    
    $('#tbl_11').dataTable( {
       "paging":   false,
       "info":     false,
    } );
    $("#tbl_11_filter label").hide();
   
   $('table#tbl_10 tbody tr').click(function () {
        $(this).children().toggleClass('selected');
                
    } );
     //$('table tbody').on( 'click', 'tr', function () {
    $('table#tbl_11 tbody tr.odd').click(function () {
        $(this).children().toggleClass('selected');
        
        if($(this).children().hasClass('selected')){
            var th = $(this);
            var id = th.attr('rel');
            $.get("<?php echo base_url('?control=game&func=mission') ?>&id="+id).done(function(data) {
                    //console.log(data);
                    th.after(JSON.parse(data));
                    //th.after("<tr><td colspan='4'><table><tr><td>jhh</td><td>jjjjj</td></tr></table></td></tr>");
            });
        }else{
            $(this).next().remove('tr');
        }
        
    } );
   
   $('table#tbl_11 tbody tr.even').click(function () {
        $(this).children().toggleClass('selected');
        
        if($(this).children().hasClass('selected')){
            var th = $(this);
            var id = th.attr('rel');
            $.get("<?php echo base_url('?control=game&func=mission') ?>&id="+id).done(function(data) {
                    //console.log(data);
                    th.after(JSON.parse(data));
                    //th.after("<tr><td colspan='4'><table><tr><td>jhh</td><td>jjjjj</td></tr></table></td></tr>");
            });
        }else{
            $(this).next().remove('tr');
        }
        
    } );
    
     //Phan trang
     $("#frmtop").submit(function(e){
        //e.preventDefault();
     });
     
     $("#btnSubmit").click(function(e){
        e.preventDefault();
        $("#page").val(1);
        $("#frmtop").trigger("submit");
     });
     
     $(".pagination li").click(function(e){
        e.preventDefault();
        $("#page").val($(this).attr('p'));
        $("#frmtop").trigger("submit");
     });
   
    
 } );
 </script>
 
 <style type="text/css">
    #bttop
    {
        border: 0 solid #4adcff;
        text-align: center;
        position: fixed;
        bottom: 5px;
        right: 15px;
        cursor: pointer;
        display: none;
        color: #fff;
        font-size: 11px;
        font-weight: 900;
        padding: 5px;
        opacity: 0.55;
    }
</style>
<div style="display: none;" id="bttop">
    <img src="<?= base_url() ?>assets/img/to-top.png" alt="" width="35">
</div>
<script type="text/javascript">
    $(function () { $(window).scroll(function () { if ($(this).scrollTop() != 0) { $('#bttop').fadeIn(); } else { $('#bttop').fadeOut(); } }); $('#bttop').click(function () { $('body,html').animate({ scrollTop: 0 }, 800); }); });
</script>
 

