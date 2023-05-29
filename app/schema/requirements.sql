
/*
*requirements that needs to be passed by employees
* is_all_department column if this is check then means all the department will receive this requirement
* is_all_department column if this is check then means all position in the department selected will recieve the requirement 
* but if the department is all then all user will receive
*/
drop table if exists employee_requirements;
create table employee_requirements(
id int(10) not null primary key auto_increment,
req_code char(8),
req_title varchar(100),
description text,
start_date date,
end_date date,
importance char(50),


is_all_department boolean default false,
is_all_position boolean default false,

created_by int(10),
created_at timestamp default now(),
updated_at timestamp default now() ON UPDATE now()
);



/*
*this instance is created when is_all_department / is_all_position is false
*/
drop table if exists employee_requirements_recipients;
create table employee_requirements_recipients(
    id int(10) not null primary key auto_increment,
    employee_requirement_id int(10),
    err_category enum('position','department'),
    err_id varchar(50)
);


/*
*employee_requirement_respondents
*/
drop table if exists employee_requirement_respondents;
create table employee_requirement_respondents(
    id int(10) not null primary key auto_increment,
    eerr_reference char(10),
    cert_id int(10) not null,
    user_id int(10) not null,
    eerr_title varchar(100),
    eerr_description text,
    eerr_status char(50),
    
    date_of_entry datetime,
    approved_by int(10),
    approved_date datetime,

    created_at timestamp default now(),
    updated_at timestamp default now() on update now()
);
