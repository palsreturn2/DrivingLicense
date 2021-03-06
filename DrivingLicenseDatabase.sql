SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS Applications;
DROP TABLE IF EXISTS Employee;
DROP TABLE IF EXISTS FileUploads;
DROP TABLE IF EXISTS LoginDetails;
DROP TABLE IF EXISTS MotorTrainingSchool;
DROP TABLE IF EXISTS Question;
DROP TABLE IF EXISTS RegionalTrainingOffice;
DROP TABLE IF EXISTS RTORegistration;
DROP TABLE IF EXISTS Slot;
DROP TABLE IF EXISTS testtopics;

CREATE TABLE applications
(
	ID INT PRIMARY KEY AUTO_INCREMENT,
	TIMESTAMP TIMESTAMP NOT NULL,
	FIRSTNAME VARCHAR(30) NULL,
	LASTNAME VARCHAR(30) NULL,
	DATEOFBIRTH DATE NULL,
	FATHER_NAME VARCHAR(255) NULL,
	BLOODGROUP VARCHAR(3) NULL,
	ADHAARNUMBER VARCHAR(20) NULL,
	EDUCATIONALQUALIFICATIONS VARCHAR(40) NULL,
	IDENTIFICATIONMARK VARCHAR(50) NULL,
	EMAIL VARCHAR(50) NULL,
	MOBILE VARCHAR(20) NULL,
	TELEPHONE VARCHAR(50) NULL,
	TEMPSTREET VARCHAR(50) NULL,
	TEMPCITY VARCHAR(50) NULL,
	TEMPSTATE VARCHAR(50) NULL,
	TEMPPINCODE INT NULL,
	PERSTREET VARCHAR(50) NULL,
	PERCITY VARCHAR(50) NULL,
	PERSTATE VARCHAR(50) NULL,
	PERPINCODE INTEGER NULL,
	EFFECTIVE_LICENSE VARCHAR(50) NULL,
	EFFECTIVE_LICENSE_VALIDITY VARCHAR(50) NULL,
	PREVIOUS_LICENSE VARCHAR(3) NULL,
	PREVIOUS_LICENSE_NUMBER VARCHAR(50) NULL,
	EVER_DISQUALIFIED VARCHAR(10) NULL,
	DISQUALIFICATION_REASON VARCHAR(500) NULL,
	APPLY_FOR_LICENSE VARCHAR(50) NULL,
	STATUS VARCHAR(50) NOT NULL,
	SLOT_STATUS VARCHAR(50) NULL,
	ATTEMPT INT NULL,
	KNOWLEDGE_TEST_RESULTS INT NULL,
	SKILL_TEST_RESULTS INT NULL,
	USER_UPDATE_TIME TIMESTAMP NULL,
	VISITING_RTO_ID INT NULL,
	USER_ID INT NOT NULL
);


CREATE TABLE employee
(
	ID INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	RTO_ID INTEGER NOT NULL,
	DESIGNATION INTEGER NOT NULL,
	DATE_OF_JOINING DATE NOT NULL,
	NAME VARCHAR(50) NOT NULL
) ;


CREATE TABLE fileuploads
(
	ID INT NOT NULL AUTO_INCREMENT,
	APPLICATION_ID INT NOT NULL,
	PHOTO_NAME VARCHAR(50) NOT NULL,
	PHOTO_TYPE VARCHAR(50) NOT NULL,
	PHOTO_SIZE INT NOT NULL,
	PHOTO_CONTENT MEDIUMBLOB NOT NULL,
	SIGNATURE_NAME VARCHAR(50) NOT NULL,
	SIGNATURE_TYPE VARCHAR(50) NOT NULL,
	SIGNATURE_SIZE INT NOT NULL,
	SIGNATURE_CONTENT MEDIUMBLOB NOT NULL,
	IDPROOF_NAME VARCHAR(50) NOT NULL,
	IDPROOF_TYPE VARCHAR(50) NOT NULL,
	IDPROOF_SIZE INT NOT NULL,
	IDPROOF_CONTENT MEDIUMBLOB NOT NULL,
	ADDRESS_PROOF_NAME VARCHAR(50) NOT NULL,
	ADDRESS_PROOF_TYPE VARCHAR(50) NOT NULL,	
	ADDRESS_PROOF_SIZE INT NOT NULL,
	ADDRESS_PROOF_CONTENT MEDIUMBLOB NOT NULL,
	PRIMARY KEY (ID)

) ;


CREATE TABLE logindetails
(
	ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	NAME VARCHAR(255) NOT NULL,
	EMAIL VARCHAR(255) NOT NULL,
	PHONENO VARCHAR(12) NOT NULL,
	ROLE VARCHAR(10) NOT NULL,
	USERNAME VARCHAR(50) NOT NULL,
	PASSWORD VARCHAR(255) NOT NULL,
	RTO_ID INT NULL
) ;


CREATE TABLE motortrainingschool
(
	ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	CAPACITY INT NOT NULL,
	NAME INT NOT NULL,
	LOCATION VARCHAR(100) NOT NULL,
	CONCERNED_PERSON VARCHAR(50) NOT NULL,
	NO_OF_VEHICLES INT NOT NULL,
	NO_OF_TRAINERS BIGINT NOT NULL,
	RTO_ID INT NULL
) ;


CREATE TABLE question
(
	ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	FILENAME VARCHAR(255) NULL,	
	FILESIZE INT NULL,
	QUESTION VARCHAR(255) NOT NULL,
	OPTION1 VARCHAR(50) NOT NULL,
	OPTION2 VARCHAR(50) NOT NULL,
	OPTION3 VARCHAR(50) NOT NULL,
	OPTION4 VARCHAR(50) NOT NULL,
	ANSWER VARCHAR(50) NOT NULL,
	TOPIC_ID INT NOT NULL
) ;


CREATE TABLE regionaltrainingoffice
(
	ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	NAME VARCHAR(100) NOT NULL,
	LOCATION VARCHAR(100) NOT NULL,
	CONCERNED_PERSON VARCHAR(50) NOT NULL,
	TOTAL_EMPLOYEES INT NOT NULL,
	APPLICATIONS_CAPACITY INT NOT NULL,
	TOTAL_VEHICLES INT NOT NULL,
	TOTAL_SYSTEMS INT NOT NULL,
	USER_ID INT NOT NULL
) ;


CREATE TABLE rtoregistration
(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL,
	location VARCHAR(100) NOT NULL,
	username VARCHAR(50) NOT NULL,
	hashedpw VARCHAR(255) NOT NULL,
	original_pw VARCHAR(255) NOT NULL

) ;


CREATE TABLE slot
(
	ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	RTO_ID INT NOT NULL,
	SLOT_DATE DATE NOT NULL,
	SLOT_TIMESTAMP DATETIME NOT NULL,
	APPLICATION_ID INT NOT NULL,
	KNOWLEDGE_TEST BOOL NOT NULL,
	SKILL_TEST BOOL NOT NULL
) ;


CREATE TABLE testtopics
(
	ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	TOPIC VARCHAR(255) NOT NULL
) ;



SET FOREIGN_KEY_CHECKS=1;
