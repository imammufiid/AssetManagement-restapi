drop table if exists t_assets;

drop table if exists t_users;

create table t_assets
(
   id             int not null AUTO_INCREMENT,
   user_id                   int,
   plat_mobil           varchar(50),
   no_rangka            varchar(120),
   no_mesin             varchar(120),
   owner_name           varchar(100),
   date_oil             timestamp,
   status               int,
   created_at           timestamp DEFAULT NOW() ON UPDATE NOW(),
   updated_at           timestamp DEFAULT NOW() ON UPDATE NOW(),
   primary key (id)
);

create table t_users
(
   id                   int not null AUTO_INCREMENT,
   username             varchar(50),
   password             varchar(256),
   email                varchar(50),
   status               int,
   created_at           timestamp DEFAULT NOW() ON UPDATE NOW(),
   updated_at           timestamp DEFAULT NOW() ON UPDATE NOW(),
   primary key (id)
);

alter table t_assets add constraint FK_RELATIONSHIP_1 foreign key (user_id)
      references t_users (id) on delete restrict on update restrict;

