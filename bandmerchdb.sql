drop database if exists bandmerchdb;
create database if not exists bandmerchdb;
use bandmerchdb;

create table `user`(
	`id` int unsigned auto_increment not null,
    `username` nvarchar(255) not null,
    `password` char(60) not null,
    `address` nvarchar(255) default null,
    `city` nvarchar(255) default null,
    `state` char(2) default null,
    `zipcode` char(5) default null,
    `first_name` nvarchar(255) default null,
    `last_name` nvarchar(255) default null,
     primary key(`id`),
     unique(`username`)

);


create table `product`(
	`id` int unsigned auto_increment not null,
    `name` nvarchar(255) not null,
    `type` nvarchar(255) not null,
    `stock` int(10) unsigned default 1,
    `price` decimal (5, 2),
     primary key(`id`)
);

create table `order`(
	`id` int unsigned auto_increment not null,
    `user_id` int unsigned not null,
    `order_date` datetime not null,
    `subtotal` decimal (6, 2) not null,
    `tax` decimal(6, 2) not null,
    `total` decimal(6, 2) not null,
    primary key(`id`)

);

create table `order_items`(
	`id` int unsigned auto_increment not null,
    `product_id` int unsigned not null,
    `product_name` nvarchar(255) not null,
    `product_type` nvarchar(255) not null,
    `product_price` decimal(5, 2) not null,
    `order_id` int(10) unsigned not null,
    `quantity` int(10) unsigned not null,
    primary key(`id`)
);

create table `image`(
    `id` int unsigned auto_increment not null,
    `filename` nvarchar(255) not null,
    `mimetype` nvarchar(50) not null,
    `imagedata` mediumblob not null,
    `user_id` int unsigned not null,
    primary key(`id`)
);

alter table `order` add constraint `user_order_fk`
foreign key (`user_id`) references `user`(`id`)
on delete cascade;

alter table `order_items` add constraint `product_order_items_fk`
foreign key (`product_id`) references `product`(`id`)
on delete cascade;

alter table `image` add constraint `user_image_fk`
foreign key (`user_id`) references `user`(`id`)
on delete cascade;

select * from `image` i
join `user` u on i.user_id = u.id;

select * from `order_items` oi
join `product` p on oi.product_id = p.id;

insert into `product` (`name`, `type`, `stock`, `price`)
values("Leper's Bell Tee", "t-shirt", 10, 20.00);

insert into `product` (`name`, `type`, `stock`, `price`)
values("I'm Better Off Without You Crewneck", "sweatshirt", 10, 35.00);