<?php
defined ( 'PATH_SYS' ) || exit ( 'No direct script access allowed' );
class Index extends Controllers {

    const CurrentClient = 'Web';
    
	public function index_Action() {
		echo '<br><br><br><h1><center>QFrame PHP Version 1.0.0 </center></h1><center><h2>Author : Qesy, Email : 762264@qq.com</h2><p>Your IP : ' . $this->CommonObj->ip () . '</p></center>';
	}
	
	public function js_Action(){
	    if(!$this->VeriObj->VeriPara($_GET, array('KeyName'))) die($this->LanguageArr [1001]);
	    $Rs = $this->LabelObj->getOne($_GET['KeyName']);
	    if(empty($Rs))  die($this->LanguageArr [1003]);
	    if($Rs['State'] != 1) die($this->LanguageArr [1049]);
	    $this->CommonObj->ExecScript('document.writeln("'.$this->CommonObj->Html2Js($Rs['Content']).'");');exit;
	}
	
	public function admin_Action(){ //管理员登录
	    if(!empty($_POST)){
	        if(!$this->VeriObj->VeriPara($_POST, array('Phone', 'Password', 'VCode'))) $this->Err(1001);
	        if($_POST['VCode'] != $_SESSION['VeriCode']) $this->Err(1012);
	        if(!$this->VeriObj->VeriMobile($_POST['Phone'])) $this->Err(1039);
	        
	        $Rs = $this->UserObj->SetCond(array('Phone' => trim($_POST['Phone']), 'Password' => md5(trim($_POST['Password']))))->ExecSelectOne();
	        if(empty($Rs)) $this->Err(1006);
	        $OldToken = $this->TokenObj->SetCond(array('UserId' => $Rs['UserId'], 'Client' => self::CurrentClient))->ExecSelectOne();
	        $Ts = time();
	        $Ip = $this->CommonObj->ip();
	        $Token = sha1($this->IdCreate());
	        
            try{
                DB::$s_db_obj->beginTransaction();
                if(!empty($OldToken)){
                    $this->TokenObj->SetCond(array('Token' => $OldToken['Token']))->ExecSelectOne();
                }
                $this->Log_loginObj->SetInsert(array('UserId' => $Rs['UserId'], 'Ip' => $Ip, 'Ts' => $Ts, 'Ua'=> $_SERVER['HTTP_USER_AGENT']))->ExecInsert();
                $this->TokenObj->SetInsert(array('Token' => $Token, 'UserId' => $Rs['UserId'], 'Client' => self::CurrentClient, 'Ts' => $Ts))->ExecInsert();                
                $this->UserObj->SetCond(array('UserId' => $Rs['UserId']))->SetUpdate(array('TsLast' => $Ts, 'IpLast' => $Ip))->ExecUpdate();
                DB::$s_db_obj->commit();
            }catch(PDOException $e){
                DB::$s_db_obj->rollBack();
                $this->Err(1040);
            }
            $this->TokenObj->clean($OldToken['Token']);
            $this->UserObj->clean($Rs['UserId']);
            $this->CookieObj->set(array('Token' => $Token, 'Key' => $Key), 'User', 24*14);	        
	        /* if(isset($_GET['Refer'])){ //后台用户不需要
	            $this->CommonObj->ExecScript('window.location.href="'.urldecode($_GET['Refer']).'"');
	        } */
	        $this->CommonObj->Success($this->CommonObj->Url(array('admin', 'index')));
	    }
	    $this->LoadView('index/admin');
	}
	
	public function adminLogout_Action(){
	    $this->CookieObj->delBatch('User');
	    $this->CommonObj->Success($this->CommonObj->Url(array('index', 'admin')), '退出成功');
	}
	
	public function logout_Action(){
	    $this->CookieObj->delBatch('User');
	    $this->CommonObj->Success($this->CommonObj->Url(array('index', 'login')), '退出成功');
	}
	
	public function code_Action(){
	    $this->CodeObj->get_instance();
	    $this->CodeObj->CreateVerifyImage(102, 34);
	    $_SESSION['VeriCode'] = $this->CodeObj->m_verify_code;
	}
	
	public function test_Action(){
	    var_dump($this->CommonObj->GetQuery());
	    $this->CommonObj->SetQuery('aa', 'bb');
	    var_dump($this->CommonObj->GetQuery());
		echo 'test';
	}
}
