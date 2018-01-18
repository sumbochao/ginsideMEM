<?php
error_reporting(0);
class MeAPI_Controller_GiftcodeManagerController implements MeAPI_Controller_GiftcodeManagerInterface {
    /* @var $cache_user CI_Cache  */
    /* @var $cache CI_Cache  */

    protected $_response;

    /**
     *
     * @var CI_Controller
     */
    private $CI;
    
    private $app_key = 'agiU7J0A';
    private $defineType =array(
        1=>"parner",
        2=>"event",
    );
	private $groupmenugc = array(
					1=>array('id'=>1,'name'=>'GiftCode Đối Tác',"type"=>"parner"),
					2=>array('id'=>2,'name'=>'GiftCode Events',"type"=>"event")
					);
    
    public function __construct() {
        $this->CI = & get_instance();
        /*
         * Load default
         */
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');

        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
    }

    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
                
        $this->CI->load->MeAPI_Model('GiftcodeManagerModel');
        $menus = $this->CI->GiftcodeManagerModel->getAllMenuApi();
        $this->data['result'] = $menus;

        $this->CI->template->write_view('content', 'giftcodemanager/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function addmenu(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->CI->load->MeAPI_Model('GiftcodeManagerModel');
        $this->data['display_name'] = '';
        $this->data['relative_url'] = '';
        $this->data['permission'] = 0;
        $this->data['order'] = 0;
        $this->data['menu_group_id'] = 0;

        //get group menu
        $groupmenu = $this->CI->GiftcodeManagerModel->getGroupMenu();
        $this->data['group_menu'] = $groupmenu;
        
        //$subgroupmenu = $this->CI->GiftcodeManagerModel->getSubGroupMenu();
        //$this->data['sub_menu']= json_encode($subgroupmenu);
        if(isset($_GET['id']) && is_numeric($_GET['id'])){
            $menu = $this->CI->GiftcodeManagerModel->getMenu($_GET['id']);
            $this->data['display_name'] = $menu['menu_name'];
            $this->data['menu_group_id'] = $menu['id'];
            $this->data['alias'] = $menu['alias'];
            $this->data['order'] = $menu['order'];
            $this->data['status'] = $menu['status'];
            $this->data['isactive'] = $menu['isactive'];
        }
        
        if ($this->CI->input->post() && count($this->CI->input->post())>=1) {
            //echo '<pre>';
            //print_r($request->input_post());
            //echo '</pre>';);
            if($request->input_post('menu_group_id') > 0 && $request->input_post('display_name') != ''  && is_numeric($request->input_post('order'))){
                $this->CI->GiftcodeManagerModel->saveItem();
                $url = $this->CI->config->base_url('?control=giftcodemanager&func=index');
                //echo("<script> top.location.href='" . $url . "'</script>");
                redirect($url);
                exit;
            }
            
        }
        /*
        $menus = $this->CI->MenuModel->getAllMenuApi();
        if (!empty($menus)) {
            $menu = array();
            foreach ($menus as $m) {
                $menu[$m['groupp']][] = $m;
            }

        }
        $this->data['result'] = $menu;
        */
                
        $this->CI->template->write_view('content', 'giftcodemanager/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());    
    }

    public function importgc(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);

        $this->CI->load->MEAPI_Model('MongoModel');
        $menus = $this->CI->MongoModel->get('menu_game',array());
		
        $this->data['menu_game'] = $menus;
        $this->data['message'] = "";
        if(isset($_POST["Go"]) && "" != $_POST["Go"])
        {	
		//kiem tra type file
			$this->CI->load->library("Quick_CSV_import");
			$csv =  new Quick_CSV_import();
            if(empty($_FILES['file_source']['tmp_name']) || empty($_POST['typeGame']) || empty($_POST['typegiftcode']) ){
                $this->data['message'] = 'Thông tin không hợp lệ..';
                goto result;
            }
			
            $csv->file_name = $_FILES['file_source']['tmp_name'];
            $game = $_POST['typeGame'];
			
			$typeCode = $this->groupmenugc[$_POST['typeParnet']];
            $description = $_POST['description'];
            //start import now
            $result = $csv->get_csv_all_fields();
			$icheck =1;
			$isfound = 0;
            if(count($result)>=1){
                $getheader = $result[0];
                unset($result[0]);

                $idautoincrement = ($this->CI->MongoModel->getid_increment("giftcode", 1,"idx")['idx'] + 1);
				foreach($result as $key=>$value){
                    //check giftcode trung lap tren 1 game khong
                    $arraycheck =array(
                        "giftCode"=>$value[0],
                        "typeCode"=>$typeCode['type'],
                        "game"=>$game,
                        "idTypeGC"=>$_POST['typegiftcode']
                    );
					if($icheck< 5){
						$checkgiftcode = $this->CI->MongoModel->get("giftcode",$arraycheck);
						if(isset($checkgiftcode) && count($checkgiftcode)>=1) {
						   //continue;
						   //if giftcode has exits in data then break import
						   
						   $isfound++;
						   if($isfound >=3){
							goto result;
							break;
						   }
						}
                    }
					$icheck++;
                    $paramsInsert[] = array(
                        "idx" => intval($idautoincrement),
                        "giftCode" => trim($value[0]),
                        "gcorder" => "",
                        "jsonItem" => "",
                        "typeCode" => $typeCode['type'],
                        "game" => $game,
                        "idTypeGC"=>$_POST['typegiftcode'],
                        "actorCreate" => $_SESSION['account']['username'],
                        "actorOrder" => "",
                        "description" => $description,
                        "insertDate" => date('Y-m-d H:i:s',time()),
                        "endDate" => $value[1],
                        "type" => "1");
                    $idautoincrement++;

                }
                if(count($paramsInsert)>=1 && isset($paramsInsert)) {
                    $statusindert = $this->CI->MongoModel->insert_batch("giftcode", $paramsInsert);
                }
				unset($_POST);
                if ($statusindert) {
                    $this->data['message'] = 'Đã duyệt xong..';
                    goto result;
                }
                $this->data['message'] = 'Import thất bại..';
                goto result;
                //ton tai

            }
        }

        result:
		$this->data['group_menu'] = $this->groupmenugc;
        $this->CI->template->write_view('content', 'giftcodemanager/import', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    function typegiftcode(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);

        $this->CI->load->MEAPI_Model('MongoModel');
		
		$menusgame = $this->CI->MongoModel->get('menu_game',array());
        $this->data['menugames'] = $menusgame;
		$getfirrst = $menusgame[0];
		if(empty($_GET['idgame']) === TRUE){
			$wherein[] = strtolower($getfirrst['alias']);
			$this->data['gamefirst'] = $getfirrst['idgame'];
		}else{
			$this->data['gamefirst'] = $_GET['idgame'];
			foreach($menusgame as $val){
				if($val['alias'] == $_GET['idgame']){
					$wherein[] = strtolower($val['alias']);
					break;
				}
			} 
			
		}
		
		
		$this->CI->MongoModel->where_in("game",$wherein);
		
		$menus = $this->CI->MongoModel->get('menu_typegame',array());
		
        $this->data['type_menu'] = $menus;
		
		
		
		$this->CI->template->write_view('content', 'giftcodemanager/typegiftcode', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    function isneed($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && isneed($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }
    public function groupmenu(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);
                
        $this->CI->load->MEAPI_Model('MongoModel');
        $menus = $this->CI->MongoModel->get('menu_game',array());
		

        $this->data['group_menu'] = $menus;

        $this->CI->template->write_view('content', 'giftcodemanager/groupmenu', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function aprovegc(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);

        $this->CI->load->MeAPI_Model('Nutme/NavigatorModel');
        $getgame = $this->CI->NavigatorModel->slbGame();
		$wherein = array();
		foreach($getgame as $v){
			if((@in_array($v['alias'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
				$wherein[] = strtolower($v['alias']);
			}
		}			
		//$getgame = $this->CI->PermissionModel->listPermissionByUser($_SESSION['account']['id']);
		/*$wherein = array();
        if(isset($getgame) && count($getgame)>=1){
            foreach($getgame as $value){
                //$wherein.='"'.strtolower($value['display_name']).'",';
                $wherein[] = strtolower($value['display_name']);
            }
           // $wherein = substr($wherein,0,strlen($wherein)-1);
        }
		print_r($wherein);die;
		*/
        $this->CI->load->MEAPI_Model('MongoModel');
        $whereArray = array();
        $this->CI->MongoModel->order_by(array("isactive"=>1,"idx"=>-1));
		$this->CI->MongoModel->where_in("game",$wherein);
        $ordergc = $this->CI->MongoModel->get('giftcode_order',$whereArray);

        $this->data['listapprove'] = $ordergc;

        $this->CI->template->write_view('content', 'giftcodemanager/approvegc', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function updatestatusgc(){

        //check permission

        if(isset($_POST)){
            //kiem tra luong gc trong kho co' du' de phat hok

            if(isset($_POST['idx']) && is_numeric($_POST['idx']) && $_POST['idx'] >=1){
                $paramsUpdate = array(
                    "isactive"=>"1"
                );
                $whereUpdate = array(
                    "idx"=>intval($_POST['idx'])
                );
                $statusupdate = 0;
                $this->CI->load->MEAPI_Model('MongoModel');
                //getinfo
                $getinfo = $this->CI->MongoModel->get('giftcode_order',$whereUpdate);
				
                /*if(isset($getinfo[0]) && !empty($getinfo[0])) {
                    $statusupdate = $this->CI->MongoModel->update("giftcode_order", $paramsUpdate, $whereUpdate);
                }
                */
                if(isset($getinfo[0]) && !empty($getinfo[0])) {
                    $params = $getinfo[0];
                    //kiem tra la parnet hay cua gen
                    if( $params['typeCode'] != 'parner') {
                        //gencode

                        $quantity = $params['quantity'];
                        $prefix = $params['prefix'];
                        $game = $params['game'];
                        $jsonitem = $params['jsonItem'];
                        $typeCode = $params['typeCode'];
                        $actorOrder = $params['actorOrder'];
                        $actorCreate = $params['actorCreate'];
                        $description = $params['description'];
                        $insertDate = $params['insertDate'];
                        $idtypegc = $params['idTypeGC'];
                        $endDate = $params['endDate'];
						$ismultiple = $params['ismultiple'];
						$maxreceive = (isset($params['maxreceive']) && $params['maxreceive'] > 0)? $params['maxreceive']: 0;
						$server_id = $params['server_id'];
						$forvip = $params['forvip'];
						$forlevel = $params['forlevel'];

                        $idautoincrement = ($this->CI->MongoModel->getid_increment("giftcode", 1,"idx")['idx'] + 1);
						if($ismultiple){
							//jsonItem
								$paramsInsert[] = array(
									"idx" => intval($idautoincrement),
									"giftCode" => $prefix ,
									"gcorder" => $params['idx'],
									"jsonItem" => $jsonitem,
									"typeCode" => $typeCode,
									"idTypeGC" => $idtypegc,
									"game" => $game,
									"actorCreate" => $_SESSION['account']['username'],
									"actorOrder" => $actorOrder,
									"description" => $description,
									"insertDate" => $insertDate,
									"endDate" => $endDate,
									"ismultiple" => $ismultiple,
									"maxreceive" => $maxreceive,
									"isactive" => intval(0),
									"server_id" => $server_id,
									"forlevel" => $forlevel,
									"forvip" => $forvip,
									"type" => "1");
								$idautoincrement++;
						}else{
							for ($i = 1; $i <= $quantity; $i++) {
								$gift = $this->genaral_giftcode(8);


								//jsonItem
								$paramsInsert[] = array(
									"idx" => intval($idautoincrement),
									"giftCode" => $prefix . $gift,
									"gcorder" => $params['idx'],
									"jsonItem" => $jsonitem,
									"typeCode" => $typeCode,
									"idTypeGC" => $idtypegc,
									"game" => $game,
									"actorCreate" => $_SESSION['account']['username'],
									"actorOrder" => $actorOrder,
									"description" => $description,
									"insertDate" => $insertDate,
									"endDate" => $endDate,
									"ismultiple" => $ismultiple,
									"isactive" => intval(0),
									"server_id" => $server_id,
									"forlevel" => $forlevel,
									"forvip" => $forvip,
									"type" => "1");
								$idautoincrement++;
							}
						}
                        
                        $statusupdate = $this->CI->MongoModel->update("giftcode_order", $paramsUpdate, $whereUpdate);
                        if($statusupdate) {
                            $statusindert = $this->CI->MongoModel->insert_batch("giftcode", $paramsInsert);
                        }
                        if ($statusindert) {

                            echo json_encode(array("code" => 0, 'message' => 'Đã duyệt xong..'));
                            die;
                        }
                        echo json_encode(array("code" => -102, 'message' => 'Cập nhật thất bại [2].Liên hệ TECH để giải quyết'));
                        die;
                    }else{
                        //$statusupdate = $this->CI->MongoModel->update("giftcode_order", $paramsUpdate, $whereUpdate);

                        $whereCheck = array("game"=>$params['game'],"typeCode"=>"parner","idTypeGC"=>$params['idTypeGC'],"gcorder" =>'',
                                "actorOrder"=>'');
                        $checkluonggc = $this->CI->MongoModel->get('giftcode',$whereCheck,$params['quantity']);

                        if(isset($checkluonggc) && count($checkluonggc)>=1 ) {

                            if($params['quantity'] > count($checkluonggc)){
                                echo json_encode(array("code" => -103, 'message' => 'Lượng Giftcode không đủ,Vui lòng liên hệ TECH...'));
                                die;
                            }

                            $statusupdate = $this->CI->MongoModel->update("giftcode_order", $paramsUpdate, $whereUpdate);
                            if(!$statusupdate){
                                echo json_encode(array("code" => -103, 'message' => 'Phê duyệt thất bại....'));
                                die;
                            }
                            //ton tai luong gc trong khi
                            //tien hanh trich va phat cho gamer

                            //update kho giftcode voi nguoi duyet
                            foreach($checkluonggc as $key=>$value){
                                $paramsUpdate = array(
                                    "actorOrder"=>$params['actorOrder'],
                                    "gcorder"=>$params["idx"],
                                    "jsonItem"=>$params["jsonItem"]
                                );
                                $whereUpdate = array(
                                    "typeCode"=>"parner",
                                    "game"=>$params['game'],
                                    "idTypeGC"=>$params["idTypeGC"],
                                    "idx"=>intval($value['idx']),
                                    "gcorder" =>'',
                                    "actorOrder"=>''
                                );
                                $statusupdate_v2 = 0;
                                $statusupdate_v2 = $this->CI->MongoModel->update("giftcode", $paramsUpdate, $whereUpdate);
                            }

                            if ($statusupdate_v2) {
                                echo json_encode(array("code" => 0, 'message' => 'Đã duyệt xong..'));
                                die;
                            }else{
                                echo json_encode(array("code" => -102, 'message' => 'Cập nhật thất bại [3].Liên hệ TECH để giải quyết'));
                                die;
                            }

                        }else{
                            //neu khong co luong gc trong khi ?
                            //kiem tra game nay` co support api hok
                            $game = $params['game'];
                            $whereGame = array("alias"=>$game);
                            $checkapi = $this->CI->MongoModel->get('menu_game',$whereGame);
                            $getapi = "";
                            if(isset($checkapi[0]) && !empty($checkapi[0])) {
                                $getapi = $checkapi[0]['apilink'];
                            }
                            if(!empty($getapi) && !preg_match("/^(http|ftp):/", $getapi) ){

                                //check co import dc hok..neu import dc thi tien hanh` update
                                $statusupdate = $this->CI->MongoModel->update("giftcode_order", $paramsUpdate, $whereUpdate);

                                echo json_encode(array("code" => -102,'message'=>'Dạng code call api'));
                                die;
                            }else{
                                echo json_encode(array("code" => -102,'message'=>'Không có hỗ trợ giftcode cho game này'));
                                die;
                                //link khong hợp lệ
                            }

                        }
                        //kiem tra giftcode co trong kho khong
                        //neu khong co trong kho loai gc nay`
                        // kiem tra co api call hok//
                        //neu khong co api thi bao hok support
                        //call api doi tac de gencode
                        echo json_encode(array("code" => -102,'message'=>'Call API Đối Tác'));
                        die;
                    }
                }else{
                    echo json_encode(array("code" => -102,'message'=>'Cập nhật thất bại [1].Liên hệ TECH để giải quyết'));
                    die;
                }

            }
        }

        echo json_encode(array("code" => -100,'message'=>'Thông tin không hợp lệ'));
        die;
    }
    public function taigc(MeAPI_RequestInterface $request){
		$this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);
		if(isset($_POST)){
            if(isset($_POST['idx']) && is_numeric($_POST['idx']) && $_POST['idx'] >=1){
                $whereUpdate = array(
                    "idx"=>intval($_POST['idx'])
                );
                $statusupdate = 0;
                $this->CI->load->MEAPI_Model('MongoModel');
                //getinfo
                $getinfo = $this->CI->MongoModel->get('giftcode_order',$whereUpdate);
				
                if(isset($getinfo[0]) && !empty($getinfo[0])) {
                    //get info giftcode
                    $params = $getinfo[0];
                    $whereGet = array(
                        "gcorder"=>$params['idx'],
                        "game"=>$params['game'],
                        "typeCode"=>$params['typeCode'],
                        "idTypeGC"=>$params['idTypeGC']
                    );
                    //tai qua 3 lan hok cho tai nua
                    $getlistgc = $this->CI->MongoModel->get('giftcode',$whereGet);
					
                    if(isset($getlistgc) && count($getlistgc) >=1 ) {
                        $html = "";

                            $html.='<table id="rstable">';
                            $html.='<tr>';
                            $html.='<th>giftCode</th>';
							/*
                            $html.='<th>jsonItem</th>';
                            $html.='<th>typeCode</th>';
                            $html.='<th>typeGiftCode</th>';
                            $html.='<th>game</th>';
                            $html.='<th>actorOrder</th>';
                            $html.='<th>actorCreate</th>';
                            $html.='<th>description</th>';
                            $html.='<th>insertDate</th>';
                            $html.='<th>endDate</th>';
							*/
                            $html.='</tr>';
                        foreach($getlistgc as $key=>$value){
                                $html.='<tr>';
                                $html.='<td>'.$value['giftCode'].'</td>';
								/*
                                $html.='<td>'.$value['jsonItem'].'</td>';
                                $html.='<td>'.$value['typeCode'].'</td>';
                                $html.='<td>'.$value['idTypeGC'].'</td>';
                                $html.='<td>'.$value['game'].'</td>';
                                $html.='<td>'.$value['actorOrder'].'</td>';
                                $html.='<td>'.$value['actorCreate'].'</td>';
                                $html.='<td>'.$value['description'].'</td>';
                                $html.='<td>'.$value['insertDate'].'</td>';
                                $html.='<td>'.$value['endDate'].'</td>';
								*/
                                $html.='</tr>';

                        }
                        $html.="</table>";
                        echo json_encode(array("code" => 0,'message'=>'GET INFO SUCCESS',"data"=>$html));
                        die;
                    }
                    echo json_encode(array("code" => -100,'message'=>'KHÔNG CÓ GIFTCODE TRONG KHO'));
                    die;
                }else{
                    echo json_encode(array("code" => -102,'message'=>'Cập nhật thất bại [1].Liên hệ TECH để giải quyết'));
                    die;
                }

            }
        }

        echo json_encode(array("code" => -100,'message'=>'Thông tin không hợp lệ'));
        die;
    }
    public function ajaxloadgame(){
        if(isset($_POST)) {
            if (isset($_POST['idgame']) && !empty($_POST['idgame']) && $_POST['idgame'] !== 0) {
                $whereUpdate = array(
                    "game" => $_POST['idgame']
                );
                $statusupdate = 0;
                $this->CI->load->MEAPI_Model('MongoModel');
                //getinfo
                $getinfo = $this->CI->MongoModel->get('menu_typegame', $whereUpdate);

                echo json_encode(array("code" => 0,'message'=>'GET INFO SUCCESS','data'=>$getinfo));
                die;


            }else{
                echo json_encode(array("code" => -100,'message'=>'Thông tin không hợp lệ[1]'));
                die;
            }
        }
        echo json_encode(array("code" => -100,'message'=>'Thông tin không hợp lệ[2]'));
        die;
    }
	
	public function loadgiftcode(){
        if(isset($_POST)) {
            $html = "";
			if (isset($_POST['idgame'],$_POST['typegiftcode']) && !empty($_POST['typegiftcode']) && !empty($_POST['idgame']) && $_POST['idgame'] !== 0) {
                $whereUpdate = array(
                    "game" => $_POST['idgame'],
					"idTypeGC" => $_POST['typegiftcode']
                );
                $statusupdate = 0;
                $this->CI->load->MEAPI_Model('MongoModel');
                //getinfo
                $getinfo = $this->CI->MongoModel->get('giftcode', $whereUpdate);
				foreach($getinfo as $key=>$value){
					$html.="<tr>";
					$html.="<td>".$value['giftCode']."</td>";
					$html.="<td>".$value['game']."</td>";
					$html.="<td>".$value['server_id']."</td>";
					$html.="<td>".$value['description']."</td>";
					
					$html.="<td>".$value['typeCode']."</td>";
					
					$html.="<td>".$value['actorCreate']."</td>";
					$html.="<td>".(($value['isactive'])?"Đã kích hoạt":"Chưa kích hoạt")."</td>";
					$html.="<td>".$value['insertDate']."</td>";
					$html.="<td>".$value['gcorder']."</td>";
					$html.="</tr>";
				}
				
                echo json_encode(array("code" => 0,'message'=>'GET INFO SUCCESS','data'=>$html));
                die;


            }else{
                echo json_encode(array("code" => -100,'message'=>'Thông tin không hợp lệ[1]'));
                die;
            }
        }
        echo json_encode(array("code" => -100,'message'=>'Thông tin không hợp lệ[2]'));
        die;
    }
    public function ordergc(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);
        

        $this->CI->load->MEAPI_Model('MongoModel');

        if(isset($_POST)) {
            if (isset($_POST['typeParnet'], $_POST['typeGame'],$_POST['typegiftcode']) && is_numeric($_POST['typegiftcode'])  && is_numeric($_POST['typeParnet']) && $_POST['typeGame']) {
                //load typeCode game
                $_SESSION['infogen']['typeParnet'] = is_numeric($_POST['typeParnet']) ? $_POST['typeParnet'] : 1;
                //load group menu typeGame
                $_SESSION['infogen']['typeGame'] = $_POST['typeGame'];
                //load html json game
                $arrayfind = array("typeCode" => $this->defineType[$_SESSION['infogen']['typeParnet']], "game" => $_SESSION['infogen']['typeGame']);

                //$typeCode = $this->CI->MongoModel->get('giftcode', $arrayfind);
                $idtypegame = $_POST['typegiftcode'];
                $quantity = $_POST['quantity'];
                $prefix = $_POST['prefix'];
				$maxreceive = $_POST['maxreceive'];
                $description = $_POST['description'];
				
				$forvip = (empty($_POST['forvip']) || $_POST['forvip'] == 0)? "" :$_POST['forvip'];
                $forlevel = (empty($_POST['forlevel']) || $_POST['forlevel'] == 0)?"":$_POST['forlevel']; 
				
				$server_id = $_POST['server_id'];
				$ismultiple = $_POST['ismultiple'];
                $paramsInsert = array();
                if (isset($quantity) &&  is_numeric($_POST['quantity'])   ) {
                    //process gengc or

                    $idautoincrement = ($this->CI->MongoModel->getid_increment("giftcode_order",1,"idx")['idx'] + 1);
                    $strdate = str_replace("+"," ",str_replace("/"," ", str_replace("/","-",$_POST['endDate']) ) ) ;
                    $strtotime = date('Y-m-d H:i:s',strtotime($strdate) );
                    $jsonItem = "";
                    $itemjson = array();
                    for ($j = 1; $j <= 10; $j++) {
                        if (!empty($_POST['item_name' . $j]) && is_numeric($_POST['item_count' . $j])) {
                            $itemjson[] = array(
                                "item_id" => $_POST['item_id' . $j],
                                "item_name" => $_POST['item_name' . $j],
                                "count" => $_POST['item_count' . $j],
								"type" => $_POST['item_type' . $j]);
                            $jsonItem = json_encode($itemjson);
                        } else {
                            break;
                            $j = 11;
                            die;
                        }

                    }
                    //jsonItem
                    $paramsInsert = array(
                        "idx"=>intval($idautoincrement),
                        "jsonItem" => $jsonItem,
                        "quantity"=>$quantity,
                        "prefix"=>$prefix,
                        "typeCode"=>$this->defineType[$_SESSION['infogen']['typeParnet']],
                        "game"=>$_SESSION['infogen']['typeGame'],
                        "idTypeGC"=>$idtypegame,
                        "actorCreate"=> "",
                        "actorOrder"=>$_POST['actorOrder'],
                        "description" => $description,
                        "insertDate"=>date('Y-m-d H:i:s',time()),
                        "endDate"=>$strtotime,
						"ismultiple"=>$ismultiple,
						"maxreceive"=>$maxreceive,
						"forlevel"=>$forlevel,
						"forvip"=>$forvip,
						"server_id"=>$server_id,
                        "isactive"=>"0"
                    );
                    $statusupdate = $this->CI->MongoModel->insert("giftcode_order",$paramsInsert);
                    if($statusupdate){
                        echo json_encode(array("code" => 0,'message'=>'Đang chờ sếp duyệt..Vui lòng qua liên lạc để được support nhanh nhất'));
                        die;
                    }
                    echo json_encode(array("code" => -100,'message'=>'Không thể Order Giftcode .Liên hệ phía TECH để support.!'));
                    die;
                } else {
                    //thieu params
                    echo json_encode(array('code' => -100,'message'=>'Thông tin không hợp lệ[1]'));
                    die;
                }
            }
        }

        $this->CI->load->MeAPI_Model('SocialmeModel');
		$getgame = $this->CI->SocialmeModel->getnavigatorall();
			
		$wherein = array();
        if(isset($getgame) && count($getgame)>=1){
            foreach($getgame as $value){
				if((@in_array($value['alias'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                //$wherein.='"'.strtolower($value['display_name']).'",';
					$wherein[] = strtolower($value['alias']);
				}
            }
            // $wherein = substr($wherein,0,strlen($wherein)-1);
        }

        $this->CI->MongoModel->where_in("alias",$wherein);

        $this->data['menu_game'] = $this->CI->MongoModel->get('menu_game',array());

        $this->data['group_menu'] = $this->groupmenugc;
        $this->CI->template->write_view('content', 'giftcodemanager/ordergc', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    private function genaral_giftcode($maxlengh) {
            $validCharacters = "abcde2fgh6ijklmnopqrs3tuxy8vwzABCDEF4GH9IJKLM5NOPQRSTU7XYVWZ1";
            $validCharNumber = strlen($validCharacters);

            $result = "";

            for ($i = 0; $i < $maxlengh; $i++) {
                $index = mt_rand(0, $validCharNumber - 1);
                $result .= $validCharacters[$index];

            }
            return strtoupper($result);
    }
    public function checkgc(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);

        $this->CI->load->MEAPI_Model('MongoModel');

        if($_POST) {
            if (isset($_POST['giftcode'], $_POST['typeGame']) ) {

                $game = $_POST['typeGame'];
                $giftCode = $_POST['giftcode'];
                //kiem tra trong kho da co giftcode nay khong;
                $whereGameGC = array("giftCode" => $giftCode,"game"=>$game);
                $checkstore = $this->CI->MongoModel->get('giftcode', $whereGameGC);
                if (isset($checkstore[0]) && !empty($checkstore[0])) {
                    //giftcode co ton tai trong kho
                    //kiem tra trong log co gamer nao xai chua
                    $whereCheckStore = array("giftCode"=>$giftCode,"game"=>$game);
                    $isexitsstrone = $this->CI->MongoModel->get('giftcode_log', $whereCheckStore);

                    if (isset($isexitsstrone[0]) && !empty($isexitsstrone[0])) {
                        //co gamer da xai
                        $this->data['data'] = $isexitsstrone[0];
                        goto result;
                    }else{
                        //khong co trong kho// tien hanh nhay qua call api
                        $whereGame = array("alias" => $game);
                        $checkapi = $this->CI->MongoModel->get('menu_game', $whereGame);
                        $getapi = "";
                        if (isset($checkapi[0]) && !empty($checkapi[0])) {
                            $getapi = $checkapi[0]['apilink'];
                        }
                        if (!empty($getapi) && !preg_match("/^(http|ftp):/", $getapi)) {

                            //check co import dc hok..neu import dc thi tien hanh` update
                            //$statusupdate = $this->CI->MongoModel->update("giftcode_order", $paramsUpdate, $whereUpdate);

                            // call qua doi tac check in

                            //va insert vao db truong hop thong tin gc nay
                            //jsonItem
                            $arrayapi = array();
                            $paramscheck = $checkstore[0];
                            $idautoincrement = ($this->CI->MongoModel->getid_increment("giftcode_log",1,"idx")['idx'] + 1);
                            $paramsInsert = array(
                                "idx"=>intval($idautoincrement),
                                "giftCode" => $giftCode,
                                "moboID"=> $arrayapi['mobo_id'],
                                "moboServiceId"=>$arrayapi['mobo_service_id'],
                                "serverID"=>$arrayapi['server_id'],
                                "type"=> "1",
                                "jsonItem"=>$paramscheck['jsonItem'],
                                "ipAddress"=> "192.168.1.2",
                                "insertDate"=> date('Y-m-d H:i:s',time()),
                                "game"=>$game,
                                "typeCode"=> $paramscheck['typeCode'],
                                "actorCreate"=>$paramscheck['actorCreate'],
                                "actorOrder"=>$paramscheck['actorOrder']
                            );
                            $statusinsert = $this->CI->MongoModel->insert("giftcode_log",$paramsInsert);



                            $this->data['message'] = 'Dạng code call api';
                            goto result;
                        } else {
                            $this->data['message'] = 'Không có hỗ trợ giftcode cho game này';
                            goto result;
                            //link khong hợp lệ
                        }
                    }

                }else{
                    $this->data['message'] = 'GIFTCODE này không tồn tại trong hệ thống';
                    goto result;
                }

            }else{
                $this->data['message'] = "Thông tin không hợp lệ";
                goto result;
            }
        }

        result:
        //$this->CI->load->MeAPI_Model('MenuModel');
		//$getgame = $this->CI->MongoModel->get('menu_game',array());
        //$getgame = $this->CI->MenuModel->getMenuApi($_SESSION['account']['id'],3);
		$this->CI->load->MeAPI_Model('SocialmeModel');
		$getgame = $this->CI->SocialmeModel->getnavigatorall();
			
		$wherein = array();
        if(isset($getgame) && count($getgame)>=1){
            foreach($getgame as $value){
				if((@in_array($value['alias'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                //$wherein.='"'.strtolower($value['display_name']).'",';
					$wherein[] = strtolower($value['alias']);
				}
            }
            // $wherein = substr($wherein,0,strlen($wherein)-1);
        }
        $this->CI->MongoModel->where_in("alias",$wherein);

        $this->data['menu_game'] = $this->CI->MongoModel->get('menu_game',array());
		

        $this->CI->template->write_view('content', 'giftcodemanager/checkgc', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());

    }

    public function addgroupmenu(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeMenu($request);
        $this->authorize->validateAuthorizeRequest($request, 0);
                
        $this->CI->load->MEAPI_Model('MongoModel');
        $this->data['display_name'] = '';
        $this->data['order'] = 0;
        $this->data['group_id'] = 0;
        $this->data['isactive'] = 1;
        
        
        if(isset($_GET['id']) && is_numeric($_GET['id'])){
            $menus = $this->CI->MongoModel->get('menu_game',array('id'=>$_GET['id']));
            if(isset($menus[0]) && !empty($menus)) {
                $menug = $menus[0];
                $this->data['display_name'] = $menug['display_name'];
                $this->data['order'] = $menug['order'];
                $this->data['group_id'] = $menug['id'];
                $this->data['alias'] = $menug['alias'];
                $this->data['apilink'] = $menug['apilink'];
                $this->data['apicheck'] = $menug['apicheck'];
            }
        }
        
        if ($this->CI->input->post()) {
            if($request->input_post('display_name') != '' && is_numeric($request->input_post('order'))){
                $arrParam = $this->CI->input->post();
                if(isset($arrParam['groupId'])){
                    $paramsUpdate = array(
                        "display_name"=>trim($arrParam['display_name']),
                        "alias"=> trim($arrParam['alias']),
                        "apilink"=> trim($arrParam['apilink']),
                        "apicheck"=> trim($arrParam['apicheck']),
                        "order"=> trim($arrParam['order'])
                    );
                    $whereUpdate = array(
                        "id"=>$arrParam['groupId']
                    );
                    $this->CI->MongoModel->update("menu_game",$paramsUpdate,$whereUpdate);

                }else{
                    $idautoincrement = ($this->CI->MongoModel->getid_increment("menu_game",1)['id'] + 1);
                    $paramsInsert= array(
                        "id"=>intval($idautoincrement),
                        "display_name"=>trim($arrParam['display_name']),
                        "alias"=>$arrParam['alias'],
                        "apilink"=> trim($arrParam['apilink']),
                        "apicheck"=> trim($arrParam['apicheck']),
                        "order"=> $arrParam['order'],
                        "create_date"=>date('Y-m-d H:i:s',time()),
                        "isactive"=>"1"
                    );
                    $this->CI->MongoModel->insert("menu_game",$paramsInsert);
                }

                $url = $this->CI->config->base_url('?control=giftcodemanager&func=groupmenu');
                redirect($url);
                exit;
            }
            
        }
           
        $this->CI->template->write_view('content', 'giftcodemanager/addgroupmenu', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());    
    }

    public function addtypegiftcode(MeAPI_RequestInterface $request){

        $this->authorize->validateAuthorizeRequest($request, 0);

        $this->CI->load->MEAPI_Model('MongoModel');
        $this->data['display_name'] = '';
        $this->data['order'] = 0;
        $this->data['group_id'] = 0;
        $this->data['isactive'] = 1;
        $this->data['error'] = "";
        $listgame = $this->CI->MongoModel->get('menu_game',array());
        $this->data['listgame'] = $listgame;
        if(isset($_GET['id']) && is_numeric($_GET['id'])){

            $menus = $this->CI->MongoModel->get('menu_typegame',array('idx'=>intval($_GET['id'])));
            if(isset($menus[0]) && !empty($menus)) {
                $menug = $menus[0];
                $this->data['display_name'] = $menug['display_name'];
                $this->data['order'] = $menug['order'];
                $this->data['idx'] = $menug['idx'];
                $this->data['alias'] = $menug['alias'];
                $this->data['game'] = $menug['game'];
				$this->data['eventname'] = $menug['eventname'];
            }

        }

        if ($this->CI->input->post()) {
            if($request->input_post('display_name') != '' && is_numeric($request->input_post('order'))){
                $this->CI->load->library("Info");
                $info = new Info();
                $arrParam = $this->CI->input->post();
                if($arrParam['game'] === 0){
                    $this->data['error'] = "Chưa chọn game";
                    goto result;
                }
                if(isset($arrParam['groupId'])){
                    $paramsUpdate = array(
                        "display_name"=>trim($arrParam['display_name']),
                        "alias"=> $info->changeTitle(trim($arrParam['display_name'])),
                        "isactive"=>trim($arrParam['chk_status']),
                        "game"=>trim($arrParam['game']),
						"eventname"=>trim($arrParam['eventname']),
                        "order"=> trim($arrParam['order'])
                    );
                    $whereUpdate = array(
                        "idx"=>intval($arrParam['groupId'])
                    );
                    $this->CI->MongoModel->update("menu_typegame",$paramsUpdate,$whereUpdate);

                }else{
                    $idautoincrement = ($this->CI->MongoModel->getid_increment("menu_typegame",1,"idx")['idx'] + 1);
                    $paramsInsert= array(
                        "idx"=>intval($idautoincrement),
                        "display_name"=>trim($arrParam['display_name']),
                        "alias"=>$info->changeTitle(trim($arrParam['display_name'])),
                        "isactive"=>trim($arrParam['chk_status']),
                        "game"=>trim($arrParam['game']),
						"eventname"=>trim($arrParam['eventname']),
                        "order"=> $arrParam['order']
                    );
                    $this->CI->MongoModel->insert("menu_typegame",$paramsInsert);
                }

                $url = $this->CI->config->base_url('?control=giftcodemanager&func=typegiftcode');
                redirect($url);
                exit;
            }

        }
        result:
        $this->CI->template->write_view('content', 'giftcodemanager/addtypegiftcode', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getResponse() {
        return $this->_response;
    }
	public function isneedSub($array,$need){
		foreach($need as $key=>$val){
            if(!isset($array[$val])){
                return false;
            }
        }
        return true;
    }
	public function parseGame($typeGame,$game){
		$this->CI->load->MEAPI_Model('MongoModel');
		$this->CI->MongoModel->where(array("game"=>$game));
		$this->CI->MongoModel->where(array("alias"=>$typeGame));
		
        $listgame = $this->CI->MongoModel->get('menu_typegame',array());
		if($listgame){
			return $listgame[0]['idx'];
		}
		return null;
	}
	private $tokenside = "7fe109s62d15c61g1f937deae1dc3d";
	public function getlistevent(MeAPI_RequestInterface $request){
		$params  = $request->input_request();
		if(empty($request) === TRUE){
			return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
		}
		$isneed = array("game","event");
		//isneedSub
		if(!$this->isneedSub($params,$isneed)){
            return $this->_response = new MeAPI_Response_APIResponse($request, 'FALIED');
        }
		unset($params['control']);
		unset($params['func']);
		$token = trim($params['token']);
        unset($params['token']);
        $valid = md5(implode('', $params) . $this->tokenside);
        if ($valid != $token) {
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
            die;
        }
		$this->CI->load->MEAPI_Model('MongoModel');
		//typecode : parner or event
		//&& intval($params['quanlity']) < 10
		$event = $params['event'];
		$this->CI->MongoModel->where(array("game"=>$params['game']));
		$this->CI->MongoModel->where(array("isactive"=>"1"));
		$this->CI->MongoModel->where(array("eventname"=>$event));
		$listgame = $this->CI->MongoModel->get('menu_typegame',array());
		
		if(empty($listgame)=== FALSE){
			return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS' , $listgame);
		}
		
		return $this->_response = new MeAPI_Response_APIResponse($request, 'FALIED');
	}
	public function testabl(){
		$this->CI->load->MEAPI_Model('MongoModel');
		echo "<pre>";
		$idx = $this->CI->MongoModel->getid_incrementtest("giftcode_log",10,"insertDate") ;
		print_r($idx);die;
				$idautoincrement = intval($idx)+ 1;
				
	}
	public function getgiftcodebygame(MeAPI_RequestInterface $request){
		$params  = $request->input_request();
		
		if(empty($request) === TRUE){
			return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
		}
		unset($params['control']);
		unset($params['func']);
		$token = trim($params['token']);
        unset($params['token']);
        $valid = md5(implode('', $params) . $this->tokenside);
        if ($valid != $token) {
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
            die;
        }
		
		
		$isneed = array("typecode","typegame","game","event");
		//isneedSub
		if(!$this->isneedSub($params,$isneed)){
            return $this->_response = new MeAPI_Response_APIResponse($request, 'FALIED');
        }
		
		
		$this->CI->load->MEAPI_Model('MongoModel');
		//typecode : parner or event
		//&& intval($params['quanlity']) < 10
		$quantity = (isset($params['quanlity']) )? $params['quanlity']:1;
		$actorOrder = $params['event'];
		$getgiftcode = $params['typegame'];
		//		$this->parseGame($params['typegame'],$params['game']);
		$this->CI->MongoModel->where(array("game"=>$params['game']));
		$this->CI->MongoModel->where(array("gcorder"=>"" ) );
		//$this->CI->MongoModel->where(array("actorOrder"=>array('$ne'=>"") ) );
		
		//$this->CI->MongoModel->where(array("actorOrder"=>"") );
		$this->CI->MongoModel->where(array("typeCode"=>$params['typecode']));
		$this->CI->MongoModel->where(array("idTypeGC"=>$getgiftcode));
		$listgame = $this->CI->MongoModel->get('giftcode',array(),$quantity);
		
		if(empty($listgame)=== FALSE){
			$paramsUpdate = array(
				"isactive"=>"1",
				"gcorder"=>$actorOrder,
				"dateCreate"=>date('Y-m-d H:i:s',time())
			);
			$whereUpdate = array(
				"giftCode"=>$listgame[0]['giftCode'],
				"game"=>$params['game'],
				"typeCode"=>$params['typecode'],
				"idTypeGC"=>$getgiftcode
			);
			$statusupdate = $this->CI->MongoModel->update("giftcode", $paramsUpdate, $whereUpdate);
			
			if($statusupdate){
				//insert log
				
				$idx = $this->CI->MongoModel->getid_increment("giftcode_log",1,"idx")['idx'] ;
				$idautoincrement = intval($idx)+ 1;
				$ip =$this->get_remote_ip();
                $paramsInsert = array(
                    "idx"=>intval($idautoincrement),
                    "giftCode" => $listgame[0]['giftCode'],
                    "moboID"=> "",
                    "moboServiceId"=>"",
                    "serverID"=>"",
                    "type"=> "1",
                    "jsonItem"=>"",
                    "ipAddress"=> "$ip",
                    "insertDate"=> date('Y-m-d H:i:s',time()),
                    "game"=>$params['game'],
					"idTypeGC"=>$getgiftcode,
                    "typeCode"=> $params['typecode'],
                    "actorCreate"=>$listgame[0]['actorCreate'],
                    "actorOrder"=>$actorOrder,
                );
                $statusinsert = $this->CI->MongoModel->insert("giftcode_log",$paramsInsert);
				if($statusinsert){
					return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS' , $listgame[0]);
				}
				
			}
			return $this->_response = new MeAPI_Response_APIResponse($request, 'EXIXTS');
		}
		
		return $this->_response = new MeAPI_Response_APIResponse($request, 'FALIED');
	}
	function get_remote_ip() {
        $ipaddress = '';
        if ($_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if($_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if($_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if($_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
	public function checkgiftcode(MeAPI_RequestInterface $request)
	{
		$params  = $request->input_request();
		if(empty($request) === TRUE){
			return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_PARAMS');
		}
		unset($params['control']);
		unset($params['func']);
		$token = trim($params['token']);
        unset($params['token']);
        $valid = md5(implode('', $params) . $this->tokenside);
		if ($valid != $token) {
            return $this->_response = new MeAPI_Response_APIResponse($request, 'INVALID_TOKEN');
            die;
        }
		
		
		$isneed = array("typecode","game","event","giftcode","server_id");
		//isneedSub
		if(!$this->isneedSub($params,$isneed)){
            return $this->_response = new MeAPI_Response_APIResponse($request, 'FALIED');
        }
		$this->CI->load->MEAPI_Model('MongoModel');
		//typecode : parner or event
		//&& intval($params['quanlity']) < 10
		$appevent = $params['event'];
		$game = $params['game'];
		$gettypecode = $params['typecode'];
		//$gettypegame = $params['typegame'];
		$getgiftcode = $params['giftcode'];
		$getserverid = $params['server_id'];
		
		$arraycheck =array(
           "giftCode"=>$getgiftcode,
            "typeCode"=>$gettypecode,
            "game"=>$game,
        );
		if(empty($gettypegame) === FALSE){
			$arraycheck['idTypeGC'] = $params['typegame'];
		}
		//"server_id"=> array('$regex'=>new MongoRegex("/$getserverid/i"))
        $checkgiftcode = $this->CI->MongoModel->get("giftcode",$arraycheck);
		if(empty($checkgiftcode)=== FALSE){
			if(!empty($checkgiftcode[0]['server_id']) ){
                //parse server
		        $server_id = explode(",",$checkgiftcode[0]['server_id']);
                if(!in_array($getserverid,$server_id) || empty($server_id) == TRUE ){
                    return $this->_response = new MeAPI_Response_APIResponse($request, 'FALIED');
                }
				

            }
			if(!empty($checkgiftcode[0]["insertDate"]) && !empty($checkgiftcode[0]["endDate"])){
				$datetime = date('Y-m-d H:i:s',time());
				if($datetime < $checkgiftcode[0]["insertDate"] || $datetime >$checkgiftcode[0]["endDate"] ){
					return $this->_response = new MeAPI_Response_APIResponse($request, 'FALIED');
				}
			}
			$paramsUpdate = array(
				"isactive"=>"1",
				"gcorder"=>$appevent,
				"dateCreate"=>date('Y-m-d H:i:s',time())
			);
			$statusupdate = $this->CI->MongoModel->update("giftcode", $paramsUpdate, $arraycheck);
			return $this->_response = new MeAPI_Response_APIResponse($request, 'SUCCESS' , $checkgiftcode[0]);
		}
		return $this->_response = new MeAPI_Response_APIResponse($request, 'FALIED');
	}
	public function testupdate(){
		$this->CI->load->MEAPI_Model('MongoModel');
		$listgame = $this->CI->MongoModel->get('giftcode',array());
		
		foreach($listgame as $key=>$val){
			$whereUpdate = array(
                    "idx"=>intval($val['idx'])
            );
			$paramsUpdate = array( "idx"=> intval($val['idx']) );
            $this->CI->MongoModel->update("giftcode",$paramsUpdate,$whereUpdate);
		}
	}
	public function historygc(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
                
        $this->CI->load->MeAPI_Model('GiftcodeManagerModel');
		$this->CI->load->MEAPI_Model('MongoModel');
		
		$this->CI->load->MeAPI_Model('SocialmeModel');
		$getgame = $this->CI->SocialmeModel->getnavigatorall();
			
		$wherein = array();
        if(isset($getgame) && count($getgame)>=1){
            foreach($getgame as $value){
				if((@in_array($value['alias'], $_SESSION['permission']) && $_SESSION['account']['id_group']==2)|| $_SESSION['account']['id_group']==1){
                //$wherein.='"'.strtolower($value['display_name']).'",';
					$wherein[] = strtolower($value['alias']);
				}
            }
            // $wherein = substr($wherein,0,strlen($wherein)-1);
        }
        $this->CI->MongoModel->where_in("alias",$wherein);

        $this->data['menu_game'] = $this->CI->MongoModel->get('menu_game',array());
		
		

        $this->CI->template->write_view('content', 'giftcodemanager/historygc', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
}