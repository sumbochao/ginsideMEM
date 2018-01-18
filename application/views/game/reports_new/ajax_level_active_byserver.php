<table width="100%" id="table2excel" border="0" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <tr>
            <th align="center" width="100px">Date</th>
            <th align="center" width="100px">Server</th>
            <th align="center" width="100px">Level 1->10</th>
            <th align="center" width="100px">Level 11->20</th>
            <th align="center" width="100px">Level 21->30</th>
            <th align="center" width="100px">Level 31->40</th>
            <th align="center" width="100px">Level 41->50</th>
            <th align="center" width="100px">Level 51->60</th>
            <th align="center" width="100px">Level 61->70</th>
            <th align="center" width="100px">Level 71->80</th>
            <th align="center" width="100px">Level 81->90</th>
            <th align="center" width="100px">Level 91->100</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(count($listItems)>0){
                foreach($listItems as $v){
        ?>
        <tr>
            <td>
                <?php 
                    $date = new DateTime($v['date']);
                    echo $date->format('d-m-Y');
                ?>
            </td>
            <td><?php echo $v['server'];?></td>
            <td><?php echo ($v['level0x']>0)?number_format($v['level0x']):'0';?></td>
            <td><?php echo ($v['level1x']>0)?number_format($v['level1x']):'0';?></td>
            <td><?php echo ($v['level2x']>0)?number_format($v['level2x']):'0';?></td>
            <td><?php echo ($v['level3x']>0)?number_format($v['level3x']):'0';?></td>
            <td><?php echo ($v['level4x']>0)?number_format($v['level4x']):'0';?></td>
            <td><?php echo ($v['level5x']>0)?number_format($v['level5x']):'0';?></td>
            <td><?php echo ($v['level6x']>0)?number_format($v['level6x']):'0';?></td>
            <td><?php echo ($v['level7x']>0)?number_format($v['level7x']):'0';?></td>
            <td><?php echo ($v['level8x']>0)?number_format($v['level8x']):'0';?></td>
            <td><?php echo ($v['level9x']>0)?number_format($v['level9x']):'0';?></td>
        </tr>
        <?php
                }
            }else{
        ?>
        <tr>
            <td colspan="12" class="emptydata">Dữ liệu không tìm thấy</td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>