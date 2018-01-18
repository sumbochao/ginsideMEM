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
/*---------------Export-------------*/
#btnExport{
    float: right;
    margin-right: 195px;
}
</style>

<div id="content-t" style="min-height:500px; padding-top:10px">
<?php
	
	if(isset($_POST['server'])){
        $itemSer = $_POST['server'];
    }else{
        $itemSer = $srvItem;
    }
	
	
    $serverDropDown = GMDropDown(array('label' => 'Server', 'name' => 'server', 'id' => 'server', 'option' => $server, 'value' => $itemSer));
    
    $topDropDown = GMDropDown(array('label' => 'Top', 'name' => 'top', 'id' => 'top', 'option' => $arrtop, 'value' => $_POST['top']));
    
    $loaitopDropDown = GMDropDown(array('label' => 'Loại Top', 'name' => 'loaitop', 'id' => 'loaitop', 'option' => $arrloaitop, 'value' => $_POST['loaitop']));
    
    //$pageText = GMText(array('label' => 'Page', 'name' => 'page', 'value' => $page, 'id' => 'page'));
    
    $pageHidden = "<input type='hidden' name='page' id='page' value='".$page."'>";
    
    /*
    $GMDate = GMText(array('label' => 'Date', 'class' => 'datepicker', 'name' => 'date_log', 'id' => 'date_log', 'value' => $_POST['date_log']));
    
    $logDropDown = GMDropDown(array('label' => 'Log Name', 'name' => 'log_name', 'id' => 'log_name', 'option' => $logs, 'value'=>$_POST['log_name']));
    
    $moboaccountText = GMText(array('label' => 'Mobo Account', 'name' => 'mobo_account_log', 'value' => $_POST['mobo_account_log'], 'id' => 'mobo_account'));
    $moboidText = GMText(array('label' => 'Mobo ID', 'name' => 'mobo_id_log', 'value' => $_POST['mobo_id_log'], 'id' => 'mobo_id'));
    $charnameText = GMText(array('label' => 'Character Name', 'name' => 'character_name_log', 'value' => $_POST['character_name_log'], 'id' => 'charactor_name'));
    $charidText = GMText(array('label' => 'Character ID', 'name' => 'character_id_log', 'value' => $_POST['character_id_log'], 'id' => 'charactor_id'));
    
     * 
     */
    $Button = GMButton(array('button' => array(
    
        array('name' => 'btnSubmit', 'type' => 'submit', 'id' => 'btnSubmit', 'value' => 'Search'),
		array('name' => 'btnExport', 'type' => 'button', 'id' => 'btnExport', 'value' => 'Export Excel'),
        )));
    
    
    
    $content = "<br>".$serverDropDown . $loaitopDropDown . $Button . $pageHidden;
    $xhtml = GMGenView(array('content' => $content, 'action' => base_url('?control=game&func=infotop'), 'method' => 'POST', 'legend' => 'FORM SEARCH TOP', 'id'=>'frmtop'));
    echo $xhtml;
    /*
    
    
    
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
    $result_gridview = GMGridView($logs[$_POST['log_name']],'10',$result,${$_POST['log_name'].'H'});
    }
    echo $result_gridview;
    */
      
    if($_POST['loaitop'] == 'toplevel'){
        //$roleField = array('level','roleName','role_id','userName','account_id');
		$roleField = array('Level','roleName','moboName');
        $role_info = GMGridView('Top Level','10',$result,$roleField);
        echo $role_info;
    }else if($_POST['loaitop'] == 'topdanhvong'){
        $roleField = array('fame','fameMax','id','name','teamName','regDate','moneyMax','money','loginDate','loginDayCount','maxBagSize'  );
        $role_info = GMGridView('Top Danh Vọng','10',$result,$roleField);
        echo $role_info;
    }else if($_POST['loaitop'] == 'topthucluc'){
        $roleField = array('lastPushShili','name','teamName','regDate','moneyMax','money','loginDate','loginDayCount','maxBagSize'  );
        $role_info = GMGridView('Top Thực Lực','10',$result,$roleField);
        echo $role_info;
    }else if($_POST['loaitop'] == 'onlineMilliTime'){
        $roleField = array('onlineMilliTime','onlineHourTime','name','teamName','regDate','moneyMax','money','loginDate','loginDayCount','maxBagSize'  );
        $role_info = GMGridView('Thời gian chơi','10',$result,$roleField);
        echo $role_info;
    }elseif ($_POST['loaitop'] == 'hero') {
        $heroField = array('heroName','roleName','enhancedLevel','normalatk','enhancedCoin','sellingPrice','level','grade','soldierMax','decrease','demoteCoin');
        $hero_gridview = GMGridView('Vật phẩm','10',$result,$heroField);
        echo $hero_gridview;
    }elseif ($_POST['loaitop'] == 'userbuy') {
        $userbuyField = array('shopName','money','heroName','roleName');
        $userbuy_gridview = GMGridView('Vật phẩm','10',$result,$userbuyField);
        echo $userbuy_gridview;
    }elseif ($_POST['loaitop'] == 'gold') {
        $goldField = array('value_','roleName');
        $gold_gridview = GMGridView('Top Gold','10',$result,$goldField);
        echo $gold_gridview;
    }elseif ($_POST['loaitop'] == 'rmbamount') {
        $rmbamountField = array('value_','roleName');
        $rmbamount_gridview = GMGridView('Top rmbamount','10',$result,$rmbamountField);
        echo $rmbamount_gridview;
    }elseif ($_POST['loaitop'] == 'heronum') {
        $heronumField = array('value_','roleName');
        $heronum_gridview = GMGridView('Top heronum','10',$result,$heronumField);
        echo $heronum_gridview;
    }elseif ($_POST['loaitop'] == 'pvpwinning') {
        $pvpwinningField = array('value_','roleName');
        $pvpwinning_gridview = GMGridView('Top heronum','10',$result,$pvpwinningField);
        echo $pvpwinning_gridview;
    }
    
        
?>
    
 <?php echo $pages?>
 <br><br>
</div>
<script>
   $(document).ready(function() {
    var oTable = $('#tbl_10').dataTable( {
        "paging":   false,
        //"ordering": false,
        "info":     false,
        //"searchable": false
        
    } );
    
    oTable.fnSort( [ [0,'desc'] ] );
    
    $("#tbl_10_filter label").hide();
    
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
 
 
       
    
/*----------------Export Excel------------------*/
     $("#btnExport").click(function(e){
        e.preventDefault();
        var url = "<?php echo base_url('?control=game&func=exportTop') ?>";
		var urlD = "<?php echo base_url('?control=game&func=infotop') ?>";
        $("#frmtop").attr('action',url);
        $("#frmtop").trigger("submit");
		
		$("#frmtop").attr('action',urlD);
		
        return true;
     });
 

 
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
