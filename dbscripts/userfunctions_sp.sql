
use ehwillogbook_ehwillogbookDB;

DELIMITER $$
CREATE PROCEDURE sp_user_signin(
IN u_user VARCHAR(255), 
IN u_password VARCHAR(255)
)
BEGIN
    SELECT id, username, email 
    FROM `user` 
    WHERE (username = u_user OR email = u_user) 
      AND `password` = SHA2(u_password, 256);  -- Hash the input password before comparison
END $$
DELIMITER ;

select * from `user`; -- check user
call sp_user_signin('2162285','123456'); -- check login


