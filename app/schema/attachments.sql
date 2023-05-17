drop table attachments;
create table attachments(
	id int(10) not null primary key auto_increment,
	label varchar(100),
	filename varchar(100),
	file_type varchar(100),
	display_name varchar(100),
	search_key varchar(100),
	description text,

	global_key varchar(100),
	global_id int(10),

	path text,
	url text,
	full_path text,
	full_url text,
	

	is_visible boolean,
	created_by int(10),
	created_at timestamp default now()
);