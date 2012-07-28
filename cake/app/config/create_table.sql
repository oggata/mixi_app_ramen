create table m_event(
event_code int(11) NOT NULL auto_increment,
genre_code int,
txt varchar(250),
target_point int,
PRIMARY KEY (`event_code`)
)TYPE=InnoDB AUTO_INCREMENT=1;


insert into m_event (genre_code,txt,target_point) values(1,'貯金に利子がついた',100);
insert into m_event (genre_code,txt,target_point) values(1,'豊作で野菜の値段が安くなった',300);
insert into m_event (genre_code,txt,target_point) values(1,'道端でお金を拾った',500);
insert into m_event (genre_code,txt,target_point) values(1,'なぜかビールが売れに売れた',100);
insert into m_event (genre_code,txt,target_point) values(1,'ローカルのテレビで取材された',300);
insert into m_event (genre_code,txt,target_point) values(1,'ラーメン関連雑誌に執筆した。',500);

insert into m_event (genre_code,txt,target_point) values(1,'屋台の車輪が壊れた',-100);
insert into m_event (genre_code,txt,target_point) values(1,'屋台の屋根が台風で飛ばされた',-300);
insert into m_event (genre_code,txt,target_point) values(1,'麺を発注しすぎた',-500);
insert into m_event (genre_code,txt,target_point) values(1,'ダシをこぼした',-100);
insert into m_event (genre_code,txt,target_point) values(1,'ラーメン詐欺にあった',-300);
insert into m_event (genre_code,txt,target_point) values(1,'食い逃げされた',-500);

insert into m_event (genre_code,txt,target_point) values(2,'皿を綺麗に洗った。',100);
insert into m_event (genre_code,txt,target_point) values(2,'新メニューの案が浮かんだ',300);
insert into m_event (genre_code,txt,target_point) values(2,'「集客」についての本を読んだ',500);
insert into m_event (genre_code,txt,target_point) values(2,'ドラマで「ラーメン道物語」を見て泣いた',100);
insert into m_event (genre_code,txt,target_point) values(2,'「店舗インテリア」の本を読んだ',300);
insert into m_event (genre_code,txt,target_point) values(2,'子供が喜んでラーメンを食べてくれた',500);

insert into m_event (genre_code,txt,target_point) values(2,'徹夜で仕込んでいたら体調を崩した',-100);
insert into m_event (genre_code,txt,target_point) values(2,'経営の先行きが不安になった',-300);
insert into m_event (genre_code,txt,target_point) values(2,'母親が体調を壊したと連絡があった',-500);
insert into m_event (genre_code,txt,target_point) values(2,'ぎっくり腰になって仕込みができなくなった',-100);
insert into m_event (genre_code,txt,target_point) values(2,'テレビでラーメンよりパスタが健康に良いとやっていた',-300);
insert into m_event (genre_code,txt,target_point) values(2,'チャルメラの音がうるさいと苦情が来た',-500);




create table m_prefecture_taste(
prefecture_code int,
prefecture_name varchar(250),
goal_men_type_code int,
goal_soup_type_code int,
goal_product_price int,
goal_kotteri_point int,
goal_volume_point int,
hissu_material_code1 int,
hissu_material_code2 int,
hissu_material_code3 int,
PRIMARY KEY  (`prefecture_code`)
)TYPE=InnoDB;


insert into m_prefecture_taste(
prefecture_code,
prefecture_name,
goal_men_type_code,
goal_soup_type_code,
goal_product_price,
goal_kotteri_point,
goal_volume_point,
hissu_material_code1,
hissu_material_code2,
hissu_material_code3
)values(
1,
'博多',
1,
1,
1000,
5,
5,
1,
1,
1
);

insert into m_prefecture_taste(
prefecture_code,
prefecture_name,
goal_men_type_code,
goal_soup_type_code,
goal_product_price,
goal_kotteri_point,
goal_volume_point,
hissu_material_code1,
hissu_material_code2,
hissu_material_code3
)values(
2,
'東京',
1,
1,
1000,
5,
5,
1,
1,
1
);


