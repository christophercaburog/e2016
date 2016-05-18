<?php

require_once(SYSCONFIG_CLASS_PATH."util/displaytable.class.php");

class clsTableList3 extends DisplayTable {

	var $conn;
	var $tblBlock;
	var $resultInfo;
	var $arrFields;
	var $tDisplayTable;
	var $linkPage;
	var $GET;

	function clsTableList3($dbconn_ = null){
		$this->GET = $_GET;
		$this->conn =& $dbconn_;
		parent::DisplayTable($this->conn);
		$this->tblBlock = new BlockBasePHP();
		$this->tblBlock->templateFile = "table3.tpl.php";
		$this->arrFields = array();
		$this->linkPage = "&p=@@";
		$this->pagenum = (isset($this->GET['p3']))?$this->GET['p3']:1;
	}

	function getTableList3($attribs = array()){

		if(empty($this->sqlAll) /*|| empty($this->sqlCount)*/) return "";

		$this->getAll();

		$this->resultInfo = $this->paginator->getPaginatorLine();

		$this->tblBlock->assign('attribs',$attribs);
		$this->tblBlock->assign('resultsInfo',$this->resultInfo);
		$this->tblBlock->assign('tblFields',$this->arrFields);
		$this->tblBlock->assign('tblData',$this->results);
		return $this->tblBlock->fetchBlock();
	}

}


?>