<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<style>
    .ordertext{
        background:none !important;
        border: 0px !important;
        box-shadow:none !important;
    }
</style>
<script>
$('document').ready(function(){
		var groupmenu ='';
		$('#typeGame').change(function() {
            groupmenu = $(this).val();
            html = "";
            html += "<option value='0' selected>---Chon GiftCode---</option>";
            if(groupmenu ==0){
                alert('Vui lòng chọn Game');
                return false;
            }
			
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/?control=giftcodemanager&func=ajaxloadgame",
                data: {idgame:groupmenu},
                beforeSend: function(  ) {
                    console.log('starting...');
                }
            }).done(function(result) {
                console.log(result);
                //hide your loading file here
                $.each(result.data,function(key, el) {
                    html += "<option value='"+el.idx+"' >"+ el.display_name+"</option>";
                });

                $('#typegiftcode').html(html);

            });
        });
		
		$('#typegiftcode').change(function() {
			typegiftcode = $(this).val();
			 if(checkType() == false ){
                return false;
            }
			
			$.ajax({
                type: "POST",
                dataType: 'json',
                url: "/?control=giftcodemanager&func=loadgiftcode",
                data: {idgame:groupmenu,typegiftcode:typegiftcode},
                beforeSend: function(  ) {
                    console.log('starting...');
                }
            }).done(function(result) {
                console.log(result);
                $('.loaddata').html(result.data);

            });
			
		});

});		
function checkType(){
        typeParnet = $('#typeParnet').val();
        typeGame = $('#typeGame').val();
        if (typeParnet == 0 || typeGame == 0) {
            $('.control-group .error').text('Thông tin nhập không chính xác vui lòng nhập lại');
            return false;
        }
        return true;
    }
</script>
<script type="text/javascript">
    (new TableDnD).init("tblsort");
</script>
<?php
	if($_SESSION['permission']['tethien3d']=='tethien3d'){
		$_SESSION['permission']['tethien'] = 'tethien';
	}
?>
<div class="loading_warning"></div>
<div id="content-t" class="loadNavigator" style="min-height:500px; padding-top:10px">
    <form id="appForm" action="" method="post" name="appForm">
        <div class="filter">
            <select name="typeGame" id="typeGame" class="span4 validate[required]">
			<option value="0">Chọn game</option>
                <?php
                    if(count($menu_game)>0){
                        foreach ($menu_game as $g) {
                            ?>
                            <option value="<?php echo $g['alias'] ?>"><?php echo $g['display_name'] ?></option>

                        <?php
                        }
                    }
                ?>
            </select>
			&nbsp;&nbsp;
                    <label class="control-label">Type GiftCode:</label>
                    <select name="typegiftcode" id="typegiftcode" class="span4 validate[required]">
                    
					</select>
        </div>
		
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
            <thead>
                <tr>
                    <th align="center" width="50px">GiftCode</th>
                    <th align="center" width="50px">Game</th>
                    <th align="center" width="70px">ServerID</th>
                    <th align="center" width="60px">Description</th>
                    <th align="center" width="60px">TypeGiftCode</th>
                    <th align="center" width="145px">ActorCreate</th>
                    <th align="center" width="145px">Status</th>
                    <th align="center" width="60px">InsertDate</th>
                    <th align="center" width="50px">Order</th>
                </tr>
            </thead>
            <tbody class="loaddata">
                
            </tbody>
        </table>
        <?php echo $pages?>
    </form>
</div>