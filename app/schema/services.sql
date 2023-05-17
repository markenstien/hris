drop table services;
create table services(
	id int(10) not null primary key auto_increment,
	service varchar(50),
	code varchar(50),
	price decimal(10 , 2), 
	status enum('available' , 'not-available'),
	description text,
	category_id int(10),
	is_visible boolean default true,
	created_by int(10),
	created_at timestamp default now()
);