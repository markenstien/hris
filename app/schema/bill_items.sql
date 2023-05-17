create table bill_items(
	id int(10) not null primary key auto_increment,
	bill_id int(10),
	name varchar(100),
	description text,
	price decimal(10, 2),
	created_at timestamp default now()
);

