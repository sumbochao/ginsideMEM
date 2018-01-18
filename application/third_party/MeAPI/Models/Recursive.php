<?php
class Recursive {
    private $_data;
    public function __construct($data = null) {
        $this->_data = $data;
    }
    public function process($parents = 0) {
        $newMenu = array();
        $this->recursive($this->_data, $parents, 1, $newMenu);
        return $newMenu;
    }
    public function recursive($menu, $parents = 0, $level = 1, &$newMenu) {
        foreach ($menu as $key => $val) {
            if ($val['parents'] == $parents) {
                $val['level'] = $level;
                $newMenu[] = $val;
                unset($menu[$key]);
                $this->recursive($menu, $val['id'], $val['level'] + 1, $newMenu);
            }
        }
    }
    public function getParentsIdArray($id, $options = null) {
        if ($options['type'] == 1) {
            $arrParents[] = $id;
        }
        $this->findParents($this->_data, $id, $arrParents);
        return $arrParents;
    }
    public function findParents($sourceArr, $id, &$arrParents) {
        foreach ($sourceArr as $key => $value) {
            if ($value['id'] == $id) {
                if ($value['parents'] > 0) {
                    $arrParents[] = $value['parents'];
                    unset($sourceArr[$key]);
                    $newID = $value['parents'];
                    $this->findParents($sourceArr, $newID, $arrParents);
                }
            }
        }
    }
}
