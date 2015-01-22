<?php
/**
 * eBay Member information
 *
 * This is where the end users full name and username information is stored.
 *
 * @author Nick Lopez <nick@nicklopezcodes.com>
 */
class Member {
	/**
	 * id for member; this is the Primary Key
	 */
	private $memberId;
	/**
	 * first name of the end user
	 */
	private $firstName;
	/**
	 * last name of the end user
	 */
	private $lastName;
	/**
	 * username of the end user
	 */
	private $userName;

	/**
	 * constructor for member
	 *
	 * @param mixed $newMemberId member id of the user
	 * @param string $newFirstName first name of the user
	 * @param string $newLastName last name of the user
	 * @param string $newUserName username of the user
	 * @throws InvalidArgumentException if data types are invalid
	 * @throws RangeException if data values are out of bounds
	 */

	public function __construct($newMemberId, $newFirstName, $newLastName, $newUserName) {
		// use the mutators to do the work for us
		try {
			$this->setMemberId($newMemberId);
			$this->setFirstName($newFirstName);
			$this->setLastName($newLastName);
			$this->setUserName($newUserName);
		} catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			// rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		}
	}

	/**
	 * accessor method for the member id
	 *
	 * @return int value of member id
	 */
	public function getMemberId() {
		return ($this->memberId);
	}

	/**
	 * mutator method for member id
	 *
	 * @param mixed $newMemberId new value of member id
	 * @throws InvalidArgumentException if $newMemberId is not an integer
	 * @throws RangeException if $newMemberId is not positive
	 */


	public function setMemberId($newMemberId) {
		// If member id is null, it is a new primary key value
		if($newMemberId === null) {
			$this->memberId = null;
			return;
		}

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
	 * accessor method for first name of user
	 *
	 * @return string value first name of user
	 */
	public function getFirstName() {
		return ($this->firstName);
	}

	/**
	 * mutator method for new first name
	 *
	 * @param string $newFirstName new first name of user
	 * @throws InvalidArgumentException if $newFirstName is not a string or insecure
	 * @throws RangeException if $newFirstName is > 25 characters
	 */

	public function setFirstName($newFirstName) {
		// verify first name is valid
		$newFirstName = trim($newFirstName);
		$newFirstName = filter_var($newFirstName, FILTER_SANITIZE_STRING);
		if(empty($newFirstName) === true) {
			throw(new InvalidArgumentException("first name content is empty or insecure"));
		}

		// verify first name does not exceed 25 characters
		if(strlen($newFirstName) > 25) {
			throw(new RangeException("first name content too large"));
		}

		// store first name
		$this->firstName = $newFirstName;
	}

	/**
	 * accessor method for last name of user
	 *
	 * @return string value last name of user
	 */
	public function getLastName() {
		return ($this->lastName);
	}

	/**
	 * mutator method for new last name
	 *
	 * @param string $newLastName new last name of user
	 * @throws InvalidArgumentException if $newLastName is not a string or insecure
	 * @throws RangeException if $newLastName is > 25 characters
	 */

	public function setLastName($newLastName) {
		//verify last name is valid
		$newLastName = trim($newLastName);
		$newLastName = filter_var($newLastName, FILTER_SANITIZE_STRING);
		if(empty($newLastName) === true) {
			throw(new InvalidArgumentException("last name content is empty or insecure"));
		}

		// verify last name does not exceed 25 characters
		if(strlen($newLastName) > 25) {
			throw(new RangeException("last name content too large"));
		}

		// store last name
		$this->lastName = $newLastName;
	}

	/**
	 * accessor method for username of user
	 *
	 * @return string value username of user
	 */
	public function getUserName() {
		return ($this->userName);
	}

	/**
	 * mutator method for new username
	 *
	 * @param string $newUserName new username of user
	 * @throws InvalidArgumentException if $newUserName is not a string or insecure
	 * @throws RangeException if $newUserName is > 25 characters
	 */

	public function setUserName($newUserName) {
		// verify username is valid
		$newUserName = trim($newUserName);
		$newUserName = filter_var($newUserName, FILTER_SANITIZE_STRING);
		if(empty($newUserName) === true) {
			throw(new InvalidArgumentException("username content is empty or insecure"));
		}

		// verify username does not exceed 25 characters
		if(strlen($newUserName) > 25) {
			throw(new RangeException("username content too large"));
		}

		// store username
		$this->userName = $newUserName;
	}

	/**
	 * inserts member into mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function insert(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the memberId is null (i.e., don't insert a member that already exists)
		if($this->memberId !== null) {
			throw(new mysqli_sql_exception("not a new member"));
		}

		// create query template
		$query = "INSERT INTO member(firstName, lastName, userName) VALUES(?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("sss", $this->firstName, $this->lastName, $this->userName);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("unable to execute mySQL statement: " . $statement->error));
		}

		// update the null memberId with what mySQL just gave us
		$this->memberId = $mysqli->insert_id;

		// clean up the statement
		$statement->close();
	}

	/**
	 * deletes a member from mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function delete(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the memberId is not null (i.e., don't delete a member that hasn't been inserted)
		if($this->memberId === null) {
			throw(new mysqli_sql_exception("unable to delete a member that does not exist"));
		}

		// create query template
		$query = "DELETE FROM member WHERE memberId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the member variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->memberId);
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
	 * updates a member in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function update(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the memberId is not null (i.e., don't update a member that hasn't been inserted)
		if($this->memberId === null) {
			throw(new mysqli_sql_exception("unable to update a member that does not exist"));
		}

		// create query template
		$query = "UPDATE member SET firstName = ?, lastName = ?, userName = ? WHERE memberId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("sssi", $this->firstName, $this->lastName, $this->userName, $this->memberId);
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