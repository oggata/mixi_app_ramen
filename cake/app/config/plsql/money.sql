delimiter //
drop procedure money//
create procedure money(in local_member_code int,in local_event_code int)
begin
    declare local_price int;
    declare local_message_txt varchar(250);
    declare local_added_price int;
    declare local_target_point int;
    declare local_txt varchar(250);

    /*イベントを取得する*/
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

    /*現在の所持金を取得*/
    select
        money
    into
        local_price
    from
        members
    where
        member_code = local_member_code
    ;

    /*お金がＵＰした場合、理由を取得してメッセージに入れる*/
    if local_target_point > 0 then
        set local_message_txt = concat('',local_txt,'',local_target_point,'円プラス！');
    else
        /*お金がＤＯＷＮした場合、理由を取得してメッセージに入れる*/
        set local_message_txt = concat('',local_txt,'',local_target_point,'円マイナス！');
    end if;

    /*加算または減算する*/
    set local_added_price = local_price + local_target_point;

    /*お金が０円以下はありえない*/
    if local_added_price < 0 then
        set local_added_price = 0;
    end if;

    update members set money = local_added_price where member_code = local_member_code;

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

end
//
delimiter ;