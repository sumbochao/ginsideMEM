<?php $data = json_encode($info["rows"]);?>
<script type="text/javascript" src="http://local.3t.mobo.vn/libraries/pannonia/pannonia/js/plugins/tables/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#data_table').dataTable({
        "aaData": <?php echo $data;?>                
            ,
        aoColumns: [  
                {
                    sTitle: "Item name",
                    mData: "_itemname"
                },                             
               {
                    sTitle: "Desc",
                    mData: "_desc"
                },
                { 
                    sTitle: "Images", 
                    mData: "_thumb",
                    mRender: function(data){
                        return "<img src='"+data+"' width='50px' height='50px' />";
                    }
                    
                 },
                 { 
                    sTitle: "Số lần cược", 
                    mData: "_totalbet"
                    
                 },
                 { 
                    sTitle: "Người cược min", 
                    mData: "_uidmin"
                    
                 },
                 { 
                    sTitle: "Giá cược min", 
                    mData: "_pricemin"
                    
                 },
                 { 
                    sTitle: "InsertDate", 
                    mData: "_insertitem"
                    
                 },
                 { 
                    sTitle: "Status", 
                    mData: "_isdisplay",
                    mRender: function(data){
                        return (data == 1) ? "<span style='color:green'>Enable</span>" : "<span style='color:red'>Disable</span>";
                    }
                    
                 },
                 { 
                    sTitle: "EDIT", 
                    mData: "id",
                    mRender: function(data){
                        return "<a href='/cms/ep/daugia/edititem/?ids="+data+"'>Edit</a>";
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
	})
</script>
<div id="content-t" style="min-height:500px; padding-top:10px">
	<table class="table table-striped table-bordered" id="data_table"></table>
</div>