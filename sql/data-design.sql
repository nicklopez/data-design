-- Drop existing tables
DROP TABLE IF EXISTS bid;
DROP TABLE IF EXISTS feedback;
DROP TABLE IF EXISTS auction;
DROP TABLE IF EXISTS item;
DROP TABLE IF EXISTS member;
DROP TABLE IF EXISTS auctionType;

-- Create the tables
CREATE TABLE auctionType (
	auctionTypeId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	auctionTypeDesc VARCHAR(10),
	PRIMARY KEY (auctionTypeId)
);

CREATE TABLE member (
	memberId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	firstName VARCHAR(25),
	lastName VARCHAR(25),
	userName	VARCHAR(25) UNIQUE,
	PRIMARY KEY (memberId)
);

CREATE TABLE item (
	itemId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	itemBrand VARCHAR(50),
	itemDescription TEXT,
	itemModel VARCHAR(50),
	PRIMARY KEY (itemId)
);

CREATE TABLE auction (
	auctionId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	auctionTypeId INT UNSIGNED NOT NULL,
	itemId INT UNSIGNED NOT NULL,
	sellerMemberId INT UNSIGNED NOT NULL,
	endDateTime DATETIME,
	itemPhotoPath VARCHAR(255),
	itemQty INT UNSIGNED NOT NULL,
	returnPolicy VARCHAR(255),
	soldFinalPrice DECIMAL(10,2) UNSIGNED NOT NULL,
	startDateTime DATETIME,
	INDEX (auctionTypeId),
	INDEX (itemId),
	INDEX (sellerMemberId),
	FOREIGN KEY (auctionTypeId) REFERENCES auctionType (auctionTypeId),
	FOREIGN KEY (itemId) REFERENCES item (itemId),
	FOREIGN KEY (sellerMemberId) REFERENCES member (memberId),
	PRIMARY KEY (auctionId)
);

CREATE TABLE feedback (
	feedbackId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	auctionId INT UNSIGNED NOT NULL,
	memberId INT UNSIGNED NOT NULL,
	feedbackDescription VARCHAR(60) NOT NULL,
	rating TINYINT UNSIGNED NOT NULL,
	INDEX (auctionId),
	INDEX (memberId),
	FOREIGN KEY (auctionId) REFERENCES auction (auctionId),
	FOREIGN KEY (memberId) REFERENCES member (memberId),
	PRIMARY KEY (feedbackId)
);

CREATE TABLE bid (
	bidId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	auctionId INT UNSIGNED NOT NULL,
	bidderMemberId INT UNSIGNED NOT NULL,
	bidDateTime DATETIME NOT NULL,
	bidDollarAmount DECIMAL(10,2) NOT NULL,
	INDEX (auctionId),
	INDEX (bidderMemberId),
	FOREIGN KEY (auctionId) REFERENCES auction (auctionId),
	FOREIGN KEY (bidderMemberId) REFERENCES member (memberId),
	PRIMARY KEY (bidId)
);


