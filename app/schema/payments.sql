create table payments(
	id int(10) not null primary key auto_increment,
	reference varchar(100),
	amount decimal(10 ,2),
	method enum('online','cash'),
	notes text,
	org varchar(100),
	external_reference varchar(100),
	acc_no	varchar(100),
	acc_name	varchar(100),
	bill_id	int(10),
	created_by int(10),
	created_at timestamp default now()
);