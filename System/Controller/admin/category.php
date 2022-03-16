<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Category extends ControllersAdmin {
    
    public function index_Action(){
        $this->LoadView('admin/common/list');
    }
    
    public function add_Action(){
        
    }
    
    public function edit_Action(){
        
    }
    
    public function del_Action(){
        
    }
    
}