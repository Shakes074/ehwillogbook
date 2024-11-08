
	create database [testEncryption];

	use testEncryption;

	CREATE TABLE Userz (
		email varchar(250),
		paswrd varchar(250)
	); 

	insert  into Userz (email, paswrd)  values ('shakes@gmail.com','@shakes074');
	insert  into Userz (email, paswrd)  values ('zondi@gmail.com','@zondi074');

	select * from Userz;

--- one way encryption

	insert  into Userz (email, paswrd)  values ('zuke@gmail.com',HASHBYTES('SHA2_256','@zuke074'));

--- or encrypt for viewing

	SELECT HASHBYTES('SHA2_256', paswrd) FROM Userz;  

	--- two way encryption using symmetric encryption with certificates
	--- encrypting the database
	--- first connect to master databse and create the master key and certificate. Than connect to local database to enable 

	use master;

	create master key encryption by -- master password
	password = '123456';

	create certificate mycert with -- certificate with subject
	subject = 'mycert';

--- database encryption using master key and certificate.

	use [testEncryption];  --- select local database to be encrypted

	create database encryption key -- encryption key by certificate
	with algorithm = AES_256
	encryption by server certificate mycert;

	ALTER DATABASE [testEncryption] -- finale step is to encrypt database
	SET ENCRYPTION ON;

--- creating user with login password and setting database
	CREATE LOGIN testing1 WITH PASSWORD=N'123456', DEFAULT_DATABASE=[testEncryption], CHECK_EXPIRATION=OFF, CHECK_POLICY=OFF 

	--- adding priviledges for the user
	ALTER SERVER ROLE [dbcreator] ADD MEMBER testing1
	ALTER SERVER ROLE [sysadmin] ADD MEMBER testing1

--- use column wizard to encrypt columns

--- connect using different users to see effects.











