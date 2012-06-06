<?php
class Application_Model_Mapper_FarmProduct {
	
	private $_dbTable;
	
	public function getDbTable() {
		if(empty($this->_dbTable)) {
			$this->_dbTable = new Application_Model_DbTable_FarmProduct();
		}
		return $this->_dbTable;
	}
	
	public function fromDbObject(Application_Model_FarmProduct $farmProduct, $data) {
		$this->fromDbArray($farmProduct, $data->toArray());	
	}
	
	public function fromDbArray(Application_Model_FarmProduct $farmProduct, array $data) {
		$farmProduct->setFarmProductID($data['id'])
			->setFarmID($data['farm_id'])
			->setIngredientID($data['ingredient_id'])
			->setStartDate(new Zend_Date($data['start_date'], Zend_Date::ISO_8601))
			->setEndDate(new Zend_Date($data['end_date'], Zend_Date::ISO_8601))
			->setPrice($data['price']);
	}
	
	public function toDbArray(Application_Model_FarmProduct $farmProduct) {
		$data = array(
			'farm_id'=>$farmProduct->getFarmID(),
			'ingredient_id'=>$farmProduct->getIngredientID(),
			'start_date'=>$farmProduct->getStartDate(),
			'end_date'=>$farmProduct->getEndDate(),
			'price'=>$farmProduct->getPrice()
		);
		return $data;
	}
	
	
	
}
?>