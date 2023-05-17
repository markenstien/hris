drop table service_cart;
create table service_cart(
	id int(10) not null primary key auto_increment,
	session_token varchar(50),
	service_id int(10) not null,
	type enum('service' , 'bundle'),
	user_id int(10) not null,
	created_at timestamp default now()
);