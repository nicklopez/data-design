<?php
/**
 * eBay auction information
 *
 * This is where auctions are stored.
 *
 * @author Nick Lopez <nick@nicklopezcodes.com>
 */
class Auction {
	/**
	 * id for auction; this is the Primary Key
	 */
	private $auctionId;
	/**
	 * id for auction type; this is a Foreign Key
	 */
	private $auctionTypeId;
	/**
	 * id for auction item; this is a Foreign Key
	 */
	private $itemId;
	/**
	 * id of member who is selling item; this is a Foreign Key
	 */
	private $sellerMemberId;
	/**
	 * end date of auction
	 */
	private $endDateTime;
	/**
	 * UNC path to location of item photo
	 */
	private $itemPhotoPath;
	/**
	 * qty of items being sold
	 */
	private $itemQty;
	/**
	 * return policy for auction item
	 */
	private $returnPolicy;
	/**
	 * dollar amount - sold price or buy it now price
	 */
	private $soldFinalPrice;
	/**
	 * start date of auction
	 */
	private $startDateTime;

	/**
	 * constructor for auction
	 *
	 * @param mixed $newAuctionId id for new auction
	 * @param int $newAuctionTypeId id of auction type Id
	 * @param int $newItemId id of auction item
	 * @param int $newSellerMemberId id of member who is selling item
	 * @param datetime $newEndDateTime end date of auction
	 * @param string $newItemPhotoPath UNC path to location of item photo
	 * @param int $newItemQty qty of items being sold
	 * @param string $newReturnPolicy return policy for auction item
	 * @param float $newSoldFinalPrice dollar amount - sold price or buy it now price
	 * @param datetime $newStartDateTime start date of auction
	 * @throws InvalidArgumentException if data types are invalid
	 * @throws RangeException if data values are out of bounds
	 */
	public function __construct($newAuctionId, $newAuctionTypeId, $newItemId, $newSellerMemberId, $newEndDateTime, $newItemPhotoPath, $newItemQty, $newReturnPolicy, $newSoldFinalPrice, $newStartDateTime) {
		// use the mutators to do the work for us
		try {
			$this->setAuctionId($newAuctionId);
			$this->setAuctionTypeId($newAuctionTypeId);
			$this->setItemId($newItemId);
			$this->setSellerMemberId($newSellerMemberId);
			$this->setEndDateTime($newEndDateTime);
			$this->setItemPhotoPath($newItemPhotoPath);
			$this->setItemQty($newItemQty);
			$this->setReturnPolicy($newReturnPolicy);
			$this->setSoldFinalPrice($newSoldFinalPrice);
			$this->setStartDateTime($newStartDateTime);
		} catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			// rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		}
	}

	/**
	 * accessor method for the auction id
	 *
	 * @return int value of auction id
	 */
	public function getAuctionId() {
		return ($this->auctionId);
	}

	/**
	 * mutator method for auction id
	 *
	 * @param mixed $newAuctionId new value of auction id
	 * @throws InvalidArgumentException if $newAuctionId is not an integer
	 * @throws RangeException if $newAuctionId is not positive
	 */
	public function setAuctionId($newAuctionId) {
		// If $newAuctionId is null, it is a new primary key value
		if($newAuctionId === null) {
			$this->auctionId = null;
			return;
		}

		// verify auction id is valid
		$newAuctionId = filter_var($newAuctionId, FILTER_VALIDATE_INT);
		if($newAuctionId === false) {
			throw(new InvalidArgumentException("auction id is not a valid integer"));
		}

		// verify auction id is positive
		if($newAuctionId <= 0) {
			throw(new RangeException("auction id is not positive"));
		}

		// convert and store auction id
		$this->auctionId = intval($newAuctionId);
	}

	/**
	 * accessor method for auction type id
	 *
	 * @return int value auction type id
	 */
	public function getAuctionTypeId() {
		return ($this->auctionTypeId);
	}

