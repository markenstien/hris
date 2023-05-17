create table service_bundle_items(
	id int(10) not null primary key auto_increment,
	service_id int(10) not null,
	bundle_id int(10) not null,
	created_by int(10),
	created_at timestamp default now()
);