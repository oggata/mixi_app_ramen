delimiter //
drop procedure yubin_convert//
create procedure yubin_convert()
begin
    declare done int;
    declare local_prefecture_name varchar(250);
    declare local_city_name varchar(250);
    declare local_prefecture_kana varchar(250);
    declare local_city_kana varchar(250);
    declare local_prefecture_code int;

    declare cur cursor for
        /*サイコロが実行されてから１時間以内のメンバー*/
        select
            prefecture_name,
            city_name,
            prefecture_kana,
            city_kana
        from
            m_postcode
        group by
            prefecture_name,
            city_name,
            prefecture_kana,
            city_kana
        ;

    declare exit handler for not found set done = 0;

    set done = 1;
    open cur;

    while done do
        fetch cur into
            local_prefecture_name,
            local_city_name,
            local_prefecture_kana,
            local_city_kana
        ;

        select
            prefecture_code
        into
            local_prefecture_code
        from
            m_prefecture
        where
            prefecture_name = local_prefecture_name;

        insert into m_city(
            prefecture_code,
            prefecture_name,
            city_name,
            prefecture_kana,
            city_kana
        )values(
            local_prefecture_code,
            local_prefecture_name,
            local_city_name,
            local_prefecture_kana,
            local_city_kana
        );

    end while;
    close cur;
end
//
delimiter ;