	/**
	 * mutator method for auction type id
	 *
	 * @param int $newAuctionTypeId auction type id
	 * @throws InvalidArgumentException if $newAuctionTypeId is not an integer
	 * @throws RangeException if $newAuctionTypeId is not positive
	 */
	public function setAuctionTypeId($newAuctionTypeId) {
		// verify auction type id is valid
		$newAuctionTypeId = filter_var($newAuctionTypeId, FILTER_VALIDATE_INT);
		if($newAuctionTypeId === false) {
			throw(new InvalidArgumentException("auction type id is not a valid integer"));
		}

		// verify auction type id is positive
		if($newAuctionTypeId <= 0) {
			throw(new RangeException("auction type id is not positive"));
		}

		// convert and store auction type id
		$this->auctionTypeId = intval($newAuctionTypeId);
	}

	/**
	 * accessor method for item id
	 *
	 * @return int value item id
	 */
	public function getItemId() {
		return ($this->itemId);
	}

	/**
	 * mutator method for item id
	 *
	 * @param int $newItemId item id
	 * @throws InvalidArgumentException if $newItemId is not an integer
	 * @throws RangeException if $newItemId is not positive
	 */
	public function setItemId($newItemId) {
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
	 * accessor method for seller member id
	 *
	 * @return int value seller member id
	 */
	public function getSellerMemberId() {
		return ($this->sellerMemberId);
	}

	/**
	 * mutator method for seller member id
	 *
	 * @param int $newSellerMemberId seller member id
	 * @throws InvalidArgumentException if $newSellerMemberId is not an integer
	 * @throws RangeException if $newSellerMemberId is not positive
	 */
	public function setSellerMemberId($newSellerMemberId) {
		// verify seller member id is valid
		$newSellerMemberId = filter_var($newSellerMemberId, FILTER_VALIDATE_INT);
		if($newSellerMemberId === false) {
			throw(new InvalidArgumentException("seller member id is not a valid integer"));
		}

		// verify seller member id is positive
		if($newSellerMemberId <= 0) {
			throw(new RangeException("seller member id is not positive"));
		}

		// convert and store seller member id
		$this->sellerMemberId = intval($newSellerMemberId);
	}

	/**
	 * accessor method for auction end datetime
	 *
	 * @return datetime value for auction end datetime
	 */
	public function getEndDateTime() {
		return ($this->endDateTime);
	}

	/**
	 * mutator method for auction end datetime
	 *
	 * @param mixed $newEndDateTime auction end date as a DateTime object or string (or null to load the current time)
	 * @throws InvalidArgumentException if $newEndDateTime is not a valid object or string
	 * @throws RangeException if $newEndDateTime is a date that does not exist
	 */
	public function setEndDateTime($newEndDateTime) {
		// base case: if the date is a DateTime object, there's no work to be done
		if(is_object($newEndDateTime) === true && get_class($newEndDateTime) === "DateTime") {
			$this->endDateTime = $newEndDateTime;
			return;
		}

		// treat the date as a mySQL date string: Y-m-d H:i:s
		$newEndDateTime = trim($newEndDateTime);
		if((preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $newEndDateTime, $matches)) !== 1) {
			throw(new InvalidArgumentException("auction end date is not a valid date"));
		}

		// verify the date is really a valid calendar date
		$year = intval($matches[1]);
		$month = intval($matches[2]);
		$day = intval($matches[3]);
		$hour = intval($matches[4]);
		$minute = intval($matches[5]);
		$second = intval($matches[6]);
		if(checkdate($month, $day, $year) === false) {
			throw(new RangeException("auction end date $newEndDateTime is not a Gregorian date"));
		}

		// verify the time is really a valid wall clock time
		if($hour < 0 || $hour >= 24 || $minute < 0 || $minute >= 60 || $second < 0 || $second >= 60) {
			throw(new RangeException("auction end date $newEndDateTime is not a valid time"));
		}

		// store the auction end date
		$newEndDateTime = DateTime::createFromFormat("Y-m-d H:i:s", $newEndDateTime);
		$this->endDateTime = $newEndDateTime;
	}
	/**
	 * accessor method for UNC path to item photo
	 *
	 * @return string value UNC path to item photo
	 */
	public function getItemPhotoPath() {
		return ($this->itemPhotoPath);
	}

