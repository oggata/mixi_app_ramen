delete from sales_history;
delete from members;
delete from member_town_valuation;
delete from member_town_taste;
delete from product;
delete from member_message;
delete from member_material;
update members set target_code = 24;



create table parent_material(
parent_material_code int(11) NOT NULL auto_increment,
parent_material_name varchar(250),
parent_material_id varchar(250),
genre_code int,
 PRIMARY KEY  (`parent_material_code`)
)TYPE=InnoDB AUTO_INCREMENT=1;

insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(1,'通常皿','owan',1);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(2,'豚骨ベース','tonkotsu_1',2);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(3,'醤油ベース','tonkotsu_1',2);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(4,'塩ベース','tonkotsu_1',2);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(5,'味噌ベース','tonkotsu_1',2);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(6,'鳥ガラベース','tonkotsu_1',2);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(7,'魚介ベース','tonkotsu_1',2);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(8,'細ストレート麺','hoso_s',3);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(9,'太ストレート麺','futo_s',3);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(10,'細ちぢれ麺','hoso_c',3);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(11,'太ちぢれ麺','futo_c',3);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(12,'チャーシュー','chasyu_1',4);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(13,'卵','tamago',4);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(14,'ネギ','negi',4);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(15,'ほうれん草','hourensou_1',4);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(16,'海苔','nori_1',4);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(17,'もやし','moyasi_1',4);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(18,'メンマ','menma_1',4);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(19,'なると','naruto',4);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(20,'焦がしニンニク','naruto',4);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(21,'わかめ','wakame',4);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(35,'ワンタン','fukahire',4);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(36,'梅','fukahire',4);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(32,'チンゲン菜','fukahire',4);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(33,'フカヒレ','fukahire',4);
insert into parent_material (parent_material_code,parent_material_name,parent_material_id,genre_code)
values(34,'納豆','natto',4);
