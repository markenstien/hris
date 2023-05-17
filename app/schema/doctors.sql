create table doctors(
	id int(10) not null primary key auto_increment,
	license_number varchar(100) not null,
	user_id	varchar(50) not null
);



INSERT INTO doctors(license_number , user_id)
	(SELECT LPAD(FLOOR(RAND() * 999999.99), 6, '0') , id
		FROM users where user_type = 'doctor');