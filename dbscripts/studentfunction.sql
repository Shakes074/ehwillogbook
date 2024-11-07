use ehwillogbook_ehwillogbookDB;

-- we register sudent as a user using this sp
DELIMITER $$
CREATE PROCEDURE sp_register_student(
    IN s_name VARCHAR(255),
    IN s_surname VARCHAR(255),
    IN s_studentnumber VARCHAR(20),
    IN s_email VARCHAR(255),
    IN s_password VARCHAR(255),
    IN s_cellnumber VARCHAR(20)
)
BEGIN
    INSERT INTO user (`name`, surname, username, email, `password`, cellnumber, `active`, roleid)
    VALUES (
        s_name,
        s_surname,
        s_studentnumber,
        s_email,
        SHA2(s_password, 256),  -- Hash the password using SHA-256
        s_cellnumber,
        1,       -- active
        2        -- roleid for students
    );
END $$
DELIMITER ;
select * from `user`; -- check user
call sp_register_student('Nkosi','Cele','2162285','2162285@live.mut.ac.za','123456','0682449658'); -- check if working...

-- student can do their application using this sp
DELIMITER $$
create PROCEDURE sp_student_application (
    IN p_cvdocument VARCHAR(255),
    IN p_iddocument VARCHAR(255),
    IN p_workingarea1 VARCHAR(255),
    IN p_workingarea2 VARCHAR(255),
    IN p_address VARCHAR(255),
    IN p_signature VARCHAR(255),
    IN p_active TINYINT,
    IN p_userid INT,
    IN p_levelid INT,
    OUT p_result_message VARCHAR(255)
)
BEGIN
    DECLARE current_year INT;
    DECLARE yearly_applications INT;
    DECLARE total_applications INT;

    -- Set the current year
    SET current_year = YEAR(CURDATE());

    -- Check the number of applications made by the student in the current year
    SELECT COUNT(*) INTO yearly_applications
    FROM student
    WHERE userid = p_userid AND YEAR(application_date) = current_year;

    -- Check the total number of applications made by the student in the last 3 years
    SELECT COUNT(*) INTO total_applications
    FROM student
    WHERE userid = p_userid AND application_date >= DATE_SUB(CURDATE(), INTERVAL 3 YEAR);

    -- Check if the student has exceeded the application limits
    IF yearly_applications >= 2 THEN
        SET p_result_message = 'Application limit reached for this year. Maximum of 2 applications allowed per year.';
    ELSEIF total_applications >= 6 THEN
        SET p_result_message = 'Total application limit reached. Maximum of 6 applications allowed over the last 3 years.';
    ELSE
       
        -- Insert the application data into the student table
        INSERT INTO student (
            cvdocument, 
            iddocument, 
            workingarea1, 
            workingarea2, 
            homeaddress, 
            signature, 
            `active`, 
            userid, 
            levelid,
            application_date  -- Ensure this column exists and stores the application date
        ) VALUES (
            p_cvdocument, 
            p_iddocument, 
            p_workingarea1, 
            p_workingarea2, 
            p_address, 
            p_signature, 
            p_active, 
            p_userid, 
            p_levelid,
            CURDATE()          -- Set the application date to the current date
        );

        SET p_result_message = 'Application submitted successfully.';
    END IF;
END $$
DELIMITER ;
select * from student; -- checking if student has sent the application
CALL sp_test_application(
    '/path/to/cv.pdf', '/path/to/id.pdf', 
    'Area 1', 'Area 2', '123 Main St', 
    'Townsville', 'ProvinceX', 
    '12345', '/path/to/signature.png', 
    1,            -- Active status
    15,            -- User ID
    1,            -- Level ID
    @result       -- Output message variable
);
SELECT @result AS result_message;

-- 

DELIMITER $$

CREATE PROCEDURE sp_student_application(
    IN p_title CHAR(4),
    IN p_initials CHAR(5),
    IN p_gender VARCHAR(10),
    IN p_race VARCHAR(10),
    IN p_cvdocument VARCHAR(255),
    IN p_iddocument VARCHAR(255),
    IN p_workingarea1 VARCHAR(255),
    IN p_workingarea2 VARCHAR(255),
    IN p_homeaddress VARCHAR(255),
    IN p_signature VARCHAR(255),
    IN p_active TINYINT,
    IN p_userid INT,
    IN p_level_name VARCHAR(50),  -- Accepting level name instead of ID
    OUT p_result_message VARCHAR(255)
)
BEGIN
    DECLARE level_id INT DEFAULT NULL;
    DECLARE user_exists INT DEFAULT 0;

    -- Look up the level ID based on the level name provided
    SELECT id INTO level_id
    FROM level
    WHERE level_no = p_level_name;

    -- If no matching level name is found, set an error message and exit
    IF level_id IS NULL THEN
        SET p_result_message = 'Invalid level name. Application not submitted.';
        RETURN;
    END IF;

    -- Verify if the user exists
    SELECT COUNT(*) INTO user_exists FROM `user` WHERE id = p_userid;
    IF user_exists = 0 THEN
        SET p_result_message = 'Invalid user ID. Application not submitted.';
        RETURN;
    END IF;

    -- Insert the student application into the student table with the verified level_id
    INSERT INTO student (
        title,
        initals,
        gender,
        race,
        cvdocument,
        iddocument,
        workingarea1,
        workingarea2,
        homeaddress,
        signature,
        active,
        userid,
        levelid,
        application_date
    ) VALUES (
        p_title,
        p_initials,
        p_gender,
        p_race,
        p_cvdocument,
        p_iddocument,
        p_workingarea1,
        p_workingarea2,
        p_homeaddress,
        p_signature,
        p_active,
        p_userid,
        level_id,  -- Use the verified level ID
        CURDATE()
    );

    -- Set success message
    SET p_result_message = 'Application submitted successfully.';
END $$
DELIMITER ;














