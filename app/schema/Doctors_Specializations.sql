create table doctors_specializations(
	id int(10) not null primary key auto_increment,
	doctor_id int(10) not null,
	specialty_id	int(10) not null,
	notes text,
	created_by int(10),
	created_at timestamp default now()
);

