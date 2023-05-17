drop table if exists employement_details;
create table employement_details(
    id int(10) not null primary key auto_increment,
    user_id int(10) not null,
    position_id int(10) not null,
    department_id int(10) not null,
    reports_to int(10),
    employment_status enum('contractor','probationary','regular') default 'probationary',
    employment_date date,
    salary_per_month decimal(10,2),
    created_at timestamp default now(),
    updated_at timestamp default now() ON UPDATE now()
);