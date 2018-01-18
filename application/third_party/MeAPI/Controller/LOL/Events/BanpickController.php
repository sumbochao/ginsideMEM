<?php
class MeAPI_Controller_LOL_Events_BanpickController implements MeAPI_Controller_LOL_Events_BanpickInterface {
    protected $_response;
    private $CI;
    private $url_service;
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->MeAPI_Library('Session');
        $this->CI->load->library('cache');
        $this->CI->load->library('Template');
        $this->CI->load->helper('url');
        $this->CI->load->library('pagination');
        $this->data['session_account'] = $this->CI->Session->get_session('account');
        $this->data['session_menu'] = $this->CI->Session->get_session('menu');
        $this->authorize = new MeAPI_Controller_AuthorizeController();
        $session = $this->CI->Session->get_session('account');
        $this->view_data = new stdClass();
        if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
            $this->url_service = 'http://localhost.service.lol.mobo.vn';
        }else{
            $this->url_service = 'http://game.mobo.vn/lol';
        }
        $this->url_picture = $this->url_service.'/assets/tienbao';
        $this->data['url_service'] = $this->url_service;
    }
    public function load_team(MeAPI_RequestInterface $request){
        $linkTeamUser = $this->url_service.'/cms/banpick_v1/team_user?mobo_id='.$_REQUEST['mobo_id'];
        $j_TeamUser = file_get_contents($linkTeamUser);
        $teamUser = json_decode($j_TeamUser,true);
        $this->data['team_user'] = $teamUser;
        if($_REQUEST['mobo_id']>0){
            $f = array(
                'error'=>'0',
                'messg'=>'Thành công',
                'html'=>$this->CI->load->view('game/lol/Events/banpick/listteam/load_team', $this->data, true)
            );
        }else{
            $f = array(
                'error'=>'1',
                'messg'=>'Thất bại'
            );
        }
        echo json_encode($f);
        exit();
    }
    public function linkdata(MeAPI_RequestInterface $request){
        $infoTeam = file_get_contents($_REQUEST['link']);
        if($infoTeam=='ok'){
            $f = array(
                'messg'=>'Thành công '.'['.$infoTeam.']'
            );
        }else{
            $f = array(
                'messg'=>'Thất bại'
            );
        }
        echo json_encode($f);
        exit();
    }
    public function index(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'wall':
                $this->data['title']= 'DANH SÁCH TƯỚNG';
                break;
            case 'team':
                $this->data['title']= 'DANH SÁCH TEAM';
                break;
            case 'config':
                $this->data['title']= 'DANH SÁCH CẤU HÌNH';
                break;
            case 'user':
                $this->data['title']= 'DANH SÁCH THÀNH VIÊN';
                break;
            case 'listteam':
                $this->data['title']= 'DANH SÁCH ĐỘI HÌNH';
                $infoDetail = file_get_contents($this->url_service.'/cms/banpick_v1/index_user');
                $items = json_decode($infoDetail,true);
                $this->data['list_user'] = $items['rows'];
                break;
        }
        $this->CI->template->write_view('content', 'game/lol/Events/banpick/'.$_GET['view'].'/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        switch ($_GET['view']){
            case 'wall':
                $this->data['title']= 'THÊM TƯỚNG';
                break;
            case 'team':
                $this->data['title']= 'THÊM TEAM';
                break;
            case 'config':
                $this->data['title']= 'THÊM CẤU HÌNH';
                break;
            case 'user':
                $this->data['title']= 'THÊM THÀNH VIÊN';
                break;
        }
        $this->CI->template->write_view('content', 'game/lol/Events/banpick/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function edit(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $id = $_GET['id'];
        switch ($_GET['view']){
            case 'wall':
                $this->data['title']= 'SỬA TƯỚNG';
                $linkinfo = $this->url_service.'/cms/banpick/get_'.$_GET['view'].'?id='.$id;
                break;
            case 'team':
                $this->data['title']= 'SỬA TEAM';
                $linkinfo = $this->url_service.'/cms/banpick/get_'.$_GET['view'].'?id='.$id;
                break;
            case 'config':
                $this->data['title']= 'SỬA CẤU HÌNH';
                $linkinfo = $this->url_service.'/cms/banpick_v1/get_'.$_GET['view'].'?id='.$id;
                break;
            case 'user':
                $this->data['title']= 'SỬA THÀNH VIÊN';
                $linkinfo = $this->url_service.'/cms/banpick_v1/get_'.$_GET['view'].'?id='.$id;
                break;
        }
        
        $infoDetail = file_get_contents($linkinfo);
        $items = json_decode($infoDetail,true);
        $this->data['items'] = $items; 
        $this->CI->template->write_view('content', 'game/lol/Events/banpick/'.$_GET['view'].'/add', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0); 
        $id = $_GET['id'];
		switch ($_GET['view']){
            case 'wall':
                $linkInfo = $this->url_service.'/cms/banpick/delete_'.$_GET['view'].'?id='.$id;
                break;
            case 'team':
                $linkInfo = $this->url_service.'/cms/banpick/delete_'.$_GET['view'].'?id='.$id;
                break;
            case 'config':
                $linkInfo = $this->url_service.'/cms/banpick_v1/delete_'.$_GET['view'].'?id='.$id;
                break;
            case 'user':
                $linkInfo = $this->url_service.'/cms/banpick_v1/delete_'.$_GET['view'].'?id='.$id;
                break;
        }
        $j_items = file_get_contents($linkInfo);
        redirect(base_url().'?control='.$_GET['control'].'&func=index&view='.$_GET['view'].'&module='.$_GET['module']); 
    }
    public function league(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        
        $linkTeam = $this->url_service.'/cms/banpick/listteam';
        $infoTeam = file_get_contents($linkTeam);
        $listTeam = json_decode($infoTeam,true);
        $this->data['listTeam'] = $listTeam;
        
        $linkWall = $this->url_service.'/cms/banpick/list_frond_end';
        $infoWall = file_get_contents($linkWall);
        $listWall = json_decode($infoWall,true);
        $this->data['listWall'] = $listWall;
        
        $this->CI->template->write_view('content', 'game/lol/Events/banpick/league/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function add_league(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkTeam = $this->url_service.'/cms/banpick/listteam';
        $infoTeam = file_get_contents($linkTeam);
        $listTeam = json_decode($infoTeam,true);
        $this->data['listTeam'] = $listTeam;
        $f = array(
            'error'=>0,
            'messg'=>'Thành công',
            'html'=>NULL
        );
        if (isset($_SESSION["execute_time"]) && (time() - $_SESSION["execute_time"]) < 5) {
            $f = array(
                'error'=>1,
                'messg'=>'Bạn thao tác tối đa 5 giây !',
            );
        }else{
            $_SESSION["execute_time"] = time();
            if($_REQUEST['id_team']>0 && $_REQUEST['id_wall']>0){
                $linkCount = $this->url_service.'/cms/banpick/get_countteam?id_team='.$_REQUEST['id_team'];
                $j_count = file_get_contents($linkCount);
                $count_result = json_decode($j_count,true);
                if(count($count_result)>4){
                    $f = array(
                        'error'=>1,
                        'messg'=>'Chỉ được chọn tối đa 5 tướng !',
                    );
                }else{
                    $linkInsert = $this->url_service.'/cms/banpick/add_league?id_team='.$_REQUEST['id_team'].'&id_wall='.$_REQUEST['id_wall'].'&status='.$_REQUEST['status'];
                    $j_result = file_get_contents($linkInsert);
                    $result = json_decode($j_result,true);
                    if($result['result']==1){
                        $linkGetLeague = $this->url_service.'/cms/banpick/get_league?id_wall='.$_REQUEST['id_wall'];
                        $j_getLeague = file_get_contents($linkGetLeague);
                        $getLeague = json_decode($j_getLeague,true);
                        $this->data['Item'] = $getLeague;
                        $this->data['id_team'] = $_REQUEST['id_team'];
                        $this->data['id_wall'] = $_REQUEST['id_wall'];
                        $f['html'] = $this->CI->load->view('game/lol/Events/banpick/league/ajax_item', $this->data, true);
                        $path_folder = scandir('data_banpick/cache_banpick');
                        foreach($path_folder as $file){
                            if (!is_dir($file)){
                                @unlink(APPLICATION_PATH.'/public/data_banpick/cache_banpick/'.$file);
                            }
                        }
                    }else{
                        $f = array(
                            'error'=>1,
                            'messg'=>'Lỗi xảy ra !',
                        );
                    }
                }
            }else{
                $f = array(
                    'error'=>1,
                    'messg'=>'Lỗi xảy ra !',
                );
            }
        }
        echo json_encode($f);
        exit();
        
    }
    public function reset_league(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkTeam = $this->url_service.'/cms/banpick/listteam';
        $infoTeam = file_get_contents($linkTeam);
        $listTeam = json_decode($infoTeam,true);
        $this->data['listTeam'] = $listTeam;
        $f = array(
            'error'=>0,
            'messg'=>'Thành công',
            'html'=>NULL
        );
        if (isset($_SESSION["execute_time"]) && (time() - $_SESSION["execute_time"]) < 5) {
            $f = array(
                'error'=>1,
                'messg'=>'Bạn thao tác tối đa 5 giây !',
            );
        }else{
            $_SESSION["execute_time"] = time();
            if($_REQUEST['id_wall']>0){
                $linkRemove = $this->url_service.'/cms/banpick/remove_league?id_wall='.$_REQUEST['id_wall'];
                $j_result = file_get_contents($linkRemove);
                $result = json_decode($j_result,true);
                if($result['result']==1){
                    $linkGetWall = $this->url_service.'/cms/banpick/get_wall?id='.$_REQUEST['id_wall'];
                    $j_getWall = file_get_contents($linkGetWall);
                    $getWall = json_decode($j_getWall,true);
                    $this->data['Item'] = $getWall;
                    $this->data['id_wall'] = $_REQUEST['id_wall'];
                    $f['html'] = $this->CI->load->view('game/lol/Events/banpick/league/ajax_remove', $this->data, true);
                    $path_folder = scandir('data_banpick/cache_banpick');
                    foreach($path_folder as $file){
                        if (!is_dir($file)){
                            @unlink(APPLICATION_PATH.'/public/data_banpick/cache_banpick/'.$file);
                        }
                    }
                }else{
                    $f = array(
                        'error'=>1,
                        'messg'=>'Lỗi xảy ra !',
                    );
                }
            }else{
                $f = array(
                    'error'=>1,
                    'messg'=>'Lỗi xảy ra !',
                );
            }
        }
        echo json_encode($f);
        die();
    }
    public function debar_league(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $linkTeam = $this->url_service.'/cms/banpick/listteam';
        $infoTeam = file_get_contents($linkTeam);
        $listTeam = json_decode($infoTeam,true);
        $this->data['listTeam'] = $listTeam;
        $f = array(
            'error'=>0,
            'messg'=>'Thành công',
            'html'=>NULL
        );
        if (isset($_SESSION["execute_time"]) && (time() - $_SESSION["execute_time"]) < 5) {
            $f = array(
                'error'=>1,
                'messg'=>'Bạn thao tác tối đa 5 giây !',
            );
        }else{
            $_SESSION["execute_time"] = time();
            if($_REQUEST['id_wall']>0){
                $linkRemove = $this->url_service.'/cms/banpick/debar_league?id_wall='.$_REQUEST['id_wall'].'&status='.$_REQUEST['status'];
                $j_result = file_get_contents($linkRemove);
                $result = json_decode($j_result,true);
                if($result['result']==1){
                    $linkGetWall = $this->url_service.'/cms/banpick/get_league?id_wall='.$_REQUEST['id_wall'];
                    $j_getWall = file_get_contents($linkGetWall);
                    $getWall = json_decode($j_getWall,true);
                    $this->data['Item'] = $getWall;
                    $this->data['id_wall'] = $_REQUEST['id_wall'];
                    $f['html'] = $this->CI->load->view('game/lol/Events/banpick/league/ajax_debar', $this->data, true);
                    $path_folder = scandir('data_banpick/cache_banpick');
                    foreach($path_folder as $file){
                        if (!is_dir($file)){
                            @unlink(APPLICATION_PATH.'/public/data_banpick/cache_banpick/'.$file);
                        }
                    }
                }else{
                    $f = array(
                        'error'=>1,
                        'messg'=>'Lỗi xảy ra !',
                    );
                }
            }else{
                $f = array(
                    'error'=>1,
                    'messg'=>'Lỗi xảy ra !',
                );
            }
        }
        echo json_encode($f);
        die();
    }
    public function delete_league(MeAPI_RequestInterface $request){
        $linkTeam = $this->url_service.'/cms/banpick/listteam';
        $infoTeam = file_get_contents($linkTeam);
        $listTeam = json_decode($infoTeam,true);
        $this->data['listTeam'] = $listTeam;
        
        $linkWall = $this->url_service.'/cms/banpick/listwall';
        $infoWall = file_get_contents($linkWall);
        $listWall = json_decode($infoWall,true);
        $this->data['listWall'] = $listWall;
        $f = array(
            'error'=>0,
            'messg'=>'Qua lượt thành công',
            'html'=>NULL
        );
        if (isset($_SESSION["execute_time"]) && (time() - $_SESSION["execute_time"]) < 5) {
            $f = array(
                'error'=>1,
                'messg'=>'Bạn thao tác tối đa 5 giây !',
            );
        }else{
            $_SESSION["execute_time"] = time();
			//luu log
            $linkTeamWall = $this->url_service.'/cms/banpick/get_all_team_wall';
            $j_TeamWall = file_get_contents($linkTeamWall);
            $listTeamWall = json_decode($j_TeamWall,true);
            $team1 = '';
            if(is_array($listTeamWall)){
                $team1 = array();
                $team2 = array();
                $cam = array();
                foreach($listTeamWall as $v){
                    if($v['id_team']=='1'){
                        $team1[] = $v['id_wall'];
                    }
                    if($v['id_team']=='2'){
                        $team2[] = $v['id_wall'];
                    }
                    if($v['status']=='0'){
                        $cam[] = $v['id_wall'];
                    }
                }
                $team1 = implode(',', $team1);
                $team2 = implode(',', $team2);
                $cam = implode(',', $cam);
            }
            $linkInsertLog = $this->url_service.'/cms/banpick/insert_history_league?team1='.$team1.'&team2='.$team2.'&cam='.$cam;
            $j_InsertLog = file_get_contents($linkInsertLog);
            $result_InsertLog = json_decode($j_InsertLog,true);
            //xoa bang tam
			
            $linkRemove = $this->url_service.'/cms/banpick/delete_league';
            $j_result = file_get_contents($linkRemove);
            $result = json_decode($j_result,true);
            if($result['result']==1){
                $f['html'] = $this->CI->load->view('game/lol/Events/banpick/league/ajax_loaditem', $this->data, true);
                $path_folder = scandir('data_banpick/cache_banpick');
                foreach($path_folder as $file){
                    if (!is_dir($file)){
                        @unlink(APPLICATION_PATH.'/public/data_banpick/cache_banpick/'.$file);
                    }
                }
            }else{
                $f = array(
                    'error'=>1,
                    'messg'=>'Lỗi xảy ra !',
                );
            }
        }
        echo json_encode($f);
        die();
    }
    public function showlog(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'DANH SÁCH LỊCH SỬ';
        $this->CI->template->write_view('content', 'game/lol/Events/banpick/showlog', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function league1(MeAPI_RequestInterface $request) {
        $this->authorize->validateAuthorizeRequest($request, 0);
        
        $linkTeam = $this->url_service.'/cms/banpick/listteam';
        $infoTeam = file_get_contents($linkTeam);
        $listTeam = json_decode($infoTeam,true);
        $this->data['listTeam'] = $listTeam;
        
        $linkWall = $this->url_service.'/cms/banpick_v1/listwall';
        $infoWall = file_get_contents($linkWall);
        $listWall = json_decode($infoWall,true);
        $this->data['listWall'] = $listWall;
        
        $this->CI->template->write_view('content', 'game/lol/Events/banpick/league1/index', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function delete_league1(MeAPI_RequestInterface $request){
        $linkTeam = $this->url_service.'/cms/banpick/listteam';
        $infoTeam = file_get_contents($linkTeam);
        $listTeam = json_decode($infoTeam,true);
        $this->data['listTeam'] = $listTeam;
        
        $linkWall = $this->url_service.'/cms/banpick/listwall';
        $infoWall = file_get_contents($linkWall);
        $listWall = json_decode($infoWall,true);
        $this->data['listWall'] = $listWall;
        $f = array(
            'error'=>0,
            'messg'=>'Qua lượt thành công',
            'html'=>NULL
        );
        if (isset($_SESSION["execute_time"]) && (time() - $_SESSION["execute_time"]) < 5) {
            $f = array(
                'error'=>1,
                'messg'=>'Bạn thao tác tối đa 5 giây !',
            );
        }else{
            $_SESSION["execute_time"] = time();
			//luu log
            $linkTeamWall = $this->url_service.'/cms/banpick_v1/get_all_team_wall';
            $j_TeamWall = file_get_contents($linkTeamWall);
            $listTeamWall = json_decode($j_TeamWall,true);
            $team1 = '';
            if(is_array($listTeamWall)){
                $team1 = array();
                $team2 = array();
                $cam = array();
                foreach($listTeamWall as $v){
                    if($v['id_team']=='1' && $v['status']=='2'){
                        $team1[] = $v['id_wall'];
                    }
                    if($v['id_team']=='2' && $v['status']=='2'){
                        $team2[] = $v['id_wall'];
                    }
                    if($v['id_team']=='1' && $v['status']=='1'){
                        $cam1[] = $v['id_wall'];
                    }
                    if($v['id_team']=='2' && $v['status']=='1'){
                        $cam2[] = $v['id_wall'];
                    }
                }
                $team1 = implode(',', $team1);
                $team2 = implode(',', $team2);
                $cam1 = implode(',', $cam1);
                $cam2 = implode(',', $cam2);
            }
            $linkInsertLog = $this->url_service.'/cms/banpick_v1/insert_history_league?team1='.$team1.'&team2='.$team2.'&cam1='.$cam1.'&cam2='.$cam2;
            $j_InsertLog = file_get_contents($linkInsertLog);
            $result_InsertLog = json_decode($j_InsertLog,true);
            //xoa bang tam
			
            $linkRemove = $this->url_service.'/cms/banpick_v1/delete_league';
            $j_result = file_get_contents($linkRemove);
            $result = json_decode($j_result,true);
            if($result['result']==1){
                $f['html'] = $this->CI->load->view('game/lol/Events/banpick/league1/ajax_loaditem', $this->data, true);
            }else{
                $f = array(
                    'error'=>1,
                    'messg'=>'Lỗi xảy ra !',
                );
            }
        }
        echo json_encode($f);
        die();
    }
    public function showlog1(MeAPI_RequestInterface $request){
        $this->authorize->validateAuthorizeRequest($request, 0);
        $this->data['title']= 'DANH SÁCH LỊCH SỬ V1';
        $this->CI->template->write_view('content', 'game/lol/Events/banpick/showlog1', $this->data);
        $this->_response = new MeAPI_Response_HTMLResponse($request, $this->CI->template->getHTML());
    }
    public function getResponse() {
        return $this->_response;
    }
}