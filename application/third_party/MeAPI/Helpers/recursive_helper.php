<?php   
function process($data,$parents = 0){
    $newMenu = array();
    recursive($data,$parents,1,$newMenu);
    return $newMenu;
}
function recursive($menu,$parents = 0,$level = 1,&$newMenu){
    foreach ($menu as $key => $val){
        if($val['parents'] == $parents){
            $val['level'] = $level;
            $newMenu[] = $val;
            unset($menu[$key]);
            recursive($menu,$val['id'],$val['level'] + 1,$newMenu);
        }
    }
}
function getParentsIdArray($data,$id,$options = null){
    if($options['type'] == 1){
        $arrParents[] = $id;
    }
    findParents($data,$id, $arrParents);
    return $arrParents;
}
function findParents($sourceArr,$id, &$arrParents){
    foreach ($sourceArr as $key => $value){		
        if($value['id'] == $id){
            if( $value['parents'] >0 ){
                $arrParents[] = $value['parents'];
                unset($sourceArr[$key]);
                $newID = $value['parents'];
                findParents($sourceArr,$newID, $arrParents);
            }
        }
    }
}