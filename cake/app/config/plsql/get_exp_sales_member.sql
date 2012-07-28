delimiter //
drop procedure get_exp_sales_member//
create procedure get_exp_sales_member(in local_member_code int,in local_get_exp int)
begin
    declare local_exp int;
    declare local_sum_exp int;
    declare local_lv int;
    declare local_next_level int;
    declare local_next_level_sum_exp int;
    declare local_added_exp int;
    declare local_least_next_exp int;
    declare local_message_txt_lv varchar(250);
    declare local_message_txt varchar(250);
    declare local_target_point int;
    declare local_m_lv int;
    declare local_m_exp int;
    declare local_m_sum_exp int;
    declare local_m_dan_name varchar(250);
    declare local_added_sum_exp int;

    /*現在の経験値を取得する*/
    select
        exp,sum_exp,lv
    into
        local_exp,local_sum_exp,local_lv
    from
        members
    where
        member_code = local_member_code;

    set local_message_txt = '出展先の町が食べました';
    set local_target_point = local_get_exp;

    /*メッセージを入れる*/
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

    /*加算する*/
    set local_added_sum_exp = local_sum_exp + local_get_exp;

    /*現在の経験値でのＬＶを取得*/
    select
        lv,exp,sum_exp,dan_name
    into
        local_m_lv,local_m_exp,local_m_sum_exp,local_m_dan_name
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

    /*残りレベルを計算する*/
    set local_least_next_exp = local_m_sum_exp - local_added_sum_exp;
    set local_added_exp = local_m_exp - local_least_next_exp;

    /*もしレベルが上がっていれば・・*/
    if local_lv < local_m_lv then
        /*レベルと残りEXPを計算する*/
        update
            members
        set
            lv = local_m_lv,
            least_next_exp = local_least_next_exp,
            exp = local_added_exp,
            sum_exp = local_added_sum_exp,
            lv_comment = local_m_dan_name
        where
            member_code = local_member_code
        ;
        /*メッセージの追記*/
        select
            concat('',local_m_dan_name,'の称号を獲得しました。')
        into
            local_message_txt_lv;
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
    /*レベルが上がってなければ・・*/
        /*EXPと次へのEXPをアップデートする*/
        update
            members
        set
            least_next_exp = local_least_next_exp,
            exp = local_added_exp,
            sum_exp = local_added_sum_exp,
            lv_comment = local_m_dan_name
        where
            member_code = local_member_code;
    end if;

end
//
delimiter ;