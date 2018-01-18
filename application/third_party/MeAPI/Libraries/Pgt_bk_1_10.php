<?php
class Pgt {

    private $CI;
    
    private $cur_page;
    private $per_page;
    private $count;
    private $base_url;
    
    public function __construct() {
        $this->CI = & get_instance();
      
    }
    public function cfig($config = array()){
        $this->cur_page = $config['cur_page'];
        $this->per_page = $config['per_page'];
        $this->count = $config['total_rows'];
        $this->base_url = $config['base_url'];
    }
    public function create_links(){
        $paging = "";
        if(($this->count / $this->per_page) > 1){
            $previous_btn = true;
            $next_btn = true;
            $first_btn = true;
            $last_btn = true;
            
            $no_of_paginations = ceil($this->count / $this->per_page);
            
            if ($this->cur_page >= 3) {
                $start_loop = $this->cur_page-1;
                if ($no_of_paginations > $this->cur_page +1)
                        $end_loop = $this->cur_page + 1;
                else if ($this->cur_page <= $no_of_paginations && $this->cur_page > $no_of_paginations -2) {
                        $start_loop = $no_of_paginations - 2;
                        $end_loop = $no_of_paginations;
                } else {
                        $end_loop = $no_of_paginations;
                }
            } else {
                $start_loop = 1;
                if ($no_of_paginations >3)
                    $end_loop = 3;
                else
                    $end_loop = $no_of_paginations;
            }
            
            $paging .= "<ul class='pagination' style='float: right; padding:0px; margin:0px'>";
			
            // FOR ENABLING THE FIRST BUTTON
            if ($first_btn && $this->cur_page > 1) {
                    $paging .= "<li p='1' class='inactive'><a href='".$this->base_url."&page=1'><<</a></li>";
            } else if ($first_btn) {
                    $paging .= "<li p='1' class='inactive'><a href='javascript:void(0)'><<</a></li>";
            }
            
            // FOR ENABLING THE PREVIOUS BUTTON
            if ($previous_btn && $this->cur_page > 1) {
                    $pre = $this->cur_page - 1;
                    $paging .= "<li p='".$pre."' class='inactive'><a href='".$this->base_url."&page=".$pre."'><</a></li>";
            } else if ($previous_btn) {
                    $paging .= "<li class='inactive'><a href='javascript:void(0)'><</a></li>";
            }
            $curp = 1;
            for ($i = $start_loop; $i <= $end_loop; $i++) {
                if ($this->cur_page == $i){
                    $curp = $i;
                    $paging .= "<li p='".$i."' class='active'><a href='javascript:void(0)'>".$i."</a></li>";
                }else{
                    $paging .= "<li p='$i' class='inactive'><a href='".$this->base_url."&page=".$i."'>".$i."</a></li>";
                }
            }
            
            // TO ENABLE THE NEXT BUTTON
            if ($next_btn && $this->cur_page < $no_of_paginations) {
                $nex = $this->cur_page + 1;
                $paging .= "<li p='".$nex."' class='inactive'><a href='".$this->base_url."&page=".$nex."'>></a></li>";
            } else if ($next_btn) {
                $paging .= "<li class='inactive'><a href='javascript:void(0)'>></a></li>";
            }
            
            // TO ENABLE THE END BUTTON
            if ($last_btn && $this->cur_page < $no_of_paginations) {
                $paging .= "<li p='".$no_of_paginations."' class='inactive'><a href='".$this->base_url."&page=".$no_of_paginations."'>>></a></li>";
            } else if ($last_btn) {
                $paging .= "<li p='$no_of_paginations' class='inactive'><a href='javascript:void(0)'>>></a></li>";
            }
            
            $paging .= "<li class='active'><a href='javascript:void(0)'>".$curp."/".$no_of_paginations."</a></li>";
            
        }
        return $paging;
    }
	
	//ajax
	public function create_links_ajax(){
        $paging = "";
        if(($this->count / $this->per_page) > 1){
            $previous_btn = true;
            $next_btn = true;
            $first_btn = true;
            $last_btn = true;
            
            $no_of_paginations = ceil($this->count / $this->per_page);
            
            if ($this->cur_page >= 3) {
                $start_loop = $this->cur_page-1;
                if ($no_of_paginations > $this->cur_page +1)
                        $end_loop = $this->cur_page + 1;
                else if ($this->cur_page <= $no_of_paginations && $this->cur_page > $no_of_paginations -2) {
                        $start_loop = $no_of_paginations - 2;
                        $end_loop = $no_of_paginations;
                } else {
                        $end_loop = $no_of_paginations;
                }
            } else {
                $start_loop = 1;
                if ($no_of_paginations >3)
                    $end_loop = 3;
                else
                    $end_loop = $no_of_paginations;
            }
            
            $paging .= "<ul class='pagination' style='float: right; padding:0px; margin:0px'><li class='inactive'><a>Total:".$this->count."</a></li>";
			
            // FOR ENABLING THE FIRST BUTTON
            if ($first_btn && $this->cur_page > 1) {
                    $paging .= "<li p='1' class='inactive'><a href='javascript:void(0)' onclick='loadlistproperty1(".$_GET['id_project'].",1,\"\")' ><<</a></li>";
            } else if ($first_btn) {
                    $paging .= "<li p='1' class='inactive'><a href='javascript:void(0)'><<</a></li>";
            }
            
            // FOR ENABLING THE PREVIOUS BUTTON
            if ($previous_btn && $this->cur_page > 1) {
                    $pre = $this->cur_page - 1;
                    $paging .= "<li p='".$pre."' class='inactive'><a href='javascript:void(0)' onclick='loadlistproperty1(".$_GET['id_project'].",".$pre.",\"\")'><</a></li>";
            } else if ($previous_btn) {
                    $paging .= "<li class='inactive'><a href='javascript:void(0)'><</a></li>";
            }
            $curp = 1;
            for ($i = $start_loop; $i <= $end_loop; $i++) {
                if ($this->cur_page == $i){
                    $curp = $i;
                    $paging .= "<li p='".$i."' class='active'><a href='javascript:void(0)'>".$i."</a></li>";
                }else{
                    $paging .= "<li p='$i' class='inactive'><a href='javascript:void(0)' onclick='loadlistproperty1(".$_GET['id_project'].",".$i.",\"\")'>".$i."</a></li>";
                }
            }
            
            // TO ENABLE THE NEXT BUTTON
            if ($next_btn && $this->cur_page < $no_of_paginations) {
                $nex = $this->cur_page + 1;
                $paging .= "<li p='".$nex."' class='inactive'><a href='javascript:void(0)' onclick='loadlistproperty1(".$_GET['id_project'].",".$nex.",\"\")'>></a></li>";
            } else if ($next_btn) {
                $paging .= "<li class='inactive'><a href='javascript:void(0)'>></a></li>";
            }
            
            // TO ENABLE THE END BUTTON
            if ($last_btn && $this->cur_page < $no_of_paginations) {
                $paging .= "<li p='".$no_of_paginations."' class='inactive'><a href='javascript:void(0)' onclick='loadlistproperty1(".$_GET['id_project'].",".$no_of_paginations.",\"\")'>>></a></li>";
            } else if ($last_btn) {
                $paging .= "<li p='$no_of_paginations' class='inactive'><a href='javascript:void(0)'>>></a></li>";
            }
            
            $paging .= "<li class='active'><a href='javascript:void(0)'>".$curp."/".$no_of_paginations."</a></li>";
            
        }
        return $paging;
    }
}
?>