drop table bills;
create table bills(
	id int(10) not null primary key auto_increment,
	reference varchar(50),
	user_id int(10),
	total_amount decimal(10 , 2),
	payment_status enum('paid' , 'unpaid'),
	payment_method enum('online' , 'offline-cash' , 'na'),
	bill_to_name varchar(50),
	bill_to_email varchar(50),
	bill_to_phone varchar(50),
	appointment_id int(10),
	created_at timestamp,
	created_by int
);