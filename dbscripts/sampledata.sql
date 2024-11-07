use ehwillogbook_ehwillogbookDB;
 
insert into `role` 
(`name`, `active`)
	values
('admin', 1),
('student', 1),
('mutstaff', 1),
('mentor', 1);
 
INSERT INTO `user` (`name`, surname, username, email, `password`, cellnumber, `active`, roleid) 
	VALUES 
  ('Cheryl', 'Baxter', 'erinmartinez', 'christopher18@patterson.org', '123456', '0682449047', 1, 1)
 ,('William', 'Hernandez', 'mooremichael', 'michaelpearson@riddle.com', '789456', '0733983280', 1, 2)
 ,('Peter', 'Potter', 'ncarter', 'dicksonmelissa@brown.org', '3e31644b9294568001b19e1adcb9a101693ed75bb2c20cf031c76044e058f466', '187-473-9052', 1, 2)
 ,('Jennifer', 'Murphy', 'marie26', 'suekelley@hotmail.com', 'f2856393f11052b5f016e352363b54b7cf3c5fdd95b24170b2fd7c290f661346', '013.410.4826x371', 0, 2)
 ,('Jacob', 'Newton', 'julie82', 'fordchristopher@gmail.com', 'de602eb9c451eee99031f443b12494bef1cb5457af92b017373c4dfad6ac2d33', '611.158.5293x200', 0, 4)
 ,('Ryan', 'Mckinney', 'awilkerson', 'tony61@patel-lopez.com', '50e6f5c47e262d2411925900fe1c4e86be1810e7f6f6ef3f2bbfeb3e641532d6', '(552)746-0067', 0, 3)
 ,('Erica', 'Delgado', 'calhounlinda', 'potterbrian@gmail.com', '9c4adeb58f9945954760d37e8807c3cf7fdde74e968c122ff8db482e92acc8dc', '001-400-041-9955', 1, 4)
 ,('Jesse', 'Clark', 'harpermichelle', 'megan48@gilmore.com', '7ced4041505b20839251793970a77d0748a371ac56fadd11831dbcfe29285da0', '552-652-7414x377', 1, 4)
 ,('Jessica', 'Davis', 'suzanne54', 'erinhernandez@yahoo.com', 'a9156f6510683744165ee9dc68eb71a2fd4548c975c72a0e167a7aa26beff90b', '001-386-036-2691x1518', 0, 3)
 ,('Joseph', 'Norman', 'stephanie92', 'gloriabarnes@jones-carney.info', '7e0a432cd7bd6bfd77ddf8e39d1a24faea18ab193204c840ba82179c4b61e6ce', '020.769.4890x0058', 0, 1);

insert into `level`
(level_no)
	value
('Level 2'),
('Level 3'),
('Level 4');

alter table `level`
	add level_no varchar(15) ;
    
    select * from `level`;

DELETE FROM `ehwillogbook_ehwillogbookDB`.`level` WHERE (`id` = '3');
DELETE FROM `ehwillogbook_ehwillogbookDB`.`level` WHERE (`id` = '4');



-- Register all Service Providers using sp_register_service_provider

