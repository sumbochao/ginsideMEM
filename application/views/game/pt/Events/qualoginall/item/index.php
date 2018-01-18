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
            getData();

            $('#create_boxitem').on('click', function () {
                window.location.href ='?control=logindayall&func=add&view=item';
            });
        });

        function getData() {
            $.ajax({
                url: "<?php echo $url;?>/index_item",
                dataType: 'jsonp',
                method: "POST",
                bRetrieve: true,
                bDestroy: true,
                error: function (jqXHR, textStatus, errorThrown) {
                },
                success: function (data, textStatus, jqXHR) {
                    $('#data_table').dataTable({
                        "aaData": data.rows
                        ,
                        aoColumns: [
							{
                                sTitle: "Game",
                                mData: "game"
                            },
                            {
                                sTitle: "Item Name",
                                mData: "itemname"
                            },
                            {
                                sTitle: "Items",
                                mData: "items",
                                mRender: function(data){
                                    var myObject = eval('(' + data + ')');
                                    var xhtml = '';
                                    for (i in myObject){
                                        xhtml += '<b>ID:</b> '+myObject[i]["item_id"]+ ' <b>- Name:</b> '+myObject[i]["name"]+ '<b> - Count:</b> '+myObject[i]["count"]+'<br>';
                                        //alert(myObject[i]["name"]);
                                    }
                                    return xhtml;
                                }
                            },
                            {
                                sTitle: "Status",
                                mData: "status",
                                mRender: function(data){
                                    return (data == 1) ? "<span style='color:green'>Enable</span>" : "<span style='color:red'>Disable</span>";
                                }

                            },
                            {
                                sTitle: "Action",
                                mData: "id",
                                mRender: function(data){
                                    return "<a href='?control=logindayall&func=edit&view=item&ids="+data+"'>Edit</a> <span style='padding-left:10px'><a href='?control=qualogin&func=delete&view=item&ids="+data+"'>Delete</a></span>";
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
            });
        }
    </script>
    
    <!-- Content -->
    <div id="content">
        <!-- Content wrapper -->
        <div class="wrapper">                     
            <?php include APPPATH . 'views/game/pt/Events/qualoginall/tab.php'; ?>
            <div class="widget-name">
                <div class="clearboth"></div>
            </div>

            <!--END CONTROL ADD CHEST-->
            <div class="widget" id="viewport">
                <div class="well form-horizontal">
                <div class="table-overflow">     
                     <div style="margin-top: 10px; margin-bottom: 10px;">
                        <button id="create_boxitem"  class="btn btn-primary"><span>THÊM MỚI</span></button>
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
    </div>
    <!-- /content -->
</div>
<script type="text/javascript">
    (new TableDnD).init("tblsort");
</script>