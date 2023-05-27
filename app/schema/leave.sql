drop table if exists employment_leaves;
create table employment_leaves(
    id int(10) not null primary key auto_increment,
    user_id int(10) not null,
    date_filed date,
    start_date date,
    end_date date,
    
    status enum('pending','declined','cancelled','approved'),
    leave_category char(80),
    approval_date datetime,
    approved_by int(10),

    reason text,
    remarks text,

    created_at timestamp default now(),
    updated_at timestamp default now() ON UPDATE now()
);