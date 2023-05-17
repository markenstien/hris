drop table if exists system_notifications;
create table system_notifications(
	id int(10) not null primary key auto_increment,
	message text,
	icon varchar(100),
	color varchar(100),
	heading varchar(100),
	subtext varchar(100),
	href varchar(100),
	created_at timestamp default now(),
	updated_at timestamp default now() ON UPDATE now()
);

drop table if exists system_notification_recipients;
create table system_notification_recipients(
	id int(10) not null primary key auto_increment,
	notification_id int(10) ,
	recipient_id int(10),
	is_read boolean default false,
	updated_at timestamp default now() ON UPDATE now()
);