<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Debug extends Controllers {
    
    public function t_Action(){
        $this->CategoryObj->getTreeDetal();
        var_dump($this->CategoryObj->CateTreeDetail);
    }
    
}