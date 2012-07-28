delimiter //
drop procedure make_battle//
create procedure make_battle()
begin
    declare local_member_code int;
    declare local_enemy_code int;
    declare local_enemy_name varchar(250);
    declare local_level int;
    declare local_appearance_rate int;
    declare local_enemy_comment varchar(250);
    declare local_weak_point_genre int;
    declare local_hp int;
    declare local_attack_power int;
    declare local_attack_building_power int;
    declare local_position_code int;
    declare local_position_id varchar(250);
    declare local_appear_message_txt longtext;
    declare local_helo_position_code int;
    declare local_helo_position_id varchar(250);
    declare local_attribute_code int;
    declare local_m_state_code int;
    declare local_enemy_id varchar(250);
    declare local_all_member_count int;
    declare local_appear_count int;
    declare local_m_position_enemy_count int;
    declare local_defence_power int;
    declare local_agile_power int;
    declare local_resolved_exp int;
    declare local_enemy_hp int;
    declare local_agire_power int;
    declare local_enemy_attack_power int;
    declare local_resolved_price int;
    declare local_member_level int;
    declare local_map_code int;
    declare local_map_lv int;
    declare done int;
    declare cur cursor for
        /*平和な会員を取得して、敵を配置する(建物が全壊しているマップは除く）*/
       select
            m_member.member_code,
            m_member.m_state_code,
            m_member.level,
            m_member.map_code
        from
            m_member,member_map_state
        where
            m_member.map_code = member_map_state.map_code and
            /*member_map_state.building_count <> 0 and*/
            /*m_member.building_count <> 0 and*/
            not exists(
                select
                    m_member.member_code
                from
                    m_member,battle_state
                where
                    m_member.member_code = battle_state.member_code and
                    battle_state.resolved_flag = 0
                group by
                    m_member.member_code
            )
        group by
            m_member.member_code,
            m_member.m_state_code,
            m_member.level,
            m_member.map_code
        order by rand() limit 100
        ;
    declare exit handler for not found set done = 0;

    set done = 1;
    open cur;

    while done do
        fetch cur into
            local_member_code,
            local_m_state_code,
            local_member_level,
            local_map_code
        ;

        /*会員数を調べて、その３０％が敵の出現率となる*/
        select count(*) into local_all_member_count from m_member;
        set local_appear_count = truncate(local_all_member_count * 0.3,0);
        /*set local_appear_count = truncate(local_all_member_count * 1,0);*/
        select count(*) into local_m_position_enemy_count from member_position where item_genre = 64;

        if local_m_position_enemy_count <= local_appear_count then

            /*マップを一旦クリーンに(帰り漏れた敵などを帰宅）*/
            delete from member_position where item_genre = 64 and member_code = local_member_code;

            /*マップのレベルを取得*/
            select
                map_lv
            into
                local_map_lv
            from
                m_map
            where
                m_map_code = local_map_code;

            /*怪獣の情報を取得*/
            select
                enemy_code,
                enemy_name,
                enemy_id,
                level,
                appearance_rate,
                enemy_comment,
                weak_point_genre,
                hp,
                attack_power,
                defence_power,
                agile_power,
                attack_building_power,
                resolved_exp,
                resolved_price,
                attribute_code
            into
                local_enemy_code,
                local_enemy_name,
                local_enemy_id,
                local_level,
                local_appearance_rate,
                local_enemy_comment,
                local_weak_point_genre,
                local_hp,
                local_attack_power,
                local_defence_power,
                local_agile_power,
                local_attack_building_power,
                local_resolved_exp,
                local_resolved_price,
                local_attribute_code
            from
                enemy_data
            where
                level >= local_map_lv and
                level <= local_map_lv + 2
            order by
                rand() limit 1
            ;

            /*怪獣の出現ポイントを取得*/
            select
                position_code,
                position_id
            into
                local_position_code,
                local_position_id
            from
                m_position
            where
                position_code in (
                    26,31,32,39,40,45,46,53,54,59,60,67,68,73,74
                ) and
                position_code not in (
                    select
                        position_code
                    from
                        member_position
                    where
                        member_code = local_member_code
                        and map_code = local_map_code
                )
            order by rand() limit 1
            ;

            insert into member_position (
                member_code,
                mixi_account_code,
                map_code,
                position_code,
                position_flag,
                position_date,
                item_code,
                item_id,
                item_genre,
                item_name,
                item_price,
                item_power,
                item_max_power
            )values(
                local_member_code,
                1,
                local_map_code,
                local_position_code,
                1,
                now(),
                0,
                local_enemy_id,
                64,
                local_enemy_name,
                0,
                0,
                0
            );

            /*ヒーローの出現ポイントを取得*/
            select
                position_code,
                position_id
            into
                local_helo_position_code,
                local_helo_position_id
            from
                m_position
            where
                position_code in (
                    23,24,29,30,37,38,43,44,51,52,57,58,65,66,72
                ) and
                position_code not in (
                    select
                        position_code
                    from
                        member_position
                    where
                        member_code = local_member_code
                        and map_code = local_map_code
                )
            order by rand() limit 1
            ;

            /*6:出張中や5:休養中の場合は自動的にはいらない*/
            if local_m_state_code = 2 or local_m_state_code = 3 or local_m_state_code = 4 then
                insert into member_position (
                    member_code,
                    mixi_account_code,
                    map_code,
                    position_code,
                    position_flag,
                    position_date,
                    item_code,
                    item_id,
                    item_genre,
                    item_name,
                    item_price,
                    item_power,
                    item_max_power
                )values(
                    local_member_code,
                    1,
                    local_map_code,
                    local_helo_position_code,
                    1,
                    now(),
                    0,
                    local_member_code,
                    32,
                    '主人公',
                    0,
                    0,
                    0
                );
                /*出動中にする*/
                update m_member set m_state_code = 1,m_state_name = '魔神出撃' where member_code = local_member_code;
            end if;

            /*戦闘準備にはいる*/
            insert into battle_state (
                member_code,
                map_code,
                map_id,
                battle_start_time,
                battle_finished_time,
                enemy_code,
                enemy_name,
                enemy_id,
                enemy_hp,
                enemy_max_hp,
                enemy_attack_power,
                enemy_building_attack_power,
                enemy_defence_power,
                enmey_agire_power,
                enemy_resolved_exp,
                enemy_resolved_price,
                target_position_code,
                last_update_date,
                resolved_flag,
                attribute_code
            ) values(
                local_member_code,/*member_code*/
                local_map_code,/*map_code*/
                1,/*map_id*/
                now(),/*battle_start_time*/
                null,/*battle_finished_time*/
                local_enemy_code,/*enemy_code*/
                local_enemy_name,/*enemy_name*/
                local_enemy_id,/*enemy_id*/
                local_hp,/*enemy_hp*/
                local_hp,/*enemy_max_hp*/
                local_attack_power,/*enemy_attack_power*/
                local_attack_building_power,/*enemy_building_attack_power*/
                local_defence_power,/*enemy_defence_power*/
                local_agile_power,/*enmey_agire_power*/
                local_resolved_exp,/*enemy_resolved_exp*/
                local_resolved_price,/*enemy_resolved_price*/
                0,/*target_position_code*/
                now(),/*last_update_date*/
                0,/*resolved_flag*/
                local_attribute_code/*attribute_code*/
            );
            select
                concat(local_enemy_name,'が出現しました。')
            into
                local_appear_message_txt;

            insert member_message (member_code,message_title,decision_date,message_type_code,icon_id)values(local_member_code,local_appear_message_txt,now(),3,local_enemy_id);
        end if;
    end while;
    close cur;
end
//
delimiter ;