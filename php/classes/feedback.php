<?php
/**
 * eBay member feedback information
 *
 * This is where member auction feedback is stored.
 *
 * @author Nick Lopez <nick@nicklopezcodes.com>
 */
class Feedback {
	/**
	 * id for feedback; this is the Primary Key
	 */
	private $feedbackId;
	/**
	 * id for auction being reviewed; this is a Foreign Key
	 */
	private $auctionId;
	/**
	 * id of member who created the review; this is a Foreign key
	 */
	private $memberId;
	/**
	 * full feedback description
	 */
	private $feedbackDescription;
	/**
	 * feedback rating, from 1 - 5
	 */
	private $rating;

	/**
	 * constructor for feedback
	 *
	 * @param mixed $newFeedbackId id for feedback
	 * @param int $newAuctionId id of auction being reviewed
	 * @param int $newMemberId id of member who created the feedback
	 * @param string $newFeedbackDescription full feedback description
	 * @param int $newRating feedback rating number from 1- 5
	 * @throws InvalidArgumentException if data types are invalid
	 * @throws RangeException if data values are out of bounds
	 */
	public function __construct($newFeedbackId, $newAuctionId, $newMemberId, $newFeedbackDescription, $newRating) {
		// use the mutators to do the work for us
		try {
			$this->setFeedbackId($newFeedbackId);
			$this->setAuctionId($newAuctionId);
			$this->setMemberId($newMemberId);
			$this->setFeedbackDescription($newFeedbackDescription);
			$this->setRating($newRating);
		} catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			// rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		}
	}

	/**
	 * accessor method for the feedback id
	 *
	 * @return int value of feedback id
	 */
	public function getFeedbackId() {
		return ($this->feedbackId);
	}

	/**
	 * mutator method for feedback id
	 *
	 * @param mixed $newFeedbackId new value of feedback id
	 * @throws InvalidArgumentException if $newFeedbackId is not an integer
	 * @throws RangeException if $newFeedbackId is not positive
	 */
	public function setFeedbackId($newFeedbackId) {
		// If feedback id is null, it is a new primary key value
		if($newFeedbackId === null) {
			$this->feedbackId = null;
			return;
		}

		// verify feedback id is valid
		$newFeedbackId = filter_var($newFeedbackId, FILTER_VALIDATE_INT);
		if($newFeedbackId === false) {
			throw(new InvalidArgumentException("feedback id is not a valid integer"));
		}

		// verify feedback id is positive
		if($newFeedbackId <= 0) {
			throw(new RangeException("feedback id is not positive"));
		}

		// convert and store feedback id
		$this->feedbackId = intval($newFeedbackId);
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
	 * accessor method for member id
	 *
	 * @return int value member id
	 */
	public function getMemberId() {
		return ($this->memberId);
	}

	/**
	 * mutator method for member id
	 *
	 * @param int $newMemberId member id
	 * @throws InvalidArgumentException if $newMemberId is not an integer
	 * @throws RangeException if $newMemberId is not positive
	 */
	public function setMemberId($newMemberId) {
		// verify member id is valid
		$newMemberId = filter_var($newMemberId, FILTER_VALIDATE_INT);
		if($newMemberId === false) {
			throw(new InvalidArgumentException("member id is not a valid integer"));
		}

		// verify member id is positive
		if($newMemberId <= 0) {
			throw(new RangeException("member id is not positive"));
		}

		// convert and store member id
		$this->memberId = intval($newMemberId);
	}

	/**
	 * accessor method for feedback description
	 *
	 * @return string value feedback description
	 */
	public function getFeedbackDescription() {
		return ($this->feedbackDescription);
	}

	/**
	 * mutator method for new feedback description
	 *
	 * @param string $newFeedbackDescription new feedback description
	 * @throws InvalidArgumentException if $newFeedbackDescription is not a string or insecure
	 * @throws RangeException if $newFeedbackDescription is > 60 characters
	 */
	public function setFeedbackDescription($newFeedbackDescription) {
		// verify feedback description is valid
		$newFeedbackDescription = trim($newFeedbackDescription);
		$newFeedbackDescription = filter_var($newFeedbackDescription, FILTER_SANITIZE_STRING);
		if(empty($newFeedbackDescription) === true) {
			throw(new InvalidArgumentException("feedback description content is empty or insecure"));
		}

		// verify feedback description does not exceed 60 characters
		if(strlen($newFeedbackDescription) > 60) {
			throw(new RangeException("feedback description content too large"));
		}

		// store feedback description
		$this->feedbackDescription = $newFeedbackDescription;
	}

	/**
	 * accessor method for rating
	 *
	 * @return int value for rating
	 */
	public function getRatingId() {
		return ($this->rating);
	}

	/**
	 * mutator method for rating
	 *
	 * @param int $newRating auction and seller rating
	 * @throws InvalidArgumentException if $newRating is not an integer
	 * @throws RangeException if $newRating is not positive
	 */
	public function setRating($newRating) {
		// verify rating is valid
		$newRating = filter_var($newRating, FILTER_VALIDATE_INT);
		if($newRating === false) {
			throw(new InvalidArgumentException("rating is not a valid integer"));
		}

		// verify rating is positive
		if($newRating <= 0) {
			throw(new RangeException("rating is not positive"));
		}

		// convert and store rating
		$this->rating = intval($newRating);
	}

	/**
	 * inserts feedback into mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function insert(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the feedback is null (i.e., don't insert feedback that already exists)
		if($this->feedbackId !== null) {
			throw(new mysqli_sql_exception("feedback already been submitted for this auction"));
		}

		// create query template
		$query = "INSERT INTO feedback(auctionId, memberId, feedbackDescription, rating) VALUES( ?, ?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the feedback variables to the place holders in the template
		$wasClean = $statement->bind_param("iisi", $this->auctionId, $this->memberId, $this->feedbackDescription, $this->rating);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("unable to execute mySQL statement: " . $statement->error));
		}

		// update the null feedbackId with what mySQL just gave us
		$this->feedbackId = $mysqli->insert_id;

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

		// enforce the feedbackId is not null (i.e., don't delete feedback that hasn't been inserted)
		if($this->feedbackId === null) {
			throw(new mysqli_sql_exception("unable to delete feedback that does not exist"));
		}

		// create query template
		$query = "DELETE FROM feedback WHERE feedbackId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the feedback variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->feedbackId);
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
	 * updates feedback in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function update(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the feedback is not null (i.e., don't update feedback that hasn't been inserted)
		if($this->feedbackId === null) {
			throw(new mysqli_sql_exception("unable to update feedback that does not exist"));
		}

		// create query template
		$query = "UPDATE feedback SET auctionId = ?, memberId = ?, feedbackDescription = ?, rating = ? WHERE feedbackId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the feedback variables to the place holders in the template
		$wasClean = $statement->bind_param("iisii", $this->auctionId, $this->memberId, $this->feedbackDescription, $this->rating, $this->feedbackId);
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