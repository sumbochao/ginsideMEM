<?php
//1031504929525518311 | mobo id : 128147013
class MeAPI_Controller_Game_Reports_SearchInfoController implements MeAPI_Controller_Game_Reports_SearchInfoInterface {
    protected $_response;
    private $CI;
    public function __construct() {   
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->MeAPI_Library('GameAPI');
        $this->CI->load->MeAPI_Library('GeneralOTPCode');
        $this->CI->load->MeAPI_Library('InfoMobo');
        $this->CI->load->MeAPI_Model('SearchInfoModel');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
    }
    public function mappingServer($listServer){
        //array_shift($listServer);array_shift($listServer);
        //array_shift($listServer);
        //array_shift($listServer);array_shift($listServer);array_shift($listServer);
        //array_shift($listServer);array_shift($listServer);array_shift($listServer);
        //array_shift($listServer);
        krsort($listServer);
        /*$listServer[11] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [12]');
        $listServer[12] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [13]');
        $listServer[13] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [14]');
        $listServer[14] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [15]');
        $listServer[15] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [16]');
        $listServer[16] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [17]');
        $listServer[17] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [18]');
        $listServer[18] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [19]');
        $listServer[19] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [20]');
        $listServer[20] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [21]');
        $listServer[21] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [22]');
        $listServer[22] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [23]');
        $listServer[23] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [24]');
        $listServer[24] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [25]');
        $listServer[25] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [26]');
        $listServer[26] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [27]');
        $listServer[27] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [28]');
        $listServer[28] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [29]');
        $listServer[29] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [30]');
        $listServer[30] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [31]');
        $listServer[31] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [32]');
        $listServer[32] = array('id'=>38,'server_id'=>'500400013','server_name'=>'Hinato [33]');*/
        $endkey = count($listServer);
        $listServer = array_chunk($listServer, 10);
        $i=0;$j=0;
        foreach($listServer as $table){
            $i++;
            foreach($table as $v){
                $j++;
                $numtable = count($table);
                if($numtable==10){
                    if($i==1){
                        $key = $i.'-'.count($table)*$i;
                        $name = $i.' - '.count($table)*$i;
                    }else{
                        $key = (count($table)*$i-9).'-'.count($table)*$i;
                        $name = (count($table)*$i-9).' - '.count($table)*$i;
                    }
                }else{
                    if($numtable==1){
                        $key = $j;
                        $name = $j;
                    }else{
                        if($i==1){
                            $key = $i.'-'.$endkey;
                            $name = $i.' - '.$endkey;
                        }else{
                            $key = ((10*$i)-9).'-'.$endkey;
                            $name = ((10*$i)-9).' - '.$endkey;
                        }
                    }
                }
                $arrServer[$key]['title'] = $name;
                $arrServer[$key]['data'][$j] = $v;
            }
        }
        
        return $arrServer;
    }
    public function index(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        $slbGame = $this->CI->SearchInfoModel->listGame();
        $this->data['slbGame'] = $slbGame;
        if(count($_POST)>0){
            $listServer = $this->CI->SearchInfoModel->listServerByGame($_POST['game_id']);
            $mappingserver = $this->data['mappingserver'] = $this->mappingServer($listServer);
            $this->data['listServer'] = $listServer;
            $arrFilter = array(
                'group' => $_POST['group'],
                'game_id' => $_POST['game_id'],
                'keyword' => $_POST['keyword'],
                'content_server' => $_POST['content_server'],
                'groupserver' => $_POST['groupserver'],
            );
            $this->data['arrFilter'] = $arrFilter;
            preg_match_all("/[0-9]+/",$_POST['keyword'],$prematch);
            $arrKeyqord = $prematch[0];
            if($_POST['group']==1){
                $arrServer = json_decode($_POST['content_server'],true);
            }
            if($_POST['group']==2){
                $arrServer = $mappingserver[$_POST['groupserver']]['data'];
            }
            $getGameById = $this->CI->SearchInfoModel->getGameById($_POST['game_id']); 
            $arrMoboID  =array();
            $arrMoboServiceId = array();
            $arrCheckMobo = array();
            if(count($arrKeyqord)>0){
                $i=0;
                foreach($arrKeyqord as $v){
                    if(strlen($v)==9){
                        $getMoboService = $this->CI->InfoMobo->get_mobo_account($v);
                        if($getMoboService['code']=='900000'){
                            $arrMoboServiceTable = $getMoboService['data'][$getGameById['service_id']];
                            if(count($arrMoboServiceTable)>0){
                                foreach($arrMoboServiceTable as $vs){
                                    $arrMoboID[] = $vs['mobo_id'];
                                    $arrMoboServiceId[] = $vs['mobo_service_id'];
                                }
                            }
                        }
                        if($getMoboService['code']=='900001'){
                            $arrMoboID[] = $v;
                            $arrMoboServiceId[] = "empty";
                        }
                    }
                    if(strlen($v)==19){
                        $arrMoboServiceId[] = $v;
                        $arrMoboID[] = ''; 
                    }
                    $i++;
                }
            }
           
            $listItems = array();
            $arrTitle = array();
            if(count($arrServer)>0){
                foreach($arrMoboServiceId as $k=>$mobo){
                    
                    $listItems[$k]['title']['mobo_id'] = $arrMoboID[$k];
                    if(is_array($mobo) && $mobo!='empty'){
                        $listItems[$k]['title']['mobo_service_id'] = $mobo['mobo_service_id'];  
                    }
                    if(!is_array($mobo) && $mobo!='empty'){
                        $listItems[$k]['title']['mobo_service_id'] = $mobo;
                    }
                    if(!is_array($mobo) && $mobo=='empty'){
                        $listItems[$k]['title']['mobo_service_id'] = 'empty';
                    }
                    foreach($arrServer as $v){
                        $arrTitle[] = $listItems[$k]['data'][$v['server_id']] = $this->CI->GameAPI->get_user_info($_POST['game_id'],$mobo,$v['server_id']);
                    }
                }
            }   
			
			if($_POST['game_id']=='bog'){
				$resultTitle = array();
				if(count($arrTitle[0])>0){
					$a==0;
					foreach($arrTitle[0] as $table){
						$a++;
						if($a==1){
							foreach($table as $k=>$v){
								$resultTitle[$k] = $k;
							}
						}
					}
				}
			}else{
				$resultTitle = array();
				if(count($arrTitle)>0){
					foreach($arrTitle as $v){
						$countV = count($v);
						if($countV>0){
							$resultTitle = $v;
						}
					}
				}
			}
        }
		
        $this->data['resultTitle'] = $resultTitle;
        $this->data['listItems'] = $listItems;
        $this->CI->template->write_view('content', 'game/searchinfo/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function filter(){
        $arrParam = $this->CI->security->xss_clean($_POST);
        
        if ($_GET['type'] == 'filter') {
            $this->CI->Session->unset_session('game_id', $arrParam['game_id']);
            $this->CI->Session->unset_session('group', $arrParam['group']);
            $this->CI->Session->unset_session('keyword', $arrParam['keyword']);
            $this->CI->Session->unset_session('content_server', $arrParam['content_server']);
            $this->CI->Session->unset_session('groupserver', $arrParam['groupserver']);
        }
    }
    public function loadserver(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $listServer = $this->CI->SearchInfoModel->listServerByGame($_GET['game_id']);
        $this->data['listServer'] = $listServer;
        $s_id = array();
        $n_id = $_GET['lid'];
        if (!empty($n_id)){
            $s_id = explode(",", $n_id);
        }
        $this->data['s_id']= $s_id;
        echo $this->CI->load->view('game/searchinfo/loadserver', $this->data, true);
        die();
    }
    public function getvalidate(){
        preg_match_all("/[0-9]+/",$_REQUEST['keyword'],$prematch);
        $arrMobo = '';
        $arrAllMobo = array();
        if(count($prematch[0])>0){
            foreach($prematch[0] as $v){
                if(strlen($v)!=9 && strlen($v)!=19){
                    $arrMobo[] = $v; 
                }
                $arrAllMobo[] = $v;
            }
            $arrMobo = @implode(',', $arrMobo);
        }
        
        if($_REQUEST['game_id']==""){
            $reponse = array(
                'error' => 1,
                'messg' => 'Vui lòng chọn game',
            );
        }elseif($_REQUEST['keyword']==NULL || $_REQUEST['keyword']==""){
            $reponse = array(
                'error' => 1,
                'messg' => 'Nhập MoboID hoặc MoboServiceID'
            );
        }elseif(!empty($arrMobo)){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Mobo '.$arrMobo.' không hợp lệ'
                );
        }elseif(count($arrAllMobo)>10){
            $reponse = array(
                'error' => 1,
                'messg' => 'Cho phép tối đa 10 TK MoboID !'
            );
        }else{
            if($_REQUEST['group']==1){
                $content_server = json_decode($_REQUEST['content_server'],true);
                if(count($content_server)==0){
                    $reponse = array(
                        'error' => 1,
                        'messg' => 'Vui lòng chọn server'
                    );
                }else{
                    
                    if(count($content_server)>5){
                        $reponse = array(
                            'error' => 1,
                            'messg' => 'Vui lòng chọn tối thiểu 5 server'
                        );
                    }else{
                        $reponse = array(
                            'error' => 0,
                            'messg' => 'Thành công'
                        );
                    }
                }
            }
            if($_REQUEST['group']==2){
                if(empty($_REQUEST['groupserver'])){
                    $reponse = array(
                        'error' => 1,
                        'messg' => 'Chọn cụm server'
                    );
                }else{
                    $reponse = array(
                        'error' => 0,
                        'messg' => 'Thành công'
                    );
                }
            }
            if($_REQUEST['group']==0){
                $reponse = array(
                    'error' => 1,
                    'messg' => 'Chọn server'
                );
            }
        }
        echo json_encode($reponse);
        exit();
    }
    function getpopup(){
        $listServer = $this->CI->SearchInfoModel->listServerByGame($_REQUEST['game_id']);
        $this->data['listServer'] = $listServer;
        $f = array(
            'error'=>0,
            'messg'=>'Thành công',
            'html'=>$this->CI->load->view('game/searchinfo/common/listserver', $this->data, true)
        );
        echo json_encode($f);
        exit();
    }
    public function getselect(){
        $listServer = $this->CI->SearchInfoModel->listServerByGame($_REQUEST['game_id']);
        $this->data['mappingserver'] = $this->mappingServer($listServer);
        $f = array(
            'error'=>0,
            'messg'=>'Thành công',
            'html'=>$this->CI->load->view('game/searchinfo/common/selectserver', $this->data, true)
        );
        echo json_encode($f);
        exit();
    }
	public function viewdata(){
		$this->data['title'] = $_REQUEST['title'];
		$this->data['info'] = $_REQUEST['info'];
		$f = array(
            'error'=>0,
            'messg'=>'Thành công',
            'html'=>$this->CI->load->view('game/searchinfo/loaddata', $this->data, true)
        );
        echo json_encode($f);
        exit();
	}
    public function getResponse() {
        return $this->_response;
    }
}