<?php
/**
 * eBay bid information
 *
 * This is where auction bids are stored.
 *
 * @author Nick Lopez <nick@nicklopezcodes.com>
 */
class Bid {
	/**
	 * id for bid; this is the Primary Key
	 */
	private $bidId;
	/**
	 * id for auction; this is a Foreign Key
	 */
	private $auctionId;
	/**
	 * id of member who created a bid; this is a Foreign key
	 */
	private $bidderMemberId;
	/**
	 * date & time bid was placed
	 */
	private $bidDateTime;
	/**
	 * bid dollar amount
	 */
	private $bidDollarAmount;

	/**
	 * constructor for bid
	 *
	 * @param mixed $newBidId id for new bid
	 * @param int $newAuctionId id of auction for submitted bids
	 * @param int $newBidderMemberId id of member who placed a bid
	 * @param datetime $newBidDateTime date & time bid was placed
	 * @param float $newBidDollarAmount bid dollar amount
	 * @throws InvalidArgumentException if data types are invalid
	 * @throws RangeException if data values are out of bounds
	 */
	public function __construct($newBidId, $newAuctionId, $newBidderMemberId, $newBidDateTime = NULL, $newBidDollarAmount) {
		// use the mutators to do the work for us
		try {
			$this->setBidId($newBidId);
			$this->setAuctionId($newAuctionId);
			$this->setBidderMemberId($newBidderMemberId);
			$this->setBidDateTime($newBidDateTime);
			$this->setBidDollarAmount($newBidDollarAmount);
		} catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			// rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		}
	}

	/**
	 * accessor method for the bid id
	 *
	 * @return int value of bid id
	 */
	public function getBidId() {
		return ($this->bidId);
	}

	/**
	 * mutator method for bid id
	 *
	 * @param mixed $newBidId new value of bid id
	 * @throws InvalidArgumentException if $newBidId is not an integer
	 * @throws RangeException if $newBidId is not positive
	 */
	public function setBidId($newBidId) {
		// If $newBidId id is null, it is a new primary key value
		if($newBidId === null) {
			$this->bidId = null;
			return;
		}

		// verify bid id is valid
		$newBidId = filter_var($newBidId, FILTER_VALIDATE_INT);
		if($newBidId === false) {
			throw(new InvalidArgumentException("bid id is not a valid integer"));
		}

		// verify bid id is positive
		if($newBidId <= 0) {
			throw(new RangeException("bid id is not positive"));
		}

		// convert and store bid id
		$this->bidId = intval($newBidId);
	}

	/**
	 * accessor method for auction id
	 *
	 * @return int value auction id
	 */
	public function getAuctionId() {
		return ($this->auctionId);
	}

	/**
	 * mutator method for auction id
	 *
	 * @param int $newAuctionId auction id
	 * @throws InvalidArgumentException if $newAuctionId is not an integer
	 * @throws RangeException if $newAuctionId is not positive
	 */
	public function setAuctionId($newAuctionId) {
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
	 * accessor method for bidder member id
	 *
	 * @return int value bidder member id
	 */
	public function getBidderMemberId() {
		return ($this->bidderMemberId);
	}

	/**
	 * mutator method for bidder member id
	 *
	 * @param int $newBidderMemberId bidder member id
	 * @throws InvalidArgumentException if $newBidderMemberId is not an integer
	 * @throws RangeException if $newBidderMemberId is not positive
	 */
	public function setBidderMemberId($newBidderMemberId) {
		// verify bidder member id is valid
		$newBidderMemberId = filter_var($newBidderMemberId, FILTER_VALIDATE_INT);
		if($newBidderMemberId === false) {
			throw(new InvalidArgumentException("bidder member id is not a valid integer"));
		}

		// verify bidder member id is positive
		if($newBidderMemberId <= 0) {
			throw(new RangeException("bidder member id is not positive"));
		}

		// convert and store bidder member id
		$this->bidderMemberId = intval($newBidderMemberId);
	}

	/**
	 * accessor method for bid datetime
	 *
	 * @return datetime value for bid datetime
	 */
	public function getBidDateTime() {
		return ($this->bidDateTime);
	}

	/**
	 * mutator method for bid datetime
	 *
	 * @param mixed $newBidDateTime bid date as a DateTime object or string (or null to load the current time)
	 * @throws InvalidArgumentException if $newBidDateTime is not a valid object or string
	 * @throws RangeException if $newBidDateTime is a date that does not exist
	 */
	public function setBidDateTime($newBidDateTime) {
		// base case: if the date is null, use the current date and time
		if($newBidDateTime === null) {
			$this->bidDateTime = new DateTime();
			return;
		}

		// base case: if the date is a DateTime object, there's no work to be done
		if(is_object($newBidDateTime) === true && get_class($newBidDateTime) === "DateTime") {
			$this->bidDateTime = $newBidDateTime;
			return;
		}

		// treat the date as a mySQL date string: Y-m-d H:i:s
		$newBidDateTime = trim($newBidDateTime);
		if((preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $newBidDateTime, $matches)) !== 1) {
			throw(new InvalidArgumentException("bid date is not a valid date"));
		}

		// verify the date is really a valid calendar date
		$year = intval($matches[1]);
		$month = intval($matches[2]);
		$day = intval($matches[3]);
		$hour = intval($matches[4]);
		$minute = intval($matches[5]);
		$second = intval($matches[6]);
		if(checkdate($month, $day, $year) === false) {
			throw(new RangeException("bid date $newBidDateTime is not a Gregorian date"));
		}

		// verify the time is really a valid wall clock time
		if($hour < 0 || $hour >= 24 || $minute < 0 || $minute >= 60 || $second < 0 || $second >= 60) {
			throw(new RangeException("bid date $newBidDateTime is not a valid time"));
		}

		// store the bid date
		$newBidDateTime = DateTime::createFromFormat("Y-m-d H:i:s", $newBidDateTime);
		$this->bidDateTime = $newBidDateTime;
	}
	/**
	 * accessor method for bid dollar amount
	 *
	 * @return float value bid dollar amount
	 */
	public function getBidDollarAmount() {
		return ($this->bidDollarAmount);
	}

