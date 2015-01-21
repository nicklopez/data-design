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
	userName VARCHAR(25),
	firstName VARCHAR(25),
	lastName VARCHAR(25),
	PRIMARY KEY (memberId)
);

CREATE TABLE item (
	itemId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	itemDescription TEXT,
	itemBrand VARCHAR(50),
	itemModel VARCHAR(50),
	PRIMARY KEY (itemId)
);

CREATE TABLE auction (
	auctionId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	itemId INT UNSIGNED NOT NULL,
	auctionTypeId INT UNSIGNED NOT NULL,
	sellerMemberId INT UNSIGNED NOT NULL,
	itemQty INT UNSIGNED NOT NULL,
	soldFinalPrice DECIMAL(10,2) UNSIGNED NOT NULL,
	itemPhotoPath VARCHAR(255),
	returnPolicy VARCHAR(255),
	startDateTime DATETIME,
	endDateTime DATETIME,
	INDEX (itemId),
	INDEX (auctionTypeId),
	INDEX (sellerMemberId),
	FOREIGN KEY (itemId) REFERENCES item (itemId),
	FOREIGN KEY (auctionTypeId) REFERENCES auctionType (auctionTypeId),
	FOREIGN KEY (sellerMemberId) REFERENCES member (memberId),
	PRIMARY KEY (auctionId)
);

CREATE TABLE feedback (
	feedbackId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	memberId INT UNSIGNED NOT NULL,
	auctionId INT UNSIGNED NOT NULL,
	feedbackDescription VARCHAR(60) NOT NULL,
	rating TINYINT UNSIGNED NOT NULL,
	INDEX (memberId),
	INDEX (auctionId),
	FOREIGN KEY (memberId) REFERENCES member (memberId),
	FOREIGN KEY (auctionId) REFERENCES auction (auctionId),
	PRIMARY KEY (feedbackId)
);

CREATE TABLE bid (
	bidId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	auctionId INT UNSIGNED NOT NULL,
	bidderMemberId INT UNSIGNED NOT NULL,
	bidDollarAmount DECIMAL(10,2) NOT NULL,
	bidDateTime DATETIME NOT NULL,
	INDEX (auctionId),
	INDEX (bidderMemberId),
	FOREIGN KEY (auctionId) REFERENCES auction (auctionId),
	FOREIGN KEY (bidderMemberId) REFERENCES member (memberId),
	PRIMARY KEY (bidId)
);


