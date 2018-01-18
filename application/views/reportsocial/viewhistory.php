<div tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="myCart">
    <div id="frmMain">
        <div class="modal-header">
          <button onclick="closePopup();" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Xem lịch sử</h3>
        </div>
        <form name="frmLogin" action="" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="wrapper_scroolbar">
                    <div class="scroolbar">
                        <table width="100%" border="0" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th align="center">STT</th>
                                    <th align="center">Ngày thực hiện</th>
                                    <th align="center">Ngày giao dịch</th>
                                    <th align="center">Mobo ID</th>
                                    <th align="center">Mobo Service ID</th>
                                    <th align="center">Transaction ID</th>
                                    <th align="center">Character ID</th>
                                    <th align="center">Character Name</th>
                                    <th align="center">Server ID</th>     
                                    <th align="center">Type</th>
                                    <th align="center">Amount</th>
                                    <th align="center">Mcoin</th>
                                    <th align="center">Money</th>
                                    <th align="center">Platform</th>
                                    <th align="center">Payment desc</th>
                                    <th align="center">Description</th>
									<th align="center">Tình trạng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(empty($listItems) !== TRUE){
                                        $i=0;
                                        foreach($listItems as $v){
                                            $i++;
                                ?>
                                <tr>
                                    <td align="center"><?php echo $i;?></td>
                                    <td align="center" class="space_wrap"><?php echo gmdate('d-m-Y G:i:s',  strtotime($v['date'])+7*3600);?></td>
                                    <td align="center" class="space_wrap">
                                        <?php 
                                            $arrBr = explode(" ", $v['time_stamp']);$dateArr = explode('-', $arrBr[0]);
                                            echo $dateArr['2'].'-'.$dateArr['1'].'-'.$dateArr['0'].' '.$arrBr[1];
                                        ?>
                                    </td>
                                    <td align="center"><?php echo $v['mobo_id'];?></td>
                                    <td align="center"><?php echo $v['mobo_service_id'];?></td>
                                    <td align="center"><?php echo $v['transaction_id'];?></td>
                                    <td align="center"><?php echo $v['character_id'];?></td>
                                    <td align="center"><?php echo $v['character_name'];?></td>
                                    <td align="center"><?php echo $v['server_id'];?></td>
                                    <td align="center"><?php echo $v['type'];?></td>
                                    <td align="center"><?php echo $v['amount'];?></td>
                                    <td align="center"><?php echo $v['mcoin'];?></td>
                                    <td align="center"><?php echo $v['money'];?></td>
                                    <td align="center"><?php echo $v['platform'];?></td>
                                    <td align="center"><?php echo $v['payment_desc'];?></td>
                                    <td align="center"><?php echo $v['description'];?></td>
									<td align="center">
                                        <span class="red">
                                        <?php
                                            switch ($v['status']){
                                                case 0:
                                                   echo 'Khởi tạo [0].';
                                                   break;
                                                case 1:
                                                   echo 'Giao dịch thành công [1].';
                                                   break;
                                                case 2:
                                                   echo 'Giao dịch thất bại [2].';
                                                   break;
                                            }
                                        ?>
                                        </span>
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
            <div class="modal-footer"></div>
        </form>
    </div>
</div>