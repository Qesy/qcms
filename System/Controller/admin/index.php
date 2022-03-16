<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Index extends ControllersAdmin {
    
    public function index_Action(){
        $this->LoadView('admin/index/index');
    }
    
}