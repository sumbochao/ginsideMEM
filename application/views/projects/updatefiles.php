<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/theme.css');?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>"/>
<script src="<?php echo base_url('assets/datetime/js/jquery-1.11.1.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/chosen.jquery.js'); ?>" type="text/javascript"></script>                 
<link rel="stylesheet" href="<?php echo base_url('assets/css/chosen.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.css'); ?>"/>
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<div id="content-t" class="content_form" style="min-height:500px; padding-top:10px">
<div id="adminfieldset" class="groupsignios space">
            <!--<div class="adminheader"><strong>In App Items</strong></div>-->
            <div class="group_left">
                <div class="rows" style="margin-bottom:15px;">
                File hiện tại :<a href="<?php echo base_url().$_GET['filename'] ?>" style="color:#900;text-decoration:none"><?php echo $_GET['filename'] ?></a>
                </div>
                <div class="rows">	
                    <label for="menu_group_id"></label>
                    <form name="frmupload" enctype="multipart/form-data" method="post">
                	<label for="menu_group_id">APN Certificates (.zip)</label>
                    <input type="hidden" name="files_certificates_h" id="files_certificates_h"  />
                    <input type="file" name="files_certificates" id="files_certificates" accept=".*" />
                    <input type="button" name="btnupload" value="Upload" onclick="uploadajax();" />
                    <div id="messinfo" class="proccess" style="font-size:14px;color:#002099;"></div>
                    </form>
                     
                </div>
                <hr />
            </div>
           
            <div class="clr"></div>
        </div>
 </div> <!--content-t-->
<script language="javascript">
function callboth(){
	uploadajax();
	updatefilename();
}
function uploadajax(){
	var _file=document.getElementById('files_certificates');
	var i=0;
	if(_file.files.length === 0){
        return;
    }
    var data = new FormData();
    data.append('files_certificates', _file.files[0]);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function(){
        if(request.readyState == 4){
            try {
                var resp = JSON.parse(request.response);
				$('#files_certificates_h').val(resp.filename);
				updatefilename(resp.filename);
            } catch (e){
                var resp = {
                    status: 'error',
                    data: 'Unknown error occurred: [' + request.responseText + ']'
                };
            }
            //console.log(resp.status + ': ' + resp.data);
        }
    };
	 request.upload.addEventListener('progress', function(e){
        i++;
		document.getElementById('messinfo').innerHTML = i + '%';
    }, false);
	request.open('POST', 'upload.php');
    request.send(data);		
   
}

function updatefilename(_fname){
	//_fname=document.getElementById('files_certificates_h').value;
	$.ajax({
		url:'<?php echo base_url(); ?>?control=projects&func=updatefiledatabase',
		type:"GET",
		data:{id:<?php echo $_GET['id'] ?>,files_certificates:_fname},
		async:false,
		dataType:"html",
		beforeSend:function(){
		},
		success:function(response){
			if(response=='ok'){
				$('#messinfo').text('Cập nhật file thành công');
				
			}else{
				$('#messinfo').text(response);
			}
		}
	});	
}
	
</script>