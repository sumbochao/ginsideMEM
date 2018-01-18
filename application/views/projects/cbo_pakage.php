
 <?php
        if(count($package)>0){
			echo '<option value="0">BundleID PackageName PackageIdentity</option>';
            foreach($package as $v){
    ?>
    <option value="<?php echo $v['package_name'].";".$v['id'];?>"><?php echo $v['package_name'];?></option>
    <?php
            }
        }else{
			echo '<option value="0">BundleID PackageName PackageIdentity</option>';
		}
    ?>