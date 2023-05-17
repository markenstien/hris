create table schedule_setting(
	id int(10) not null primary key auto_increment,
	day varchar(100),
	opening_time time,
	closing_time time,
	max_visitor_count int(10),
	is_shop_closed boolean,
	updated_at timestamp default now() ON UPDATE now()
);

insert into schedule_setting(
	day , 
	opening_time ,
	closing_time ,
	max_visitor_count ,
	is_shop_closed
)VALUES('monday' , '10:00' , '18:00' , 100 , false),
('tuesday' , '10:00' , '18:00' , 100 , false),
('wednesday' , '10:00' , '18:00' , 100 , false),
('thursday' , '10:00' , '18:00' , 100 , false),
('friday' , '10:00' , '18:00' , 100 , false),
('saturday' , '10:00' , '18:00' , 100 , false),
('sunday' , '10:00' , '18:00' , 100 , false);