	/**
	 * mutator method for UNC path to item photo
	 *
	 * @param string $newItemPhotoPath new UNC path to item photo
	 * @throws InvalidArgumentException if $newItemPhotoPath is not a string or insecure
	 * @throws RangeException if $newItemPhotoPath is > 255 characters
	 */
	public function setItemPhotoPath($newItemPhotoPath) {
		// verify UNC path is valid
		$newItemPhotoPath = trim($newItemPhotoPath);
		$newItemPhotoPath = filter_var($newItemPhotoPath, FILTER_SANITIZE_STRING);
		if(empty($newItemPhotoPath) === true) {
			throw(new InvalidArgumentException("UNC path is empty or insecure"));
		}

		// verify UNC path does not exceed 255 characters
		if(strlen($newItemPhotoPath) > 255) {
			throw(new RangeException("UNC path is too large"));
		}

		// store UNC path
		$this->itemPhotoPath = $newItemPhotoPath;
	}

	/**
	 * accessor method for auction item qty
	 *
	 * @return int value auction item qty
	 */
	public function getItemQty() {
		return ($this->itemQty);
	}

	/**
	 * mutator method for auction item qty
	 *
	 * @param int $newItemQty auction item qty
	 * @throws InvalidArgumentException if $newItemQty is not an integer
	 * @throws RangeException if $newItemQty is not positive
	 */
	public function setItemQty($newItemQty) {
		// verify auction item qty is valid
		$newItemQty = filter_var($newItemQty, FILTER_VALIDATE_INT);
		if($newItemQty === false) {
			throw(new InvalidArgumentException("item qty is not a valid integer"));
		}

		// verify auction item qty is positive
		if($newItemQty <= 0) {
			throw(new RangeException("item qty is not positive"));
		}

		// convert and store auction item qty
		$this->itemQty = intval($newItemQty);
	}

	/**
	 * accessor method for return policy
	 *
	 * @return string value return policy
	 */
	public function getReturnPolicy() {
		return ($this->returnPolicy);
	}

	/**
	 * mutator method for return policy
	 *
	 * @param string $newReturnPolicy new return policy
	 * @throws InvalidArgumentException if $newReturnPolicy is not a string or insecure
	 * @throws RangeException if $newReturnPolicy is > 255 characters
	 */
	public function setReturnPolicy($newReturnPolicy) {
		// verify return policy is valid
		$newReturnPolicy = trim($newReturnPolicy);
		$newReturnPolicy = filter_var($newReturnPolicy, FILTER_SANITIZE_STRING);
		if(empty($newReturnPolicy) === true) {
			throw(new InvalidArgumentException("return policy is empty or insecure"));
		}

		// verify return policy does not exceed 255 characters
		if(strlen($newReturnPolicy) > 255) {
			throw(new RangeException("return policy is too large"));
		}

		// store return policy
		$this->returnPolicy = $newReturnPolicy;
	}

	/**
	 * accessor method for sold final price
	 *
	 * @return float value sold final price
	 */
	public function getSoldFinalPrice() {
		return ($this->soldFinalPrice);
	}

	/**
	 * mutator method for new sold final price
	 *
	 * @param float $newSoldFinalPrice new sold final price
	 * @throws InvalidArgumentException if $newSoldFinalPrice is not a float or insecure
	 * @throws RangeException if $newSoldFinalPrice is > 10 characters
	 */
	public function setSoldFinalPrice($newSoldFinalPrice) {
		// verify sold final price is valid
		$newSoldFinalPrice = filter_var($newSoldFinalPrice, FILTER_VALIDATE_FLOAT);
		if(empty($newSoldFinalPrice) === true) {
			throw(new InvalidArgumentException("final price amount is empty or insecure"));
		}

		// verify sold final price amount does not exceed 10 characters
		if(strlen($newSoldFinalPrice) > 10) {
			throw(new RangeException("final price amount too large"));
		}

		// store sold final price
		$this->soldFinalPrice = $newSoldFinalPrice;
	}

	/**
	 * accessor method for auction start datetime
	 *
	 * @return datetime value for auction start datetime
	 */
	public function getStartDateTime() {
		return ($this->startDateTime);
	}

