create table employment_attributes(
    id int(10) not null primary key auto_increment,
    parent_id int(10),
    attr_key char(50),
    attr_name varchar(100),
    attr_abbr_name varchar(50),
    created_at timestamp default now()
);


INSERT INTO employment_attributes(parent_id,attr_key,attr_name,attr_abbr_name)
    VALUES(
        '1', 'POSITION', 'Software Engineer', 'SOFTEN'
    ),
    ('1', 'POSITION', 'IT-Manager', 'ITMAN'),
    ('1', 'POSITION', 'Business Analyst', 'BA'),
    ('1', 'POSITION', 'Accountant', 'Accountant'),
    ('3', 'POSITION', 'Janitor', 'Janitor'),
    ('2', 'POSITION', 'Front Desk', 'Front Desk');

INSERT INTO employment_attributes(attr_key,attr_name,attr_abbr_name)
    VALUES(
        'DEPARTMENT', 'Faculty', 'Faculty'
    ),
    ('DEPARTMENT', 'Technology', 'Technology'),
    ('DEPARTMENT', 'Accounting', 'Accounting'),
    ('DEPARTMENT', 'Cleaning Department', 'Cleaning Department');

    employment_attributes