insert into m_prefecture_taste(
prefecture_code,
prefecture_name,
goal_men_type_code,
goal_soup_type_code,
goal_product_price,
goal_kotteri_point,
goal_volume_point,
hissu_material_code1,
hissu_material_code2,
hissu_material_code3
)values(
3,
'札幌',
1,
1,
1000,
5,
5,
1,
1,
1
);

create table customer_hyouka(
customer_hyouka_code int(11) NOT NULL auto_increment,
member_code int,
title varchar(250),
prefecture_code int,
prefecture_name varchar(250),
product_code int,
decision_date datetime,
PRIMARY KEY  (`customer_hyouka_code`)
)TYPE=InnoDB AUTO_INCREMENT=1;





alter table m_lv_exp add dan_name varchar(250);
alter table members add main_product_code int;






update m_lv_exp set dan_name = '研修' where lv = 1;
update m_lv_exp set dan_name = '見習' where lv = 2;
update m_lv_exp set dan_name = '開業' where lv = 3;
update m_lv_exp set dan_name = '十級' where lv = 4;
update m_lv_exp set dan_name = '九級' where lv = 5;
update m_lv_exp set dan_name = '八級' where lv = 6;
update m_lv_exp set dan_name = '七級' where lv = 7;
update m_lv_exp set dan_name = '六級' where lv = 8;
update m_lv_exp set dan_name = '五級' where lv = 9;
update m_lv_exp set dan_name = '四級' where lv = 10;
update m_lv_exp set dan_name = '三級' where lv = 11;
update m_lv_exp set dan_name = 'ニ級' where lv = 12;
update m_lv_exp set dan_name = '一級' where lv = 13;
update m_lv_exp set dan_name = '初段' where lv = 14;
update m_lv_exp set dan_name = '弐段' where lv = 15;
update m_lv_exp set dan_name = '参段' where lv = 16;
update m_lv_exp set dan_name = '四段' where lv = 17;
update m_lv_exp set dan_name = '五段' where lv = 18;
update m_lv_exp set dan_name = '六段' where lv = 19;
update m_lv_exp set dan_name = '七段' where lv = 20;
update m_lv_exp set dan_name = '八段' where lv = 21;
update m_lv_exp set dan_name = '九段' where lv = 22;
update m_lv_exp set dan_name = '十段' where lv = 23;
update m_lv_exp set dan_name = '名人' where lv = 24;
update m_lv_exp set dan_name = '伝説' where lv = 25;




alter table material add comment varchar(250);





update map_position set item_id = 'exp_plus' where map_position_code = 1;
update map_position set item_id = 'exp_plus' where map_position_code = 2;
update map_position set item_id = 'exp_minus' where map_position_code = 3;
update map_position set item_id = 'money_plus' where map_position_code = 4;
update map_position set item_id = 'money_minus' where map_position_code = 5;
update map_position set item_id = 'warp' where map_position_code = 6;
update map_position set item_id = 'cook' where map_position_code = 7;
update map_position set item_id = 'shop' where map_position_code = 8;
update map_position set item_id = 'exp_plus' where map_position_code = 9;
update map_position set item_id = 'money_plus' where map_position_code = 10;
update map_position set item_id = 'exp_plus' where map_position_code = 11;
update map_position set item_id = 'money_plus' where map_position_code = 12;
update map_position set item_id = 'cook' where map_position_code = 13;

