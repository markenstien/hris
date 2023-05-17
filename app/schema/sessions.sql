drop table if exists sessions;
create table sessions(
	id int(10) not null primary key auto_increment,
	doctor_id int(10) not null,
	guest_name varchar(100),
	guest_phone varchar(100),
	guest_email varchar(100),
	guest_address varchar(100),
	guest_gender enum('male' , 'female'),
	user_id int(10),
	date_created date,
	time_created time,
	remarks text,
	appointment_id int(10) comment 'nullable',
	created_at timestamp default now()
);


alter table sessions
	add column doctor_recommendations text after remarks;