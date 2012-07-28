delimiter //
drop procedure get_exp//
create PROCEDURE `get_exp`(in local_member_code int,in local_event_code int)
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
        target_point
    into
        local_txt,
        local_target_point
    from
        m_event
    where
        event_code = local_event_code
    ;

    if local_target_point > 0 then
        set local_message_txt = concat('',local_txt,'',local_target_point,'EXPプラス！');
    else
        set local_message_txt = concat('',local_txt,'',local_target_point,'EXPマイナス！');
    end if;

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