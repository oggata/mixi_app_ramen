delimiter //
drop procedure product_manage//
create procedure product_manage(in local_product_code int)
begin
    declare local_price int;
    declare local_c_1_code int;
    declare local_c_2_code int;
    declare local_c_3_code int;
    declare local_c_4_code int;
    declare local_c_5_code int;
    declare local_c_6_code int;
    declare local_c_7_code int;
    declare local_c_8_code int;
    declare local_c_9_code int;
    declare local_c_10_code int;
    declare local_member_code int;
    declare local_product_volume_point int;
    declare local_product_soup_type_code int;
    declare local_kotteri_point_2 int;
    declare local_price_2 int;
    declare local_product_men_type_code int;
    declare local_price_3 int;
    declare local_kotteri_point_4 int;
    declare local_price_4 int;
    declare local_kotteri_point_5 int;
    declare local_price_5 int;
    declare local_kotteri_point_6 int;
    declare local_price_6 int;
    declare local_kotteri_point_7 int;
    declare local_price_7 int;
    declare local_kotteri_point_8 int;
    declare local_price_8 int;
    declare local_kotteri_point_9 int;
    declare local_price_9 int;
    declare local_kotteri_point_10 int;
    declare local_price_10 int;
    declare local_product_kotteri_point int;
    declare local_product_price int;

    select
        c_1_code,
        c_2_code,
        c_3_code,
        c_4_code,
        c_5_code,
        c_6_code,
        c_7_code,
        c_8_code,
        c_9_code,
        c_10_code,
        member_code
    into
        local_c_1_code,
        local_c_2_code,
        local_c_3_code,
        local_c_4_code,
        local_c_5_code,
        local_c_6_code,
        local_c_7_code,
        local_c_8_code,
        local_c_9_code,
        local_c_10_code,
        local_member_code
    from
        product
    where
        product_code = local_product_code;


    set local_product_volume_point = 0;
    if local_c_4_code > 0 then
        set local_product_volume_point = local_product_volume_point + 1;
    end if;
    if local_c_5_code > 0 then
        set local_product_volume_point = local_product_volume_point + 1;
    end if;
    if local_c_6_code > 0 then
        set local_product_volume_point = local_product_volume_point + 1;
    end if;
    if local_c_7_code > 0 then
        set local_product_volume_point = local_product_volume_point + 1;
    end if;
    if local_c_8_code > 0 then
        set local_product_volume_point = local_product_volume_point + 1;
    end if;
    if local_c_9_code > 0 then
        set local_product_volume_point = local_product_volume_point + 1;
    end if;
    if local_c_10_code > 0 then
        set local_product_volume_point = local_product_volume_point + 1;
    end if;

    /*スープ*/
    select
        soup_type_code,kotteri_point,price
    into
        local_product_soup_type_code,local_kotteri_point_2,local_price_2
    from
        material
    where
        material_code = local_c_2_code;

    /*麺*/
    select
        men_type_code,price
    into
        local_product_men_type_code,local_price_3
    from
        material
    where
        material_code = local_c_3_code;

    /*具*/
    select
        kotteri_point,price
    into
        local_kotteri_point_4,local_price_4
    from
        material
    where
        material_code = local_c_4_code;

    /*具*/
    select
        kotteri_point,price
    into
        local_kotteri_point_5,local_price_5
    from
        material
    where
        material_code = local_c_5_code;

    /*具*/
    select
        kotteri_point,price
    into
        local_kotteri_point_6,local_price_6
    from
        material
    where
        material_code = local_c_6_code;

    /*具*/
    select
        kotteri_point,price
    into
        local_kotteri_point_7,local_price_7
    from
        material
    where
        material_code = local_c_7_code;

    /*具*/
    select
        kotteri_point,price
    into
        local_kotteri_point_8,local_price_8
    from
        material
    where
        material_code = local_c_8_code;

    set local_product_kotteri_point =
    local_kotteri_point_2 + local_kotteri_point_4 + local_kotteri_point_5 +
    local_kotteri_point_6 + local_kotteri_point_7 + local_kotteri_point_8
    ;

    set local_product_price = local_price_2 + local_price_3 + local_price_4
+ local_price_5 + local_price_6 + local_price_7 + local_price_8;


    if local_product_kotteri_point < 0 then
        set local_product_kotteri_point = 0;
    end if;
    if local_product_kotteri_point > 5 then
        set local_product_kotteri_point = 5;
    end if;
    if local_product_volume_point < 0 then
        set local_product_volume_point = 0;
    end if;
    if local_product_volume_point > 5 then
        set local_product_volume_point = 5;
    end if;


    update product set
        product_men_type_code = local_product_men_type_code,
        product_soup_type_code = local_product_soup_type_code,
        product_kotteri_point = local_product_kotteri_point,
        product_volume_point = local_product_volume_point,
        product_price = local_product_price
    where
        product_code = local_product_code;

end
//
delimiter ;