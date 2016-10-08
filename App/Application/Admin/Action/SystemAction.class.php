<?php
Class SystemAction extends CommonAction{


	function index(){

		$this->display();
	}

	function addHandle(){
		$webname = $this->_param('webname');
		$copyright = $this->_param('copyright');
		$data = array(
			'webname'=>$webname,
			'copyright'=>$copyright,
			);

		//组合配置文件格式
		$str = "<?php\r\n return ".var_export(array_change_key_case($_POST,CASE_UPPER),true).";\r\n?>";
		//指定生成文件目录及名称
		file_put_contents(APP_PATH.'/Conf/system.php',$str);
		$this->success('修改成功',U(GROUP_NAME.'/System/index'));	
		
	}

	function upload(){

		import('ORG.Net.UploadFile');
        
        $upload = new UploadFile();
        
        $upload->maxSize = 3145728;
        
        $upload->allowExts = array('jpg','gif','png','bmp');
        
        $upload->savePath = './Uploads/';
        
        $upload->autoSub = true;
        
        $upload->subType = 'date';
        
        $upload->dateFormat = 'Ym';

        if(!$upload->upload()){
            
            //$this->error($upload->getErrorMsg());
            $data = array(
            	'status'=>0,
            	'message'=>$upload->getErrorMsg(),
            	);
            
        }else{
            
            $info = $upload->getUploadFileInfo();
            $logo = $info[0]['savename'];

            $data = array(

            	'status'=>1,
            	'logo'=>$logo,
            	);
        }
        

        echo json_encode($data);

	}
}