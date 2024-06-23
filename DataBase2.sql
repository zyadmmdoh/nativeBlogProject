create schema if not exists `blog` ;
use `blog` ;   

create table if not exists Users(
`id`  int primary key auto_increment,
`Name` varchar(255) not null,
`Email` varchar(255)not null unique,
`Phone` varchar(15) unique,
`Created_at` timestamp default current_timestamp,
`Updated_at` timestamp default current_timestamp
);

create table if not exists Posts(
`id`  int primary key auto_increment,
`Title` varchar(255) not null ,
`Content` text ,
`Image` varchar(255) ,
`User_id` int,
`Created_at` timestamp default current_timestamp not null,
`Updated_at` timestamp default current_timestamp not null,
constraint fk_user_id_Users
foreign key (User_id)
references Users(id)
on delete cascade
on update cascade
);
create table if not exists Comments(
`id`  int primary key auto_increment,
`Comment` text not null ,
`Created_at` timestamp default current_timestamp ,
`Updated_at` timestamp default current_timestamp ,
`Post_id` int,
`User_id` int,
constraint fk_post_id_Posts
foreign key (Post_id)
references Posts(id)
on delete cascade
on update cascade,

constraint fk_user_comments_Users
foreign key (User_id)
references Users(id)
on delete cascade
on update cascade
);


