delimiter //
drop procedure get_exp//
create procedure get_exp(in local_member_code int,in local_event_code int)
begin
    declare local_exp int;
    declare local_sum_exp int;
    declare local_lv int;
    declare local_next_level int;
    declare local_next_level_sum_exp int;
    declare local_added_sum_exp int;
    declare local_least_next_exp int;
    declare local_message_txt_lv varchar(250);
    declare local_message_txt varchar(250);
    declare local_target_point int;
    declare local_txt varchar(250);
    declare local_next_exp int;
    declare local_now_exp int;
    declare local_lv_comment varchar(250);
    declare local_genre_code int;

    select
        exp,
        sum_exp,
        lv
    into
        local_exp,
        local_sum_exp,
        local_lv
    from
        members
    where
        member_code = local_member_code
    ;

    select
        txt,
        target_point,
        genre_code
    into
        local_txt,
        local_target_point,
        local_genre_code
    from
        m_event
    where
        event_code = local_event_code
    ;

    if local_target_point > 0 then
        set local_message_txt = concat('',local_txt,'',local_target_point,'EXP上昇！');
    else
        set local_message_txt = concat('',local_txt,'',local_target_point,'EXP下降！');
    end if;

    if local_genre_code = 1 or local_genre_code = 2 or local_genre_code = 3 or local_genre_code = 4 or local_genre_code = 11 then
        insert into member_message (
            member_code,
            message_category,
            message_txt,
            message_accept_date
        )values(
            local_member_code,
            1,
            local_message_txt,
            now()
        );
    end if;

    set local_added_sum_exp = local_sum_exp + local_target_point;
    if local_added_sum_exp < 0 then
        set local_added_sum_exp = 0;
    end if;

    select
        lv,sum_exp,exp,dan_name
    into
        local_next_level,local_next_level_sum_exp,local_next_exp,local_lv_comment
    from
        m_lv_exp
    where
        lv = (
            select
                min(lv)
            from
                m_lv_exp
            where
                sum_exp >= local_added_sum_exp
        )
    ;

    set local_least_next_exp = -1*(local_added_sum_exp - local_next_level_sum_exp);
    set local_now_exp = local_next_exp - local_least_next_exp;

    if local_lv < local_next_level then
        update
            members
        set
            lv = local_next_level,
            least_next_exp = local_least_next_exp,
            exp = local_now_exp,
            sum_exp = local_added_sum_exp,
            lv_comment = local_lv_comment
        where
            member_code = local_member_code
        ;
        select
            concat('レベルが',local_next_level,'(',local_lv_comment,')に上昇しました。')
        into
            local_message_txt_lv
        ;

        insert member_message (
            member_code,
            message_category,
            message_txt,
            message_accept_date
        )values(
            local_member_code,
            1,
            local_message_txt_lv,
            now()
        );
    else
        update
            members
        set
            least_next_exp = local_least_next_exp,
            exp = local_now_exp,
            sum_exp = local_added_sum_exp
        where
            member_code = local_member_code
        ;
    end if;
end
//
delimiter ;