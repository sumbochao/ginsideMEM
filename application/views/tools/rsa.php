<?php
/**
 * Created by Ivoglent Nguyen.
 * User: longnv
 * Date: 12/23/13
 * Time: 4:02 PM
 * Project : service.8t.mobo.vn
 * File : rsa.php
 */
?>
<center><h3>RSA DECRYPTOR</h3></center>
<?php
if(isset($plain_text)){
    echo 'Plain Text : <br><textarea rows="3" cols="50">'.$plain_text.'</textarea><br>';
}
?>
<form action="" method="post">
    Encrypted text : <br>
   <input type="text" name="enc_text" size="50"><br>
    <input type="submit" value="Decrypt">
</form>