<?php 
use Model\QC_Sys;
use Model\QC_Category;

class Upgrade{
    
    public function Exec(){
        $SysObj = QC_Sys::get_instance();
        $CategoryObj = QC_Category::get_instance();
        $DbConfig = Config::DbConfig();
        $Rs = $CategoryObj->SetTbName('category')->ExecSelectOne();
        $FieldArr = array_keys($Rs);
        $PageRs = $CategoryObj->SetTbName('page')->ExecSelectOne();
        $PageFieldArr = array_keys($PageRs);
        $ArticleRs = $CategoryObj->SetTbName('table_article')->ExecSelectOne();
        $ArticleFieldArr = array_keys($ArticleRs);
        $ModelArr = $CategoryObj->SetTbName('sys_model')->ExecSelect();
        try{
            $SysObj->exec('alter table '.$DbConfig['Prefix'].'swiper_cate modify COLUMN Name varchar(100) NOT NULL DEFAULT "";', array());
            if(!in_array('TCateId', $FieldArr)){
                $SysObj->exec('alter table '.$DbConfig['Prefix'].'category add COLUMN TCateId int(11) NOT NULL DEFAULT "0";', array()); 
            }
            if(!in_array('NameEn', $FieldArr)){
                $SysObj->exec('alter table '.$DbConfig['Prefix'].'category add COLUMN NameEn varchar(100) NOT NULL DEFAULT "";', array()); 
            }    
            if(!in_array('NameEn', $PageFieldArr)){
                $SysObj->exec('alter table '.$DbConfig['Prefix'].'page add COLUMN NameEn varchar(100) NOT NULL DEFAULT "";', array());
            }  
            if(!in_array('DownNum', $ArticleFieldArr)){
                foreach($ModelArr as $v){
                    $SysObj->exec('alter table '.$DbConfig['Prefix'].'table_'.$v['KeyName'].' add COLUMN DownNum int(11) NOT NULL DEFAULT "0";', array());
                }
                
            }
        }catch (PDOException $e){
        
        }
        
        $TopCateArr = $SysObj->SetTbName('category')->SetCond(array('PCateId' => 0))->SetField('CateId, PCateId')->ExecSelect();
        $SecCateArr = $SysObj->SetTbName('category')->SetCond(array('PCateId' => array_column($TopCateArr, 'CateId')))->SetField('CateId, PCateId')->ExecSelect();
        foreach($SecCateArr as $v){
            $CategoryObj->getAllCateId($v['CateId'], -1);
            $CategoryObj->SetCond(array('CateId' => $CategoryObj->AllSubCateIdArr))->SetUpdate(array('TCateId' => $v['PCateId']))->ExecUpdate();
        }
    }
    
}
