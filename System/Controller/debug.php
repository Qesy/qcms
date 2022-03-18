<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Debug extends Controllers {
    
    public function t_Action(){
        /* $this->SysRs = $this->SysObj->getKv();
        $Template = self::_getTemplate('list_');
        var_dump($Template); */
        $this->CategoryObj->getTreeModelSelectArr(1);
        var_dump($this->CategoryObj->CateTreeModelSelectArr);
        return;
        $this->CategoryObj->getTreeModelSelectHtml(1);
        var_dump($this->CategoryObj->CateTreeModelSelectHtml);
        return;
        /* $this->CategoryObj->getTreeSelectArr(1);
        var_dump($this->CategoryObj->CateTreeSelectArr);
        return; */
        $this->CategoryObj->getTreeSelectHtml(1);
        var_dump($this->CategoryObj->CateTreeSelectHtml);
    }
    
    private function _getTemplate($Prefix){
        $Files = scandir(PATH_TEMPLATE.$this->SysRs['TmpPath'].'/');
        $Template = array();
        foreach($Files as $v){
            if(in_array($v, array('.', '..'))) continue;
            if(is_dir(PATH_TEMPLATE.$v)) continue;
            if(strpos($v, $Prefix) !== 0 || substr($v, -5) != '.html') continue;
            $Template[$v] = $v;
        }
        return $Template;
    }
    
}