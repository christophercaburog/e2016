<?php

require_once(SYSCONFIG_CLASS_PATH."util/displaytable.class.php");

class clsTableList2 extends DisplayTable {

	var $conn;
	var $tblBlock;
	var $resultInfo;
	var $arrFields;
	var $tDisplayTable;
	var $linkPage;
	var $GET;

	function clsTableList2($dbconn_ = null){
		$this->GET = $_GET;
		$this->conn =& $dbconn_;
		parent::DisplayTable($this->conn);
		$this->tblBlock = new BlockBasePHP();
		$this->tblBlock->templateFile = "table2.tpl.php";
		$this->arrFields = array();
		$this->linkPage = "&p=@@";
		$this->pagenum = (isset($this->GET['p2']))?$this->GET['p2']:1;
	}

	function getTableList2($attribs = array()){

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