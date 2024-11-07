use ehwillogbook_ehwillogbookDB;

-- admin can register a service provider using this sp
DELIMITER $$
CREATE PROCEDURE sp_register_service_provider (
    IN p_name VARCHAR(100),
    IN p_person VARCHAR(100),
    IN p_contact_no VARCHAR(100),
    IN p_email VARCHAR(100),
    OUT p_result_message VARCHAR(255)
)
BEGIN
    -- Insert into service_provider table with individual fields
    INSERT INTO service_provider (
        `name`, 
        person, 
        contact_no, 
        email
    ) VALUES (
        p_name, 
        p_person, 
        p_contact_no, 
        p_email
    );

    -- Set a success message
    SET p_result_message = 'Service provider registered successfully.';
END $$
DELIMITER ;
-- register service provider
CALL sp_register_service_provider(
    'Provider Name',
    'John',             -- contact person
    '0747109630',       -- contact number
    'john@example.com', -- email
    @result_message     -- Output message variable
);
SELECT @result_message AS result_message; -- View the result message
--
create view WIL_PLACEMENT -- view to show service providers
as
select id, `name` as 'provider_name' from service_provider;
select * from WIL_PLACEMENT;
--
create view levels -- view to show levels
as
select id, level_no from `level`;
select * from levels;



