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
	 if(isset($_POST['server'])){
        $srv = $_POST['server'];
    }else{
        //$srv = end(array_keys($server));
        //$srv = end(array_values($server));
		$srv = $srvItem;
    }
    
    $serverDropDown = GMDropDown(array('label' => 'Server', 'name' => 'server', 'id' => 'server', 'option' => $server, 'value' => $srv));
    
     $pageHidden = "<input type='hidden' name='page' id='page' value='".$page."'>";
    
  
    $Button = GMButton(array('button' => array(
    
        array('name' => 'btnSubmit', 'type' => 'submit', 'id' => 'btnSubmit', 'value' => 'Search'),
        )));
    
    
    
    $content = "<br>".$serverDropDown . $Button . $pageHidden;
    $xhtml = GMGenView(array('content' => $content, 'action' => base_url('?control=game&func=infoitem'), 'method' => 'POST', 'legend' => 'FORM ITEM ON SERVER', 'id'=>'frmtop'));
    echo $xhtml;
    
    $item_gridview = GMGridView('Items','10',$result);
    echo $item_gridview;
        
?>
    
 <?php //echo $pages?>
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
