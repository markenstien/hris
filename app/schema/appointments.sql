
drop table if exists appointments;
create table appointments(
	id int(10) not null primary key auto_increment,
	reference varchar(100) not null,
	type enum('online' , 'walk-in'),
	status enum('pending' , 'arrived' , 'cancelled'),
	date date,
	user_id int(10),
	remark text,
	guest_name varchar(100),
	guest_email varchar(100),
	guest_phone varchar(100),
	created_at timestamp default now()
);


alter table appointments
	add column start_time time after date ,
	add column end_time time after date;


alter table appointments
	add column notes text;