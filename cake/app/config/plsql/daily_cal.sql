delimiter //
drop procedure daily_cal//
create procedure daily_cal()
begin
    declare done int;
    declare local_member_code int;
    declare local_todays_sales_product_count int;
    declare local_money int;
    declare local_message_txt varchar(250);
    declare local_add_price int;
    declare local_added_price int;

    declare cur cursor for
        select
            member_code,
            todays_sales_product_count,
            money
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
            local_todays_sales_product_count,
            local_money
        ;

        set local_add_price = local_todays_sales_product_count * 5 + 150;
        if local_todays_sales_product_count = 0 then
            set local_add_price = 0;
        end if;
        set local_added_price = local_money + local_add_price;

        update
            members
        set
            money = local_added_price,
            todays_sales_product_count = 0
        where
            member_code = local_member_code
        ;

        set local_message_txt = concat(local_todays_sales_product_count,'杯分の利益で->',local_add_price,'銭が加算されました。');
        insert into member_message(
            member_code,message_category,message_txt,message_accept_date
        )values(
            local_member_code,1,local_message_txt,now()
        );

    end while;
    close cur;
end
//
delimiter ;