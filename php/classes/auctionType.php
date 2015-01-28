<?php
/**
 * eBay Auction Type information
 *
 * This is a master list of all auction types available for an eBay listing.
 *
 * @author Nick Lopez <nick@nicklopezcodes.com>
 */
class AuctionType {
	/**
	 * id for auction type; this is the Primary Key
	 */
	private $auctionTypeId;
	/**
	 * auction type description
	 */
	private $auctionTypeDesc;

	/**
	 * constructor for auction type
	 *
	 * @param mixed $newAuctionTypeId auction type id
	 * @param string $newAuctionTypeDesc description of auction type
	 * @throws InvalidArgumentException if data types are invalid
	 * @throws RangeException if data values are out of bounds
	 */
	public function __construct($newAuctionTypeId, $newAuctionTypeDesc) {
		// use the mutators to do the work for us
		try {
			$this->setAuctionTypeId($newAuctionTypeId);
			$this->setAuctionTypeDesc($newAuctionTypeDesc);
		} catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			// rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		}
	}

	/**
	 * accessor method for the auction type id
	 *
	 * @return int value of auction type id
	 */
	public function getAuctionTypeId() {
		return ($this->auctionTypeId);
	}

	/**
	 * mutator method for auction type id
	 *
	 * @param mixed $newAuctionTypeId new value of auction type id
	 * @throws InvalidArgumentException if $newAuctionTypeId is not an integer
	 * @throws RangeException if $newAuctionTypeId is not positive
	 */
	public function setAuctionTypeId($newAuctionTypeId) {
		// If auction type id is null, it is a new primary key value
		if($newAuctionTypeId === null) {
			$this->auctionTypeId = null;
			return;
		}

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
	 * accessor method for auction type description
	 *
	 * @return string value auction type description
	 */
	public function getAuctionTypeDesc() {
		return ($this->auctionTypeDesc);
	}

	/**
	 * mutator method for auction type description
	 *
	 * @param string $newAuctionTypeDesc new auction type description
	 * @throws InvalidArgumentException if $newAuctionTypeDesc is not a string or insecure
	 * @throws RangeException if $newAuctionTypeDesc is > 10 characters
	 */
	public function setAuctionTypeDesc($newAuctionTypeDesc) {
		// verify auction type description is valid
		$newAuctionTypeDesc = trim($newAuctionTypeDesc);
		$newAuctionTypeDesc = filter_var($newAuctionTypeDesc, FILTER_SANITIZE_STRING);
		if(empty($newAuctionTypeDesc) === true) {
			throw(new InvalidArgumentException("auction type description content is empty or insecure"));
		}

		// verify auction type description does not exceed 10 characters
		if(strlen($newAuctionTypeDesc) > 10) {
			throw(new RangeException("auction type description content too large"));
		}

		// store auction type description
		$this->auctionTypeDesc = $newAuctionTypeDesc;
	}

	/**
	 * inserts auction type into mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function insert(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the auctionTypeId is null (i.e., don't insert an auction type that already exists)
		if($this->auctionTypeId !== null) {
			throw(new mysqli_sql_exception("not a new auction type"));
		}

		// create query template
		$query = "INSERT INTO auctionType(auctionTypeDesc) VALUES(?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the auction type variables to the place holders in the template
		$wasClean = $statement->bind_param("s", $this->auctionTypeDesc);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("unable to execute mySQL statement: " . $statement->error));
		}

		// update the null auctionTypeId with what mySQL just gave us
		$this->auctionTypeId = $mysqli->insert_id;

		// clean up the statement
		$statement->close();
	}

	/**
	 * deletes an auction type from mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function delete(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the auctionTypeId is not null (i.e., don't delete an auction type that hasn't been inserted)
		if($this->auctionTypeId === null) {
			throw(new mysqli_sql_exception("unable to delete an auction type that does not exist"));
		}

		// create query template
		$query = "DELETE FROM auctionType WHERE auctionTypeId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the auction type variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->auctionTypeId);
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
	 * updates an auction type in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function update(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the auctionTypeId is not null (i.e., don't update an auction type that hasn't been inserted)
		if($this->auctionTypeId === null) {
			throw(new mysqli_sql_exception("unable to update an auction type that does not exist"));
		}

		// create query template
		$query = "UPDATE auctionType SET auctionTypeDesc = ? WHERE auctionTypeId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the auction type variables to the place holders in the template
		$wasClean = $statement->bind_param("si", $this->auctionTypeDesc, $this->auctionTypeId);
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
	 * gets the auctionType by auctionTypeId
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param int $auctionTypeId auction type content to search for
	 * @return mixed auctionType found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public static function getAuctionTypeByAuctionTypeId(&$mysqli, $auctionTypeId) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize the auctionTypeId before searching
		$auctionTypeId = filter_var($auctionTypeId, FILTER_VALIDATE_INT);
		if($auctionTypeId === false) {
			throw(new mysqli_sql_exception("auctionType id is not an integer"));
		}
		if($auctionTypeId <= 0) {
			throw(new mysqli_sql_exception("auctionType id is not positive"));
		}

		// create query template
		$query	 = "SELECT auctionTypeId, auctionTypeDesc FROM auctionType WHERE auctionTypeId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the auctionType id to the place holder in the template
		$wasClean = $statement->bind_param("i", $auctionTypeId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("unable to execute mySQL statement: " . $statement->error));
		}

		// get result from the SELECT query
		$result = $statement->get_result();
		if($result === false) {
			throw(new mysqli_sql_exception("unable to get result set"));
		}

		// grab auctionType from mySQL
		try {
			$auctionType = null;
			$row   = $result->fetch_assoc();
			if($row !== null) {
				$auctionType = new auctionType($row["auctionTypeId"], $row["auctionTypeDesc"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new mysqli_sql_exception($exception->getMessage(), 0, $exception));
		}

		// free up memory and return the result
		$result->free();
		$statement->close();
		return($auctionType);
	}
}
?>