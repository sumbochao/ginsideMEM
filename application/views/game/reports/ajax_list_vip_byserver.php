<div>
    <table width="100%" border="0" id="table2excel" class="table table-striped table-bordered table-condensed table-hover">
        <thead>
            <tr>
                <th align="center">STT</th>
                <th align="center">UID</th>
                <th align="center">Custom Name</th>
                <th align="center">Level</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if(is_array($listItems)){
                    $i=0;
                    foreach($listItems as $v){
                        $i++;
            ?>
            <tr>
                <td><?php echo number_format($i,0);?></td>
                <td><?php echo $v['uid'];?></td>
                <td><?php echo $v['customName'];?></td>
                <td><?php echo $v['level'];?></td>
            </tr>
            <?php
                    }
                }else{
            ?>
            <tr>
                <td colspan="4">Dữ liệu không tìm thấy</td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>