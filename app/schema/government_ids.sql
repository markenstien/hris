create table government_ids(
    id int(10) not null primary key auto_increment,
    user_id int(10) not null,
    organization varchar(50),
    id_number varchar(50),
    remarks text,
    is_verified boolean default true,
    created_at timestamp default now(),
    updated_at datetime
);