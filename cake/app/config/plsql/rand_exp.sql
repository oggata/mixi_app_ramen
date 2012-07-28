delimiter //
drop procedure rand_exp//
create procedure money(in local_member_code int,in local_input_exp int)
begin
    declare local_price int;
    declare local_message_txt varchar(250);
    declare local_added_price int;
    declare local_target_point int;

    if local_input_exp > 0 then
        select
            txt,target_point
        into
            local_message_txt,local_target_point
        from
            m_event
        where
            genre_code = 2 and
            target_point > 0
        order by rand() limit 1;
    else
        select
            txt,target_point
        into
            local_message_txt,local_target_point
        from
            m_event
        where
            genre_code = 2 and
            target_point < 0
        order by rand() limit 1;
    end if;

end
//
delimiter ;