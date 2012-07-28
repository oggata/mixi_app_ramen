delimiter //
drop procedure sales_exe//
create procedure sales_exe()
begin
    declare done int;
    declare local_member_code int;
    declare local_main_product_code int;
    declare local_map_code int;

    declare cur cursor for
        select
            member_code,
            main_product_code,
            map_code
        from
            members
        where
            main_product_code <> 0
        ;

    declare exit handler for not found set done = 0;

    set done = 1;
    open cur;

    while done do
        fetch cur into
            local_member_code,
            local_main_product_code,
            local_map_code
        ;

    call sales(local_map_code,local_main_product_code);

    end while;
    close cur;
end
//
delimiter ;