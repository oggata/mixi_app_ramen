delimiter //
drop procedure change_layer//
create procedure change_layer(in local_product_code int,in local_c_code int,in move_direction_code)
begin
    declare local_price int;
    declare local_message_txt varchar(250);
    declare local_added_price int;
    declare local_target_point int;


	select
		c_4_code,c_4_id,c_4_name,
		c_5_code,c_5_id,c_5_name,
		c_6_code,c_6_id,c_6_name,
		c_7_code,c_7_id,c_7_name,
		c_8_code,c_8_id,c_8_name,
		c_9_code,c_9_id,c_9_name,
		c_10_code,c_10_id,c_10_name
	into

	from
		product
	where
		product_code = local_product_code
	;


	if local_c_code == 5 and move_direction_code = 1 then

		update product set
			c_4_code = local_c_5_code,
			c_4_id = local_c_5_id,
			c_4_name = local_c_5_name,



	end if;






end
//
delimiter ;