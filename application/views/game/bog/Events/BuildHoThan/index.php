<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/style.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/datetime/css/bootstrap.css'); ?>"/>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <style>
        #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block; z-index: 99;}
        #loading-image {position: absolute;top: 40%;left: 45%;z-index: 100} 
        label {width: auto !important;color: #f36926;}
    </style>
    <script type="text/javascript">
        var table,url;
        $(document).ready(function () {

            url = '<?php echo $url; ?>';
            getData();

            $('#add-hothan').on('click', function () {
                window.location.href = '/?control=build_hothan&func=edit_hothan#add_hothan';
            });

        });

        function getData() {
            table = $('#data_table').DataTable({
				"aaData": <?php echo $listOfHon; ?>
				,
				aoColumns: [
					{	
						sTitle: "Name",
						mData: "name"
					},
					{
						sTitle: "Image",
						mData: "image",
						mRender: function (image) {
							if(image != null)
								return '<img width="100" height="100" src="/assets/img/hothan/'+image+'  ">';
						}
					},
					{
						sTitle: "Thumb",
						mData: "thumb",
						mRender: function (thumb) {
							if(thumb != null)
								return '<img width="58" height="58" src="/assets/img/hothan/'+thumb+'  ">';
						}
					},
					{
						sTitle: "Brief",
						mData: "brief"
					},
					{
						sTitle: "Description",
						mData: "description"

					},
					{
						sTitle: "",
						mData: "id",
						mRender: function (id, arg1, arg2) {
							return "<a class='btn btn-success btn-xs' href=' /?control=build_hothan&func=edit_hothan&id=" + id + "#edit_hothan '>Chỉnh Sửa</a>";
						}

					},
					{
						sTitle: "",
						mData: "id",
						mRender: function (id, arg1, arg2) {
                            var key = arg2.key;
							return '<a key="'+key+'" id="'+id+'" onclick="delete_hothan(this)" class="btn btn-success btn-xs" href="#edit_hothan">Xóa</a>';
						}

					}

				],
				bProcessing: true,

				bPaginate: true,

				bJQueryUI: false,

				bAutoWidth: false,

				bSort: false,
				bRetrieve: true,
				bDestroy: true,

				sPaginationType: "full_numbers"
			});
        }

        function delete_hothan(me){

            var $confirm = $("#modalConfirmYesNo");
            $confirm.modal('show');
            $("#lblTitleConfirmYesNo").html('Thông Báo');
            $("#lblMsgConfirmYesNo").html('Bạn có muốn xóa hay không?');
            $("#btnYesConfirmYesNo").off('click').click(function () {
                var id = $(me).attr('id');
                var key = $(me).attr('key');
                $.ajax({
                    url: '/?control=build_hothan&func=delete_hothan',
                    data: {id:id,key:key},
                    type: 'POST',
                    success: function (response) {
                        if(response == '1')
                            table.row($(me).closest('tr')).remove().draw( false );
                    }
                });
                $confirm.modal("hide");
            });
            $("#btnNoConfirmYesNo").off('click').click(function () {
                $confirm.modal("hide");
            });



        }


        /*function AsyncConfirmYesNo(msg, yesFn) {
            var $confirm = $("#modalConfirmYesNo");
            $confirm.modal('show');
            $("#lblTitleConfirmYesNo").html('Thong Bao');
            $("#lblMsgConfirmYesNo").html(msg);
            $("#btnYesConfirmYesNo").off('click').click(function () {
                yesFn();
                $confirm.modal("hide");
            });
            $("#btnNoConfirmYesNo").off('click').click(function () {
                $confirm.modal("hide");
            });
        }*/

    </script>
    
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include 'tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">     
                     <div style="margin-top: 10px; margin-bottom: 10px;">
                        <button id="add-hothan"  class="btn btn-primary"><span>THÊM MỚI</span></button>
                    </div>                               
                    <table class="table table-striped table-bordered" id="data_table">      
                    </table>
                </div>
                 <div class="table-overflow">
                    <table class="table table-striped table-bordered" id="data_table_send">      
                    </table>
                </div>
                    </div>
            </div>
        </div>
        <!-- /content wrapper -->


        <div id="modalConfirmYesNo" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button"
                                class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 id="lblTitleConfirmYesNo" class="modal-title">Confirmation</h4>
                    </div>
                    <div class="modal-body">
                        <p id="lblMsgConfirmYesNo"></p>
                    </div>
                    <div class="modal-footer">
                        <button id="btnYesConfirmYesNo"
                                type="button" class="btn btn-primary">Yes</button>
                        <button id="btnNoConfirmYesNo"
                                type="button" class="btn btn-default">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /content -->
</div>
<script type="text/javascript">
    (new TableDnD).init("tblsort");
</script>