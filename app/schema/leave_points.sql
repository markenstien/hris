create table leave_points(
    id int(10) not null primary key auto_increment,
    user_id int(10) not null,
    point int(10),
    leave_point_category char(100),
    remarks text,
    created_at timestamp default now(),
    updated_at timestamp default now() on update now(),

    created_by int(10)
);