create table product(
product_code int(11) NOT NULL auto_increment,
member_code int,
product_name varchar(250),
c_1_code int default 0,
c_1_id varchar(250),
c_1_name varchar(250),
c_2_code int default 0,
c_2_id varchar(250),
c_2_name varchar(250),
c_3_code int default 0,
c_3_id varchar(250),
c_3_name varchar(250),
c_4_code int default 0,
c_4_id varchar(250),
c_4_name varchar(250),
c_5_code int default 0,
c_5_id varchar(250),
c_5_name varchar(250),
c_6_code int default 0,
c_6_id varchar(250),
c_6_name varchar(250),
c_7_code int default 0,
c_7_id varchar(250),
c_7_name varchar(250),
c_8_code int default 0,
c_8_id varchar(250),
c_8_name varchar(250),
c_9_code int default 0,
c_9_id varchar(250),
c_9_name varchar(250),
c_10_code int default 0,
c_10_id varchar(250),
c_10_name varchar(250),
gu_kosu int default 0,
product_men_type_code int default 0,
product_soup_type_code int default 0,
product_price int default 0,
product_kotteri_point int default 0,
product_volume_point int default 0,
PRIMARY KEY  (`product_code`)
)TYPE=InnoDB AUTO_INCREMENT=1 ;







create table member_material(
member_material_code int(11) NOT NULL auto_increment,
material_code int,
member_code int,
insert_date datetime,
PRIMARY KEY  (`member_material_code`)
)TYPE=InnoDB AUTO_INCREMENT=1;



create table material(
material_code int(11) NOT NULL auto_increment,
material_name varchar(250),
material_id varchar(250),
genre_code int,
price int,
 PRIMARY KEY  (`material_code`)
)TYPE=InnoDB AUTO_INCREMENT=1 ;


//1.�M /2.�X�[�v  /3.��  /4.��1 /5.��2 /6.��3 /7.��4 /8.��5 /9.��6


insert into material(material_code,material_name,material_id,genre_code,price)values(0,'なし','',1,0);


insert into material(material_name,material_id,genre_code,price)values('���M','sara_1',1,100);
insert into material(material_name,material_id,genre_code,price)values('�؍�','tonkotsu',2,100);
insert into material(material_name,material_id,genre_code,price)values('��','shio',2,100);
insert into material(material_name,material_id,genre_code,price)values('�ݖ�','syoyu',2,100);
insert into material(material_name,material_id,genre_code,price)values('���X','miso',2,100);
insert into material(material_name,material_id,genre_code,price)values('�ݖ�X','syoyumiso',2,100);
insert into material(material_name,material_id,genre_code,price)values('�g�}�g','tomato',2,100);
insert into material(material_name,material_id,genre_code,price)values('�׃X�g���[�g','hoso_s',3,100);
insert into material(material_name,material_id,genre_code,price)values('���X�g���[�g','futo_s',3,100);
insert into material(material_name,material_id,genre_code,price)values('�ׂ�����','hoso_c',3,100);
insert into material(material_name,material_id,genre_code,price)values('��������','futo_c',3,100);
insert into material(material_name,material_id,genre_code,price)values('�`���[�V���[','chasyu',4,100);
insert into material(material_name,material_id,genre_code,price)values('�ϗ�','nitamago',4,100);
insert into material(material_name,material_id,genre_code,price)values('�l�M','negi',4,100);
insert into material(material_name,material_id,genre_code,price)values('�`���[�V���[','chasyu',5,100);
insert into material(material_name,material_id,genre_code,price)values('�ϗ�','nitamago',5,100);
insert into material(material_name,material_id,genre_code,price)values('�l�M','negi',5,100);


alter table members add last_xi_count int;
alter table members add last_xi_update_date datetime;
alter table members add lv int;
alter table members add exp int;
alter table members add sum_exp int;
alter table members add least_next_exp int;

