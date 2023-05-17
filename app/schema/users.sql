drop table if exists users;
create table users(
	id int(10) not null primary key auto_increment,
	user_code varchar(25) not null unique,
	user_type enum('employee','administrator','sub-administrator','moderator'),
	first_name varchar(50) not null,
	middle_name varchar(50) not null,
	last_name varchar(50) not null,
	birthdate date,
	gender enum('Male' , 'Female') not null,
	address text,
	phone_number varchar(50) not null,
	email varchar(50) not null,
	username varchar(12) not null,
	password varchar(150) not null,
	profile text,
	created_by int(10),
	created_at timestamp default now(),
	updated_at timestamp default now() ON UPDATE now()
);

alter table users 
	add column is_verified boolean default false;

alter table users 
	add column address_id int(10);