	/**
	 * mutator method for new bid dollar amount
	 *
	 * @param float $newBidDollarAmount new bid dollar amount
	 * @throws InvalidArgumentException if $newBidDollarAmount is not a float or insecure
	 * @throws RangeException if $newBidDollarAmount is > 10 characters
	 */
	public function setBidDollarAmount($newBidDollarAmount) {
		// verify bid dollar amount is valid
		$newBidDollarAmount = filter_var($newBidDollarAmount, FILTER_VALIDATE_FLOAT);
		if(empty($newBidDollarAmount) === true) {
			throw(new InvalidArgumentException("bid dollar amount is empty or insecure"));
		}

		// verify bid dollar amount does not exceed 10 characters
		if(strlen($newBidDollarAmount) > 10) {
			throw(new RangeException("bid dollar amount too large"));
		}

		// store bid dollar amount
		$this->bidDollarAmount = $newBidDollarAmount;
	}

	/**
	 * inserts bid into mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function insert(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the bid id is null (i.e., don't insert a bid that already exists)
		if($this->bidId !== null) {
			throw(new mysqli_sql_exception("bid already submitted for this auction"));
		}

		// create query template
		$query = "INSERT INTO bid(auctionId, bidderMemberId, bidDateTime, bidDollarAmount) VALUES(?, ?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the bid variables to the place holders in the template
		$formattedDate = $this->bidDateTime->format("Y-m-d H:i:s");
		$wasClean = $statement->bind_param("iisd", $this->auctionId, $this->bidderMemberId, $formattedDate, $this->bidDollarAmount);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("unable to execute mySQL statement: " . $statement->error));
		}

		// update the null bidId with what mySQL just gave us
		$this->bidId = $mysqli->insert_id;

		// clean up the statement
		$statement->close();
	}

	/**
	 * deletes feedback from mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function delete(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the bidId is not null (i.e., don't delete a bid that hasn't been inserted)
		if($this->bidId === null) {
			throw(new mysqli_sql_exception("unable to delete bid that does not exist"));
		}

		// create query template
		$query = "DELETE FROM bid WHERE bidId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the bid variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->bidId);
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
	 * updates a bid in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function update(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the bid is not null (i.e., don't update a bid that hasn't been inserted)
		if($this->bidId === null) {
			throw(new mysqli_sql_exception("unable to update a bid that does not exist"));
		}

		// create query template
		$query = "UPDATE bid SET auctionId = ?, bidderMemberId = ?, bidDateTime = ?, bidDollarAmount = ? WHERE bidId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the bid variables to the place holders in the template
		$formattedDate = $this->bidDateTime->format("Y-m-d H:i:s");
		$wasClean = $statement->bind_param("iisdi", $this->auctionId, $this->bidderMemberId, $formattedDate, $this->bidDollarAmount, $this->bidId);
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
	 * gets the bid by bidId
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param int $bidId feedback content to search for
	 * @return mixed bid found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public static function getBidByBidId(&$mysqli, $bidId) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize the bidId before searching
		$bidId = filter_var($bidId, FILTER_VALIDATE_INT);
		if($bidId === false) {
			throw(new mysqli_sql_exception("bid id is not an integer"));
		}
		if($bidId <= 0) {
			throw(new mysqli_sql_exception("bid id is not positive"));
		}

		// create query template
		$query	 = "SELECT bidId, auctionId, bidderMemberId, bidDateTime, bidDollarAmount FROM bid WHERE bidId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the bid id to the place holder in the template
		$wasClean = $statement->bind_param("i", $bidId);
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

		// grab bid from mySQL
		try {
			$bid = null;
			$row   = $result->fetch_assoc();
			if($row !== null) {
				$bid = new Bid($row["bidId"], $row["auctionId"], $row["bidderMemberId"], $row["bidDateTime"], $row["bidDollarAmount"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new mysqli_sql_exception($exception->getMessage(), 0, $exception));
		}

		// free up memory and return the result
		$result->free();
		$statement->close();
		return($bid);
	}
}
?>