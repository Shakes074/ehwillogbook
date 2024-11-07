-- Create role table
CREATE TABLE `role` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(200) NOT NULL,
    `active` TINYINT(1) DEFAULT 1
);

-- Create user table
CREATE TABLE `user` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(250) NOT NULL,
    surname VARCHAR(250) NOT NULL,
    username VARCHAR(20) NOT NULL UNIQUE, -- Unique identifier for student, staff, mentor, etc.
    email VARCHAR(350) NOT NULL UNIQUE,
    `password` VARCHAR(350) NOT NULL, -- Store hashed password
    cellnumber VARCHAR(20),
    `active` TINYINT(1) DEFAULT 1,
    roleid INT,
    FOREIGN KEY (roleid) REFERENCES `role`(id) -- Links to role table
);

-- Create student table
create TABLE `student` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title char(4),
    initals char(5),
    gender varchar(10),
    race varchar(10),
    cvdocument VARCHAR(250),           -- Path to CV document
    iddocument VARCHAR(250),           -- Path to ID document
    workingarea1 VARCHAR(250),         -- First working area
    workingarea2 VARCHAR(250),         -- Second working area
    homeaddress VARCHAR(250),          -- Full address (street, postal code, town, province)
    signature VARCHAR(250),            -- Path to signature image
    `active` TINYINT(1) DEFAULT 1,       -- Active status of the student
    userid INT NOT NULL,               -- Foreign key to user table
    levelid INT Not null,                       -- Education level or grade
    application_date DATE,
    FOREIGN KEY (userid) REFERENCES `user`(id), -- Link to user table
    FOREIGN KEY (levelid) REFERENCES `level`(id)  -- Link to level table
);

-- Create mentor table
CREATE TABLE `mentor` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `active` TINYINT(1) DEFAULT 1,         -- Active status of the mentor
    signature VARCHAR(250),              -- Path to signature image file
    userid INT NOT NULL,                 -- Foreign key linking to user table
    organisationid INT,                  -- Reference to mentor's organization
    FOREIGN KEY (userid) REFERENCES user(id) -- Link to user table
);

-- Create mutstaff table
CREATE TABLE `mutstaff` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hinumber VARCHAR(10) UNIQUE NOT NULL, -- Unique HI number for staff
    signature VARCHAR(250),               -- Path to signature image file
    userid INT NOT NULL,                  -- Foreign key linking to user table
    title_id INT,                         -- Role title (e.g., guest, etc.)
    FOREIGN KEY (userid) REFERENCES user(id), -- Link to user table
    FOREIGN KEY (title_id) REFERENCES role(id) -- Link to role table for title
);

-- Create level table
create table `level`(
id int not null primary key auto_increment,
level_no varchar(15) 
);

-- create service provider table
create table `service_provider`(
id int not null primary key auto_increment,
`name` varchar(100) not null,
person varchar(100) not null,
contact_no varchar(100),
email varchar(100) not null
);
