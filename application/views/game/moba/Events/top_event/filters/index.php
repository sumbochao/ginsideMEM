<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#create').on('click', function () {
                window.location.href = '/?control=top_event_moba&func=add&view=<?php echo $_GET['view'];?>&module=all';
            });
        });
    </script>
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">
            <?php include APPPATH . 'views/game/moba/Events/top_event/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>
            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                    <div class="table-overflow">     
                        <div style="margin-top: 10px; margin-bottom: 10px;">
                            <button id="create"  class="btn btn-primary"><span>THÊM MỚI</span></button>
                        </div>                               
                        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tblsort">
							<thead>
								<tr>
									<th align="center" width="50px">STT</th>
									<th align="center">Server</th>
									<th align="center" width="200px">Ngày bắt đầu</th>
									<th align="center" width="200px">Ngày kết thúc</th>
									<th align="center" width="100px">Tình trạng</th>
									<th align="center" width="150px">Chức năng</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if(empty($listItem) !== TRUE){
										$i=0;
										foreach($listItem as $i=>$v){
											$i++;
								?>
								<tr>
									<td><?php echo $i;?></td>
									<td style="text-align:left"><?php echo $v['serverid'];?></td>
									<td><?php echo date_format(date_create($v['startdate']),"d-m-Y G:i:s");?></td>
									<td><?php echo date_format(date_create($v['enddate']),"d-m-Y G:i:s");?></td>
									<td>
										<?php
											$imgActive = ($v['status']==1)?'active.png':'inactive.png';
											echo '<img border="0" title="Duyệt" src="'.base_url().'assets/img/'.$imgActive.'">';
										?>
									</td>
									<td>
										<?php
											$btnEdit = '
												<a href="'.base_url()."?control=".$_GET['control']."&func=edit&view=".$_GET['view']."&serverid=".$v['serverid'].'&module=all" title="Sửa">
													<img border="0" title="Sửa" src="'.base_url().'assets/img/icon_edit.png"> 
												</a>';
											echo $btnEdit;
										?>
										
										
									</td>
								</tr>
								<?php
										}
									}else{
								?>
								<tr>
									<td colspan="11" class="emptydata">Dữ liệu không tìm thấy</td>
								</tr>
								<?php
									}
								?>
							</tbody>
						</table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /content wrapper -->
    </div>
    <!-- /content -->
</div>