CALL sp_register_service_provider(
    'Amajuba DM',
    'Ms D Ngobese, B. Mhlungu',
    '034 329 7200',
    'Bhekanim@amajuba.gov.za, dudump@amajuba.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'Alfred Nzo DM',
    'T. Manciya',
    '071 604 2423 / 039 254 500',
    'manciyat@andm.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'Buffalo City',
    'A. Falati',
    '043 705 2937, 082 898 7936',
    'andilef@buffalocity.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'Chris Hani',
    'S. Vellem',
    '045 807 9413, 076 631 3107',
    'svellem@chrishanidm.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'City of Ekurhuleni',
    'Dr Jerry Chaka',
    '011 999 2970',
    'Jerry.Chaka@ekurhuleni.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'City of Johannesburg Metropolitan Municipality',
    'Mr J Shikwambane',
    '083 261 4397, 011 582 1659',
    'null',
    @p_result_message
);
CALL sp_register_service_provider(
    'City of Tshwane Metropolitan',
    'Rina Nel, Boitumelo Modikoe',
    '082 255 0248, 012 358 873, 082 967 6235, 012 358 8684, 084 479 6050',
    'jerrym@tshwane.gov.za, rinanl@tshwane.gov.za, Tumimak@tshwane.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'eThekwini Municipality',
    'N. Dlangalala, L. Mkhize',
    '084 247 8263, 083 968 1117',
    'Nokuzola.Dlangalala@durban.gov.za, Lucky.Mkhize@durban.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'Ehlanzeni DM',
    'S. Saliwa',
    '013 759 8593, 060 972 9925',
    'ssaliwa@ehlanzeni.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'Gauteng Health Province',
    'Ms Christina Moumakwe',
    '0780958076',
    'Christina.Mnisi@gauteng.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'Gert Sibande DM',
    'Isaiah Diadla',
    'Main 017 801 7000, Office 017 801 7112, Cell 071 609 9219',
    'isaiahd@gsibande.gov.za, IsaiahD@gsibande.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'ILembe DM',
    'Mr Khawula, Mr Mungwe',
    '082 577 7400, 032 437 3500',
    'zweli.khawula@ilembe.gov.za, khulekani.mungwe@ilembe.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'Joe Gqabi DM',
    'Ms N Memela',
    '+27 732 140 442',
    'nobesuthu@jgdm.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'John Taolo Gaetsewe',
    'Mr Matlhare',
    '053 712 8732',
    'matlhareth@taologaetsewe.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'King Cetshwayo DM',
    'Ms N Fikeni, Vusumuzi Zungu',
    '+27 78 541 7226, +27 35 799 123, 063 257 8867',
    'fikeni@kingcetshwayo.gov.za, zunguvu@kingcetshwayo.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'Msunduzi Municipality',
    'A. Clive N Caluza',
    '033 392 2327',
    'Clive.Anthony@msunduzi.gov.za, Ntokozo.Caluza@msunduzi.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'Nkangala District',
    'Mr Soli Links',
    '072 075 1738',
    'linkss@nkangaladm.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'OR Tambo DM',
    'Mkentane, B Cingo',
    '060 452 4533, 060 635 0952',
    'bhshezi@gmail.com, tandiemkentane@yahoo.com, andilesigwebo@gmail.com',
    @p_result_message
);
CALL sp_register_service_provider(
    'Ugu DM',
    'N. Gumbi, Vasie Manawer',
    '039 688 3468, 039 688 5744',
    'nokuthaba.gumbid@ugu.gov.za, Vasie.Manaweri@ugu.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'Umgungundlovu DM',
    'Mr S Mkhize, Ms N Chapi',
    '033 897 6700 / 082 8018 099, 079 495 0113',
    'Sibusiso.Mkhize@umdm.gov.za, Nompumelelo.Chapi@umdm.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'Umkhanyakude DM',
    'Mr Makhoba, Mr Mbambo',
    '035 577 1200, 071 888 6428',
    'makhobab@ukdm.gov.za, mluhh@yahoo.com',
    @p_result_message
);
CALL sp_register_service_provider(
    'Umzinyathi DM',
    'S Malinga',
    '072 358 7354',
    'Malinagas@umzinyathi.gov.za',
    @p_result_message
);
CALL sp_register_service_provider(
    'UThukela DM',
    'G Mazibuko',
    '036 638 2400',
    'GMazibuko2@uthukela.gov.za, gugum@uthukeladm.co.za, gaselagpp15@gmail.com',
    @p_result_message
);
CALL sp_register_service_provider(
    'Zululand DM',
    'S Mzobe MHS, Mr Mosia Acting Community Service',
    '083 743 4212',
    'smosia@zululand.org.za, smzobe@zululand.org.za, nngxongo@zululand.org.za',
    @p_result_message
);

