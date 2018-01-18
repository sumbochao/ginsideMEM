<style>
.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
  background-color: #dff0d8;
}
#content-t table tbody tr:nth-child(even){
    background: #eee;
}
#content-t table tbody tr:nth-child(odd){
    background: #fff;
}
</style>
<div id="content-t" style="min-height:500px; padding-top:10px">
    <form action="" method="post" name="frmindex">
        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <tr>
                    <th align="center">Code</th>
                    <th align="center">Desc</th>
                    <th align="center">Data</th>
                    <th align="center">message</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(is_array($items)){
                ?>
                <tr>
                    <td align="center"><?php echo $items['code'];?></td>
                    <td align="center"><?php echo $items['desc'];?></td>
                    <td align="center">
                        <?php
                            if(is_array($items['data'])){
                                $i=0;
                                foreach($items['data'] as $k=>$v){
                                    $i++;
                                    echo ($i!=1)?', ':'';
                                    echo $k.':'.$v;
                                }
                            }else{
                                echo $items['data'];
                            }
                        ?>
                    </td>
                    <td align="center"><?php echo $items['message'];?></td>
                </tr>
                <?php
                    }else{
                ?>
                <tr>
                    <td align="center" colspan="4"><?php echo $items;?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>
</div>