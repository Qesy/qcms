<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Debug extends Controllers {
    
    public function t_Action(){
        $str = '<img src="https://www.baidu.com/img/flexible/logo/pc/result.png" class="rounded mx-auto d-block" alt="你好吗">


<h1>是的撒             旦法</h1>';
        $this->CommonObj->ExecScript('document.writeln("'.$this->CommonObj->Html2Js($str).'");');exit;
        /* $this->SysRs = $this->SysObj->getKv();
        $Template = self::_getTemplate('list_');
        var_dump($Template); */
        // 分类各种测试
        /* $this->CategoryObj->getAllCateId('3', 1);
        var_dump($this->CategoryObj->AllSubCateIdArr);
        return; */
        /* $this->CategoryObj->getTreeModelSelectArr(1);
        var_dump($this->CategoryObj->CateTreeModelSelectArr);
        return; */
        /* $this->CategoryObj->getTreeModelSelectHtml(1);
        var_dump($this->CategoryObj->CateTreeModelSelectHtml);
        return; */
        $this->CategoryObj->getTreeSelectArr(1);
        var_dump($this->CategoryObj->CateTreeSelectArr);
        return;  
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