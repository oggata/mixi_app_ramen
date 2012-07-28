delimiter //
drop procedure shiire_price//
create procedure shiire_price()
begin
    declare done int;
    declare local_material_code int;
    declare local_price int;
    declare local_lv int;
    declare local_shiire_price int;

    declare cur cursor for
        select
            material_code,
            price,
            lv
        from
            material
        ;

    declare exit handler for not found set done = 0;

    set done = 1;
    open cur;

    while done do
        fetch cur into
            local_material_code,
            local_price,
            local_lv
        ;

    /*lv10で２倍 lv20で３倍 lv30で４倍*/
    set local_shiire_price = local_price * (truncate(local_lv/10,0)+2);
    update material set shiire_price = local_shiire_price where material_code = local_material_code;
    end while;
    close cur;
end
//
delimiter ;