	/**
	 * mutator method for auction start datetime
	 *
	 * @param mixed $newStartDateTime auction start date as a DateTime object or string (or null to load the current time)
	 * @throws InvalidArgumentException if $newStartDateTime is not a valid object or string
	 * @throws RangeException if $newStartDateTime is a date that does not exist
	 */
	public function setStartDateTime($newStartDateTime) {
		// base case: if the date is a DateTime object, there's no work to be done
		if(is_object($newStartDateTime) === true && get_class($newStartDateTime) === "DateTime") {
			$this->startDateTime = $newStartDateTime;
			return;
		}

		// treat the date as a mySQL date string: Y-m-d H:i:s
		$newStartDateTime = trim($newStartDateTime);
		if((preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $newStartDateTime, $matches)) !== 1) {
			throw(new InvalidArgumentException("auction start date is not a valid date"));
		}

		// verify the date is really a valid calendar date
		$year = intval($matches[1]);
		$month = intval($matches[2]);
		$day = intval($matches[3]);
		$hour = intval($matches[4]);
		$minute = intval($matches[5]);
		$second = intval($matches[6]);
		if(checkdate($month, $day, $year) === false) {
			throw(new RangeException("auction end date $newStartDateTime is not a Gregorian date"));
		}

		// verify the time is really a valid wall clock time
		if($hour < 0 || $hour >= 24 || $minute < 0 || $minute >= 60 || $second < 0 || $second >= 60) {
			throw(new RangeException("auction end date $newStartDateTime is not a valid time"));
		}

		// store the auction start date
		$newStartDateTime = DateTime::createFromFormat("Y-m-d H:i:s", $newStartDateTime);
		$this->startDateTime = $newStartDateTime;
	}

	/**
	 * inserts auction into mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function insert(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the auction id is null (i.e., don't insert an auction that already exists)
		if($this->auctionId !== null) {
			throw(new mysqli_sql_exception("auction already submitted for this auction"));
		}

		// create query template
		$query = "INSERT INTO auction(auctionTypeId, itemId, sellerMemberId, endDateTime, itemPhotoPath, itemQty, returnPolicy, soldFinalPrice, startDateTime) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the auction variables to the place holders in the template
		$formattedStartDate = $this->startDateTime->format("Y-m-d H:i:s");
		$formattedEndDate = $this->endDateTime->format("Y-m-d H:i:s");
		$wasClean = $statement->bind_param("iiissisds", $this->auctionTypeId, $this->itemId, $this->sellerMemberId, $formattedEndDate, $this->itemPhotoPath, $this->itemQty, $this->returnPolicy, $this->soldFinalPrice, $formattedStartDate);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("unable to execute mySQL statement: " . $statement->error));
		}

		// update the null auctionId with what mySQL just gave us
		$this->auctionId = $mysqli->insert_id;

		// clean up the statement
		$statement->close();
	}

	/**
	 * deletes auction from mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function delete(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the auctionId is not null (i.e., don't delete an auction that hasn't been inserted)
		if($this->auctionId === null) {
			throw(new mysqli_sql_exception("unable to delete an auction that does not exist"));
		}

		// create query template
		$query = "DELETE FROM auction WHERE auctionId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the auction variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->auctionId);
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
	 * updates an auction in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function update(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the auction is not null (i.e., don't update an auction that hasn't been inserted)
		if($this->auctionId === null) {
			throw(new mysqli_sql_exception("unable to update an auction that does not exist"));
		}

		// create query template
		$query = "UPDATE auction SET auctionTypeId = ?, itemId = ?, sellerMemberId = ?, endDateTime = ?, itemPhotoPath = ?, itemQty = ?, returnPolicy = ?, soldFinalPrice = ?, startDateTime = ? WHERE auctionId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the auction variables to the place holders in the template
		$wasClean = $statement->bind_param("iiissisds", $this->auctionTypeId, $this->itemId, $this->sellerMemberId, $this->endDateTime, $this->itemPhotoPath, $this->itemQty, $this->returnPolicy, $this->soldFinalPrice, $this->startDateTime);
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