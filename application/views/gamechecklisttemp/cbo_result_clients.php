<option value="None"  <?php echo $result_client['result_'.$types]=="None"?"selected":""; ?> >None</option>
                        <option value="Pass" <?php echo $result_client['result_'.$types]=="Pass"?"selected":""; ?>>Pass</option>
                        <option value="Fail" <?php echo $result_client['result_'.$types]=="Fail"?"selected":""; ?>>Fail</option>
                        <option value="Cancel" <?php echo $result_client['result_'.$types]=="Cancel"?"selected":""; ?>>Cancel</option>
                        <option value="Pending" <?php echo $result_client['result_'.$types]=="Pending"?"selected":""; ?>>Pending</option>
                        <option value="InProccess" <?php echo $result_client['result_'.$types]=="InProccess"?"selected":""; ?>>InProccess</option>