<?php
class Application_Model_FarmProduct extends Application_Model_Abstract {
	private $_farmProductID;
	private $_farmID;
	private $_ingredientID;
	private $_startDate;
	private $_endDate;
	private $_price;
	
	// Associations
	private $_ingredient;
	
	
	public function ensureSafeLoad() {
		if($this->_farmProductID === false) {
			throw new Exception('In order to load FarmProducts Associations a farmID must be set.');
		}
	}
	
	/****************************************************************************
	 * Associations
	 */
	
	public function getIngredient() {
		if($this->loadLazy()) {
			$this->getBuilder()->build('ingredient', $this);
		}
		return $this->_ingredient;
	}
	
	public function setIngredient(Application_Model_Ingredient $ingredient) {
		$this->_ingredient = $ingredient;
		return $this;
	}
	
	/****************************************************************************
	 * Primary API
	 */
	
	public function __construct($lazy=true) {
		$this->_farmProductID = false;
		if($lazy) {
			$this->setBuilder(new Application_Model_Builder_FarmProduct())
				->allowLazyLoad();
		}
	}
	
	public function getFarmProductID() {
		return $this->_farmProductID;
	}
	
	public function setFarmProductID($farmProductID) {
		$this->_farmProductID = $farmProductID;
		return $this;
	}
	
	public function getFarmID() {
		return $this->_farmID;
	}
	
	public function setFarmID($farmID) {
		$this->_farmID = $farmID;
		return $this;
	}
	
	public function getIngredientID() {
		return $this->_ingredientID;
	}
	
	public function setIngredientID($ingredientID) {
		$this->_ingredientID = $ingredientID;
		return $this;
	}
	
	public function getStartDate() {
		return $this->_startDate;
	}
	
	public function setStartDate(Zend_Date $startDate) {
		$this->_startDate = $startDate;
		return $this;
	}
	
	public function getEndDate() {
		return $this->_endDate;
	}
	
	public function setEndDate(Zend_Date $endDate) {
		$this->_endDate = $endDate;
		return $this;
	}
	
	public function getPrice() {
		return $this->_price;
	}
	
	public function setPrice($price) {
		$this->_price = $price;
		return $this;
	}
	
	
}
?>