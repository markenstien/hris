create table service_bundles(
	id int(10) not null primary key auto_increment,
	code varchar(100) not null,
	name varchar(100) not null,
	category_id int(10) not null,
	price decimal(10 ,2),
	price_custom decimal(10,2),
	discount decimal(10 ,2),
	description text,
	status enum('available','unavailable'),
	is_visible boolean default true,
	created_by int(10),
	created_at timestamp default now()
);

alter table service_bundles add column 
	category_id int(10) not null;