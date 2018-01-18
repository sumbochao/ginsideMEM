<?php

function GMGridViewGroup($label,$id,$value=array(),$arrH=array()) {
    $html = '';
    if(empty($value) === FALSE){
        if(empty($arrH) === FALSE){
            $arrHeader = $arrH;
        }else{
            $arr = array();
            foreach($value[0] as $key => $v){
                $arr[] = $key;
            }
            $arrHeader = $arr;
        }
        
        //$arrHead = array_diff($arrHeader, array($groupfield));
        $arrHead = $arrHeader;
        $rolead = array();
        $rolead = $value;
        //foreach ($value as $m) {
            //$rolead[$m[$groupfield]][] = $m;
        //}
        
        
        $html .= "<div class='row' style='font-size:12px'>
                    <div class='col-lg-12'>
                        <div class='box dark'>
                            <header>
                                <h5 style='text-transform:uppercase; color:#428BCA'>".$label."</h5>
                                    <div class='toolbar'>
                                        <ul class='nav'>
                                            <li>
                                            <a class='minimize-box' href='#div-".$id."' data-toggle='collapse'>
                                                <i class='fa fa-chevron-up'></i>
                                            </a>
                                            </li>
                                        </ul>
                                    </div>
                                </header>
                    <div id='div-".$id."' class='accordion-body body in' style='height: auto;'>";

        $html .= "<table id='tbl_".$id."' width='100%' border='0' class='table table-striped table-bordered table-condensed table-hover'>
                    <thead>
                        <tr>";

        foreach($arrHead as $val){
            $html .= "<th>".$val."</th>";
        }


              
        $html .= "</tr>
                 </thead>
                 <tbody>";

        foreach($rolead as $key => $va){
            
            if(count($value) > 1){
            $html .= "<tr>
                        <td colspan='".count($arrHead)."' style='font-weight: bold'>".$key."</td>
                    </tr>";
            }
            
            foreach($va as $val){
            
            $html .= "<tr>";
               foreach($arrHead as $v){
                    $html .= "<td>".$val[$v]."</td>";
                }
            $html .= "</tr>";
            }
            
             
        }


        $html .= "</tbody>
                   </table>";

        $html .= "</div>
                    </div>
                </div>
        </div>";
        
        
        
    }else{
        
        $html .= "<div class='row' style='font-size:12px'>
                    <div class='col-lg-12'>
                        <div class='box dark'>
                            <header>
                                <h5 style='text-transform:uppercase; color:#428BCA'>".$label."</h5>
                                    <div class='toolbar'>
                                        <ul class='nav'>
                                            <li>
                                            <a class='minimize-box' href='#div-".$id."' data-toggle='collapse'>
                                                <i class='fa fa-chevron-up'></i>
                                            </a>
                                            </li>
                                        </ul>
                                    </div>
                                </header>
                    <div id='div-".$id."' class='accordion-body body in' style='height: auto;'>";

        

        $html .= "</div>
                    </div>
                </div>
        </div>";
    }
    return $html;
}
?>