CREATE TABLE `members` (
  `member_code` int(11) NOT NULL auto_increment,
  `mixi_account_code` int(11) default NULL,
  `member_name` longtext,
  `member_mail` longtext,
  `member_pass` longtext,
  `money` int(11) default NULL,
  `map_code` int(11) default NULL,
  `target_code` int default NULL,
  `target_id` varchar(250) default NULL,
  `sales_product_count` int(11) default NULL,
  `product_quority` int(11) default NULL,
  `last_update_date` date default NULL,
  PRIMARY KEY  (`member_code`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;


insert into members(money,map_code,target_code,target_id)values(100,1,22,'D1');

CREATE TABLE `member_message` (
  `member_message_code` int(11) NOT NULL auto_increment,
  `member_code` int(11) default NULL,
  `mixi_account_code` int(11) default NULL,
  `message_category` int(11) default NULL,
  `message_txt` longtext,
  `message_accept_date` datetime default NULL,
  PRIMARY KEY  (`member_message_code`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

CREATE TABLE `member_position` (
  `member_position_code` int(11) NOT NULL auto_increment,
  `member_code` int(11) default NULL,
  `mixi_account_code` int(11) default NULL,
  `map_code` int(11) default NULL,
  `position_code` int(11) default NULL,
  `position_flag` int(11) default NULL,
  `position_date` date default NULL,
  `last_position_date` date default NULL,
  `item_code` int(11) default NULL,
  `item_id` varchar(250) default NULL,
  `item_genre` int(11) default NULL,
  `item_name` varchar(250) default NULL,
  PRIMARY KEY  (`member_position_code`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;


create table map_position(
  `map_position_code` int(11) NOT NULL auto_increment,
  `map_code` int(11) default NULL,
  `position_code` int(11) default NULL,
  `position_flag` int(11) default NULL,
  `position_date` date default NULL,
  `last_position_date` date default NULL,
  `item_code` int(11) default NULL,
  `item_id` varchar(250) default NULL,
  `item_genre` int(11) default NULL,
  `item_name` varchar(250) default NULL,
PRIMARY KEY  (`map_position_code`)
)TYPE=InnoDB AUTO_INCREMENT=1 ;

insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,29,1,now(),now(),1,'exp_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,23,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,16,1,now(),now(),1,'money_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,24,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,31,1,now(),now(),1,'warp',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,39,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,45,1,now(),now(),1,'money_minus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,52,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,58,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,51,1,now(),now(),1,'exp_minus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,43,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,36,1,now(),now(),1,'route',1,'');

insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(2,29,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(2,23,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(2,16,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(2,24,1,now(),now(),1,'money_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(2,31,1,now(),now(),1,'warp',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(2,39,1,now(),now(),1,'money_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(2,45,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(2,52,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(2,58,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(2,51,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(2,43,1,now(),now(),1,'exp_minus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(2,36,1,now(),now(),1,'exp_plus',1,'');

insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(3,29,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(3,23,1,now(),now(),1,'exp_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(3,16,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(3,24,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(3,31,1,now(),now(),1,'warp',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(3,39,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(3,45,1,now(),now(),1,'exp_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(3,52,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(3,58,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(3,51,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(3,43,1,now(),now(),1,'exp_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(3,36,1,now(),now(),1,'money_minus',1,'');

insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(4,29,1,now(),now(),1,'exp_minus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(4,23,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(4,16,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(4,24,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(4,31,1,now(),now(),1,'warp',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(4,39,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(4,45,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(4,52,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(4,58,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(4,51,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(4,43,1,now(),now(),1,'money_minus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(4,36,1,now(),now(),1,'exp_minus',1,'');

insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(5,29,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(5,23,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(5,16,1,now(),now(),1,'exp_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(5,24,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(5,31,1,now(),now(),1,'warp',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(5,39,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(5,45,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(5,52,1,now(),now(),1,'money_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(5,58,1,now(),now(),1,'money_minus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(5,51,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(5,43,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(5,36,1,now(),now(),1,'exp_plus',1,'');

insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(6,29,1,now(),now(),1,'exp_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(6,23,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(6,16,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(6,24,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(6,31,1,now(),now(),1,'warp',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(6,39,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(6,45,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(6,52,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(6,58,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(6,51,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(6,43,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(6,36,1,now(),now(),1,'money_plus',1,'');

insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(7,29,1,now(),now(),1,'money_minus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(7,23,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(7,16,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(7,24,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(7,31,1,now(),now(),1,'warp',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(7,39,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(7,45,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(7,52,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(7,58,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(7,51,1,now(),now(),1,'exp_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(7,43,1,now(),now(),1,'exp_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(7,36,1,now(),now(),1,'route',1,'');

insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(8,29,1,now(),now(),1,'money_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(8,23,1,now(),now(),1,'money_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(8,16,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(8,24,1,now(),now(),1,'exp_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(8,31,1,now(),now(),1,'warp',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(8,39,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(8,45,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(8,52,1,now(),now(),1,'money_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(8,58,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(8,51,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(8,43,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(8,36,1,now(),now(),1,'money_plus',1,'');

insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(9,29,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(9,23,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(9,16,1,now(),now(),1,'money_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(9,24,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(9,31,1,now(),now(),1,'warp',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(9,39,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(9,45,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(9,52,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(9,58,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(9,51,1,now(),now(),1,'money_minus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(9,43,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(9,36,1,now(),now(),1,'exp_plus',1,'');

insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(10,29,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(10,23,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(10,16,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(10,24,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(10,31,1,now(),now(),1,'warp',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(10,39,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(10,45,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(10,52,1,now(),now(),1,'money_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(10,58,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(10,51,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(10,43,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(10,36,1,now(),now(),1,'route',1,'');

insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(11,29,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(11,23,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(11,16,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(11,24,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(11,31,1,now(),now(),1,'warp',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(11,39,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(11,45,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(11,52,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(11,58,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(11,51,1,now(),now(),1,'route',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(11,43,1,now(),now(),1,'exp_plus',1,'');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(11,36,1,now(),now(),1,'route',1,'');






E1->D2->C2->D3->E3->F4->G3->H3->I2->H2->G1->F1
R ->R-> B-> B-> B ->L -> L->L -> T -> T->T ->R
29->23->16->24->31->39->45->52->58->51->43->36


2:,3,4,5,6,7,8,9,10
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,22,1,now(),now(),2,'building',2,'����');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,15,1,now(),now(),2,'building',2,'����');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,9,1,now(),now(),2,'building',2,'����');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,2,1,now(),now(),2,'building',2,'����');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,10,1,now(),now(),2,'building',2,'����');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,17,1,now(),now(),2,'building',2,'����');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,25,1,now(),now(),2,'building',2,'����');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,32,1,now(),now(),2,'building',2,'����');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,50,1,now(),now(),2,'building',2,'����');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,57,1,now(),now(),2,'building',2,'����');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,65,1,now(),now(),2,'building',2,'����');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,72,1,now(),now(),2,'building',2,'����');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,66,1,now(),now(),2,'building',2,'����');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,59,1,now(),now(),2,'building',2,'����');
insert into map_position (map_code,position_code,position_flag,position_date,last_position_date,item_code,item_id,item_genre,item_name)values(1,53,1,now(),now(),2,'building',2,'����');
D1->C1->B2->A2->B3->c3->D4->E4->H1->I1->J2->K2->J3->I3->H4->G4
22->15->9 ->2-> 10->17->25->32->50->57->65->72->66->59->53->46

F2,E2,F3,G2
37,30,38,44


CREATE TABLE `member_positions` (
  `member_positions_code` int(11) NOT NULL auto_increment,
  `member_code` int(11) default NULL,
  `mixi_account_code` int(11) default NULL,
  `map_code` int(11) default NULL,
  `position_code` int(11) default NULL,
  `position_flag` int(11) default NULL,
  `position_date` date default NULL,
  `last_position_date` date default NULL,
  `item_code` int(11) default NULL,
  `item_id` varchar(250) default NULL,
  `item_genre` int(11) default NULL,
  `item_name` varchar(250) default NULL,
  PRIMARY KEY  (`member_position_code`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

CREATE TABLE `m_item` (
  `item_code` int(11) NOT NULL auto_increment,
  `item_id` varchar(250) default NULL,
  `item_genre` int(11) default NULL,
  `item_name` varchar(250) default NULL,
  PRIMARY KEY  (`item_code`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;


CREATE TABLE `m_position` (
  `position_code` int(11) default NULL,
  `position_id` varchar(250) default NULL
) TYPE=InnoDB;


E1->D2->C2->D3->E3->F4->G3->H3->I2->H2->G1->F1
29->23->16->24->31->39->45->52->58->51->43->36


D1->C1->B2->A2->B3->c3->D4->E4->H1->I1->J2->K2->J3->I3->H4
22->15->9 ->1-> 10->17->25->32->50->57->65->72->66->59->53

F2,E2,F3,G2
37,30,38,44


INSERT INTO `m_position` (`position_code`, `position_id`) VALUES
(1, 'A1'),
(2, 'A2'),
(3, 'A3'),
(4, 'A4'),
(5, 'A5'),
(6, 'A6'),
(7, 'A7'),
(8, 'B1'),
(9, 'B2'),
(10, 'B3'),
(11, 'B4'),
(12, 'B5'),
(13, 'B6'),
(14, 'B7'),
(15, 'C1'),
(16, 'C2'),
(17, 'C3'),
(18, 'C4'),
(19, 'C5'),
(20, 'C6'),
(21, 'C7'),
(22, 'D1'),
(23, 'D2'),
(24, 'D3'),
(25, 'D4'),
(26, 'D5'),
(27, 'D6'),
(28, 'D7'),
(29, 'E1'),
(30, 'E2'),
(31, 'E3'),
(32, 'E4'),
(33, 'E5'),
(34, 'E6'),
(35, 'E7'),
(36, 'F1'),
(37, 'F2'),
(38, 'F3'),
(39, 'F4'),
(40, 'F5'),
(41, 'F6'),
(42, 'F7'),
(43, 'G1'),
(44, 'G2'),
(45, 'G3'),
(46, 'G4'),
(47, 'G5'),
(48, 'G6'),
(49, 'G7'),
(50, 'H1'),
(51, 'H2'),
(52, 'H3'),
(53, 'H4'),
(54, 'H5'),
(55, 'H6'),
(56, 'H7'),
(57, 'I1'),
(58, 'I2'),
(59, 'I3'),
(60, 'I4'),
(61, 'I5'),
(62, 'I6'),
(63, 'I7'),
(64, 'J1'),
(65, 'J2'),
(66, 'J3'),
(67, 'J4'),
(68, 'J5'),
(69, 'J6'),
(70, 'J7'),
(71, 'K1'),
(72, 'K2'),
(73, 'K3'),
(74, 'K4'),
(75, 'K5'),
(76, 'K6'),
(77, 'K7'),
(78, 'L1'),
(79, 'L2'),
(80, 'L3'),
(81, 'L4'),
(82, 'L5'),
(83, 'L6'),
(84, 'L7'),
(85, 'M1'),
(86, 'M2'),
(87, 'M3'),
(88, 'M4'),
(89, 'M5'),
(90, 'M6'),
(91, 'M7'),
(92, 'N1'),
(93, 'N2'),
(94, 'N3'),
(95, 'N4'),
(96, 'N5'),
(97, 'N6'),
(98, 'N7'),
(99, 'O1'),
(100, 'O2'),
(101, 'O3'),
(102, 'O4'),
(103, 'O5'),
(104, 'O6'),
(105, 'O7'),
(106, 'P1'),
(107, 'P2'),
(108, 'P3'),
(109, 'P4'),
(110, 'P5'),
(111, 'P6'),
(112, 'P7'),
(113, 'Q1'),
(114, 'Q2'),
(115, 'Q3'),
(116, 'Q4'),
(117, 'Q5'),
(118, 'Q6'),
(119, 'Q7'),
(120, 'R1'),
(121, 'R2'),
(122, 'R3'),
(123, 'R4'),
(124, 'R5'),
(125, 'R6'),
(126, 'R7'),
(127, 'S1'),
(128, 'S2'),
(129, 'S3'),
(130, 'S4'),
(131, 'S5'),
(132, 'S6'),
(133, 'S7');