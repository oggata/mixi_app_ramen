delimiter //
drop procedure update_city_count//
create procedure update_city_count()
begin
    declare done int;
    declare local_prefecture_code int;
    declare local_city_count int;

    declare cur cursor for
        select
            prefecture_code,count(*) as count
        from
            m_city
        group by
            prefecture_code
        ;
    declare exit handler for not found set done = 0;

    set done = 1;
    open cur;

    while done do
        fetch cur into
            local_prefecture_code,
            local_city_count
        ;
    update m_prefecture set city_count = local_city_count where prefecture_code = local_prefecture_code;

    end while;
    close cur;
end
//
delimiter ;