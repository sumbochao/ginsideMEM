<?php
require_once ('ActiveResource.php');
// call api
class Issue extends ActiveResource {
    var $site = 'http://me.coordinator:me.coordinator@128.199.129.217/';
    var $request_format = 'xml'; // REQUIRED!
}
class RedmineAPI{
	public function __construct() {
      $this->CI = & get_instance();
    }
	public function create_new_issues($projects_id,$subject,$desc,$assigned_to_id){
		$param=array(
			'@id'=>15,
			'name'=>'Work Pharses',
			'multiple'=>true,
			'value'=>array('9. Client - QC Testing'),
		);
	
	// create a new issue
	$issue = new Issue (array ('description'=>$desc,'subject'=>$subject,'project_id' =>$projects_id,'tracker_id' => '4','status_id'=>'1','priority_id'=>'3','assigned_to_id '=>$assigned_to_id,'custom_fields'=>array('@type'=>'array','custom_field' =>$param)));
		$issue->save();
		//$issue1 = new Issue();
		$issues = $issue->find ('all',array('project_id'=>$projects_id));
		return $issues[count($issues)-25]->id;
		//return 1111;
	}
	public function get_project_redmine(){
		//Projects
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://me.coordinator:me.coordinator@128.199.129.217/projects.xml?limit=1000");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}//end func
	
	public function SetDescRedmine($param){
		/*$str="Dear Coor&#44; QC&#44; All
Đã có bản mới tại thư mục&#58;
".$param."
Ghi chú&#58; Map ổ đĩa Y&#58;&#47; với đường dẫn mạng&#47;ad01&#47;ME&#46;GAME-RES
		QC và các team tiến hành test&#46; Nếu tìm thấy Bug, vui lòng báo Bug trong subtask của Task này để dễ monitor
Nội dung test chính&#58;
&#45; Đăng ký Mobo, Facebook &#46;&#46;&#46; &#47;Login&#47;Logout Game&#47;Log out SDK&#47;Chuyển tài khoản&#47;Chuyển Server&#47;Kích hoạt tài khoản
&#45; Push Notification
&#45; Tracking Marketing Code
&#45; Thanh toán các kiểu&#44; bao gồm InApp&#44; Mopay&#44; SMS, Banking
&#45; Đứt kết nối&#44; timeout&#44; tắt nguồn&#44; mở app từ background
&#45; Kiểm tra mapping tài khoản Game khác tài khoản Mobo
&#45; Play Game
&#45; Check policy icloud storage
&#46;&#46;&#46;&#46;&#46;&#46;

Thanks";*/
$str="&#34;Dear Coor&#44; QC&#44; All Đã có bản mới tại thư mục ".$param."  Ghi chú&#58; Map ổ đĩa Y&#58;&#47; với đường dẫn mạng ad01&#47;ME&#46;GAME&#58;RES Nội dung client game&#58; &#45; &#45; Nội dung bug đã fix&#58; &#45; &#45; QC và các team tiến hành test&#46; Nếu tìm thấy Bug&#44; vui lòng báo Bug trong subtask của Task này để dễ monitor. Nội dung test chính&#58; &#45; Đăng ký Mobo&#44;Facebook &#47;Login&#47;Logout Game&#47;Log out SDK&#47;Chuyển tài khoản&#47;Chuyển Server&#47;Kích hoạt tài khoản &#45; Push Notification &#45; Tracking Marketing Code &#45; Thanh toán các kiểu&#44; bao gồm InApp&#44; Mopay&#44; SMS&#44; Banking&#44; &#45; Đứt kết nối&#44; timeout&#44; tắt nguồn&#44; mở app từ background&#46;&#46;&#46;&#46;&#46;&#46; &#45; Kiểm tra mapping tài khoản Game khác tài khoản Mobo &#45; Play Game &#45; Check policy icloud storage &#46;&#46;&#46;&#46;&#46;&#46; Thanks&#34;";
		return $str;
	} //end func
	public function SetSubjectsRedmine($sdk,$bundle){
		$str="iOS Yêu cầu test phiên bản Game ".$sdk."_SDK ".$bundle."_BundleID";
		return $str;
	} //end func
}
?>