<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Debug extends Controllers {
    
    public function testUp_Action(){
        require_once './System/Upgrade/upgrade_6.0.1.php';
        $UpgradeObj = new Upgrade();
        $UpgradeObj->Exec();
    }
    
    public function w_Action(){        
        $this->CategoryObj->getAllCateId(31, -1);
        var_dump($this->CategoryObj->AllSubCateIdArr);exit;
        $this->WaterMaskObj->waterType = 1;
        $this->WaterMaskObj->waterImg = realpath('./Static/images/mark.png');
        $this->WaterMaskObj->fontFile = realpath('./Static/fonts/msyh.ttc');
        $this->WaterMaskObj->waterStr = '我是好人吗';
        $this->WaterMaskObj->pos = 9;
        $this->WaterMaskObj->setSrcImg(realpath('./Static/upload/20220329/5396242acfb7a4036.jpg') );
        $Ret = $this->WaterMaskObj->output();
        var_dump($Ret);
    }
    
    public function t_Action(){
        $Ret = $this->Sys_modelObj->ExportSql();
        exit;
        $Ret = $this->Sys_modelObj->Data2Sql('file');
        var_dump($Ret);
        return;
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
    
    public function fixAlbumData_Action(){
        $Arr = $this->PhotosObj->ExecSelect();
        foreach($Arr as $k => $v){
            $Data = json_decode($v['Photos'], true);
            foreach($Data as $sk => $sv){
                $sv['Path'] = str_replace('/Static/upload/', 'https://cdn.q-cms.cn/resource/upload/', $sv['Path']);
                $Data[$sk] = $sv;                
            }
            $this->PhotosObj->SetCond(array('Id' => $v['Id']))->SetUpdate(array('Photos' => json_encode($Data)))->ExecUpdate();
        }
        echo 'Success !';
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