<?php
/**
 * eBay item information
 *
 * This is where auction items are stored.  Item must exist in this table before auction use.
 *
 * @author Nick Lopez <nick@nicklopezcodes.com>
 */
class Item {
	/**
	 * id for item; this is the Primary Key
	 */
	private $itemId;
	/**
	 * brand or manufacturer name of item
	 */
	private $itemBrand;
	/**
	 * description of item
	 */
	private $itemDescription;
	/**
	 * model name or number of item
	 */
	private $itemModel;

	/**
	 * constructor for item
	 *
	 * @param mixed $newItemId item id of item
	 * @param string $newItemBrand brand or manufacturer name of item
	 * @param string $newItemDescription description of item
	 * @param string $newItemModel model name or number of item
	 * @throws InvalidArgumentException if data types are invalid
	 * @throws RangeException if data values are out of bounds
	 */
	public function __construct($newItemId, $newItemBrand, $newItemDescription, $newItemModel) {
		// use the mutators to do the work for us
		try {
			$this->setItemId($newItemId);
			$this->setItemBrand($newItemBrand);
			$this->setItemDescription($newItemDescription);
			$this->setItemModel($newItemModel);
		} catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			// rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		}
	}

	/**
	 * accessor method for the item id
	 *
	 * @return int value of item id
	 */
	public function getItemId() {
		return ($this->itemId);
	}

	/**
	 * mutator method for item id
	 *
	 * @param mixed $newItemId new value of item id
	 * @throws InvalidArgumentException if $newItemId is not an integer
	 * @throws RangeException if $newItemId is not positive
	 */
	public function setItemId($newItemId) {
		// If item id is null, it is a new primary key value
		if($newItemId === null) {
			$this->itemId = null;
			return;
		}

		// verify item id is valid
		$newItemId = filter_var($newItemId, FILTER_VALIDATE_INT);
		if($newItemId === false) {
			throw(new InvalidArgumentException("item id is not a valid integer"));
		}

		// verify item id is positive
		if($newItemId <= 0) {
			throw(new RangeException("item id is not positive"));
		}

		// convert and store item id
		$this->itemId = intval($newItemId);
	}

	/**
	 * accessor method for item brand info
	 *
	 * @return string value item brand info
	 */
	public function getItemBrand() {
		return ($this->itemBrand);
	}

	/**
	 * mutator method for item brand info
	 *
	 * @param string $newItemBrand item brand info
	 * @throws InvalidArgumentException if $newItemBrand is not a string or insecure
	 * @throws RangeException if $newItemBrand is > 50 characters
	 */
	public function setItemBrand($newItemBrand) {
		// verify item brand info is valid
		$newItemBrand = trim($newItemBrand);
		$newItemBrand = filter_var($newItemBrand, FILTER_SANITIZE_STRING);
		if(empty($newItemBrand) === true) {
			throw(new InvalidArgumentException("item brand info content is empty or insecure"));
		}

		// verify item brand info does not exceed 50 characters
		if(strlen($newItemBrand) > 50) {
			throw(new RangeException("item brand info content too large"));
		}

		// store item brand info
		$this->itemBrand = $newItemBrand;
	}

	/**
	 * accessor method for item description
	 *
	 * @return string value item description
	 */
	public function getItemDescription() {
		return ($this->itemDescription);
	}

	/**
	 * mutator method for item description
	 *
	 * @param string $newItemDescription new item description
	 * @throws InvalidArgumentException if $newItemDescription is not a string or insecure
	 * @throws RangeException if $newItemDescription is > 1000 characters
	 */
	public function setItemDescription($newItemDescription) {
		//verify item description is valid
		$newItemDescription = trim($newItemDescription);
		$newItemDescription = filter_var($newItemDescription, FILTER_SANITIZE_STRING);
		if(empty($newItemDescription) === true) {
			throw(new InvalidArgumentException("item description content is empty or insecure"));
		}

		// verify item description does not exceed 1000 characters
		if(strlen($newItemDescription) > 1000) {
			throw(new RangeException("item description content too large"));
		}

		// store item description
		$this->itemDescription = $newItemDescription;
	}

	/**
	 * accessor method for item model info
	 *
	 * @return string value item model info
	 */
	public function getItemModel() {
		return ($this->itemModel);
	}

	/**
	 * mutator method for new item model info
	 *
	 * @param string $newItemModel new item model info
	 * @throws InvalidArgumentException if $newItemModel is not a string or insecure
	 * @throws RangeException if $newItemModel is > 50 characters
	 */
	public function setItemModel($newItemModel) {
		// verify item model info is valid
		$newItemModel = trim($newItemModel);
		$newItemModel = filter_var($newItemModel, FILTER_SANITIZE_STRING);
		if(empty($newItemModel) === true) {
			throw(new InvalidArgumentException("item model content is empty or insecure"));
		}

		// verify item model info does not exceed 50 characters
		if(strlen($newItemModel) > 50) {
			throw(new RangeException("item model content too large"));
		}

		// store item model info
		$this->itemModel = $newItemModel;
	}

	/**
	 * inserts item into mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function insert(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the itemId is null (i.e., don't insert an item that already exists)
		if($this->itemId !== null) {
			throw(new mysqli_sql_exception("not a new item"));
		}

		// create query template
		$query = "INSERT INTO item(itemBrand, itemDescription, itemModel) VALUES(?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the item variables to the place holders in the template
		$wasClean = $statement->bind_param("sss", $this->itemBrand, $this->itemDescription, $this->itemModel);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("unable to execute mySQL statement: " . $statement->error));
		}

		// update the null itemId with what mySQL just gave us
		$this->itemId = $mysqli->insert_id;

		// clean up the statement
		$statement->close();
	}

	/**
	 * deletes an item from mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function delete(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the itemId is not null (i.e., don't delete an item that hasn't been inserted)
		if($this->itemId === null) {
			throw(new mysqli_sql_exception("unable to delete an item that does not exist"));
		}

		// create query template
		$query = "DELETE FROM item WHERE itemId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the item variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->itemId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("unable to execute mySQL statement: " . $statement->error));
		}

		// clean up the statement
		$statement->close();
	}

	/**
	 * updates an item in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function update(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the itemId is not null (i.e., don't update an item that hasn't been inserted)
		if($this->itemId === null) {
			throw(new mysqli_sql_exception("unable to update an item that does not exist"));
		}

		// create query template
		$query = "UPDATE item SET itemBrand = ?, itemDescription = ?, itemModel = ? WHERE itemId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the item variables to the place holders in the template
		$wasClean = $statement->bind_param("sssi", $this->itemBrand, $this->itemDescription, $this->itemModel, $this->itemId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("unable to execute mySQL statement: " . $statement->error));
		}

		// clean up the statement
		$statement->close();
	}
}
?>