drop table specialties;
create table specialties(
	id int(10) not null primary key auto_increment,
	name varchar(100) not null,
	description text,
	category_id int(10),
	created_by int(10),
	created_at timestamp default now()
);