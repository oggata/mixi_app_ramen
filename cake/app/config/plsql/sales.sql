delimiter //
drop procedure sales//
create procedure sales(in local_prefecture_code int,in local_product_code int)
begin
    declare local_price int;
    declare local_goal_men_type_code int;
    declare local_goal_soup_type_code int;
    declare local_goal_product_price int;
    declare local_goal_kotteri_point int;
    declare local_goal_volume_point int;
    declare local_hissu_material_code1 int;
    declare local_hissu_material_code2 int;
    declare local_hissu_material_code3 int;
    declare local_product_men_type_code int;
    declare local_product_soup_type_code int;
    declare local_product_price int;
    declare local_product_kotteri_point int;
    declare local_product_volume_point int;
    declare local_point int;
    declare target_price int;
    declare target_kotteri_point int;
    declare target_volume_point int;
    declare local_comment_genre int;
    declare local_A_comment varchar(250);
    declare local_B_comment varchar(250);
    declare local_C_comment varchar(250);
    declare local_D_comment varchar(250);
    declare local_E_comment varchar(250);
    declare local_F_comment varchar(250);
    declare local_G_comment varchar(250);
    declare local_H_comment varchar(250);
    declare local_I_comment varchar(250);
    declare local_export_comment varchar(250);
    declare local_c1_code int;
    declare local_c2_code int;
    declare local_c3_code int;
    declare local_c4_code int;
    declare local_c5_code int;
    declare local_c6_code int;
    declare local_c7_code int;
    declare local_c8_code int;
    declare local_c9_code int;
    declare local_c10_code int;
    declare local_member_code int;
    declare local_material_name_1 varchar(250);
    declare local_material_name_2 varchar(250);
    declare local_material_name_3 varchar(250);
    declare local_sum_exp int;
    declare local_sales_product_count int;
    declare local_todays_sales_product_count int;
    declare local_add_product_count int;
    declare local_added_product_count int;
    declare local_added_todays_product_count int;
    declare local_message_txt  varchar(250);
    declare local_sales_count int;
    declare local_max_point int;
    declare local_sales_history_code int;
    declare local_town_name varchar(250);
    declare local_parent_material_code_1 int;
    declare local_parent_material_name_1 varchar(250);
    declare local_parent_material_code_2 int;
    declare local_parent_material_name_2 varchar(250);
    declare local_parent_material_code_3 int;
    declare local_parent_material_name_3 varchar(250);
    declare local_parent_material_code_4 int;
    declare local_parent_material_name_4 varchar(250);
    declare local_parent_material_code_5 int;
    declare local_parent_material_name_5 varchar(250);
    declare local_parent_material_code_6 int;
    declare local_parent_material_name_6 varchar(250);
    declare local_parent_material_code_7 int;
    declare local_parent_material_name_7 varchar(250);
    declare local_parent_material_code_8 int;
    declare local_parent_material_name_8 varchar(250);
    declare local_parent_material_code_9 int;
    declare local_parent_material_name_9 varchar(250);
    declare local_parent_material_code_10 int;
    declare local_parent_material_name_10 varchar(250);
    declare local_exp_up_comment varchar(250);
    declare local_town_human_code int;
    declare local_goal_men_type_name varchar(250);
    declare local_goal_soup_type_name varchar(250);

    select
        member_name,
        goal_men_type_code,
        goal_soup_type_code,
        goal_product_price,
        goal_kotteri_point,
        goal_volume_point,
        hissu_material_code1,
        hissu_material_code2,
        hissu_material_code3
    into
        local_town_name,
        local_goal_men_type_code,
        local_goal_soup_type_code,
        local_goal_product_price,
        local_goal_kotteri_point,
        local_goal_volume_point,
        local_hissu_material_code1,
        local_hissu_material_code2,
        local_hissu_material_code3
    from
        member_town_taste
    where
        member_code = local_prefecture_code
    ;

    select
        member_code,
        c_1_code,
        c_2_code,
        c_3_code,
        c_4_code,
        c_5_code,
        c_6_code,
        c_7_code,
        c_8_code,
        c_9_code,
        c_10_code,
        ifnull(product_price,0),
        ifnull(product_kotteri_point,0),
        ifnull(product_volume_point,0)
    into
        local_member_code,
        local_c1_code,
        local_c2_code,
        local_c3_code,
        local_c4_code,
        local_c5_code,
        local_c6_code,
        local_c7_code,
        local_c8_code,
        local_c9_code,
        local_c10_code,
        local_product_price,
        local_product_kotteri_point,
        local_product_volume_point
    from
        product
    where
        product_code = local_product_code
    ;

    select
        parent_material.parent_material_code,
        parent_material.parent_material_name
    into
        local_parent_material_code_1,
        local_parent_material_name_1
    from
        parent_material,material
    where
        parent_material.parent_material_code = material.parent_material_code and
        material.material_code = local_c1_code;

    select
        parent_material.parent_material_code,
        parent_material.parent_material_name
    into
        local_parent_material_code_2,
        local_parent_material_name_2
    from
        parent_material,material
    where
        parent_material.parent_material_code = material.parent_material_code and
        material.material_code = local_c2_code;

    select
        parent_material.parent_material_code,
        parent_material.parent_material_name
    into
        local_parent_material_code_3,
        local_parent_material_name_3
    from
        parent_material,material
    where
        parent_material.parent_material_code = material.parent_material_code and
        material.material_code = local_c3_code;

    select
        parent_material.parent_material_code,
        parent_material.parent_material_name
    into
        local_parent_material_code_4,
        local_parent_material_name_4
    from
        parent_material,material
    where
        parent_material.parent_material_code = material.parent_material_code and
        material.material_code = local_c4_code;

    select
        parent_material.parent_material_code,
        parent_material.parent_material_name
    into
        local_parent_material_code_5,
        local_parent_material_name_5
    from
        parent_material,material
    where
        parent_material.parent_material_code = material.parent_material_code and
        material.material_code = local_c5_code;

    select
        parent_material.parent_material_code,
        parent_material.parent_material_name
    into
        local_parent_material_code_6,
        local_parent_material_name_6
    from
        parent_material,material
    where
        parent_material.parent_material_code = material.parent_material_code and
        material.material_code = local_c6_code;

    select
        parent_material.parent_material_code,
        parent_material.parent_material_name
    into
        local_parent_material_code_7,
        local_parent_material_name_7
    from
        parent_material,material
    where
        parent_material.parent_material_code = material.parent_material_code and
        material.material_code = local_c7_code;

    select
        parent_material.parent_material_code,
        parent_material.parent_material_name
    into
        local_parent_material_code_8,
        local_parent_material_name_8
    from
        parent_material,material
    where
        parent_material.parent_material_code = material.parent_material_code and
        material.material_code = local_c8_code;

    select
        parent_material.parent_material_code,
        parent_material.parent_material_name
    into
        local_parent_material_code_9,
        local_parent_material_name_9
    from
        parent_material,material
    where
        parent_material.parent_material_code = material.parent_material_code and
        material.material_code = local_c9_code;

    select
        parent_material.parent_material_code,
        parent_material.parent_material_name
    into
        local_parent_material_code_10,
        local_parent_material_name_10
    from
        parent_material,material
    where
        parent_material.parent_material_code = material.parent_material_code and
        material.material_code = local_c10_code;


    select
        parent_material_name
    into
        local_goal_men_type_name
    from
        parent_material
    where
        parent_material_code = local_goal_men_type_code;


    set local_point = 0;
    if local_parent_material_code_3 = local_goal_men_type_code then
        set local_point = local_point + 10;
        set local_A_comment = concat(local_parent_material_name_2,'スープに',local_goal_men_type_name,'は合うね！最高！');
    else
        set local_A_comment = concat(local_parent_material_name_2,'スープには',local_goal_men_type_name,'のがいいなぁ！残念');
    end if;

    select
        parent_material_name
    into
        local_goal_soup_type_name
    from
        parent_material
    where
        parent_material_code = local_goal_soup_type_code;

    if local_parent_material_code_2 = local_goal_soup_type_code then
        set local_point = local_point + 10;
        set local_B_comment = concat('',local_goal_soup_type_name,'スープは最高だね！美味しい！');
    else
        set local_B_comment = concat('',local_goal_soup_type_name,'スープの方がよかったなぁ！残念！');
    end if;


    set target_price = local_goal_product_price - local_product_price;
    if target_price >= 1000 then
        set local_point = local_point + 5;
        set local_C_comment = 'もう少し値段が高くても美味しいものが食べたいなぁ';
    elseif target_price >= 500 then
        set local_point = local_point + 10;
        set local_C_comment = '値段がちょっと安すぎだね';
    elseif target_price >= 0 then
        set local_point = local_point + 15;
        set local_C_comment = '値段はちょうどいいね';
    elseif target_price >= -500 then
        set local_point = local_point + 10;
        set local_C_comment = 'ちょっと値段が高いみたい';
    elseif target_price >= -1000 then
        set local_point = local_point + 5;
        set local_C_comment = '値段が高すぎて手がでないよ。。';
    else
        set local_point = local_point + 0;
        set local_C_comment = '値段は普通。。';
    end if;


    set target_kotteri_point=local_goal_kotteri_point-local_product_kotteri_point;
    if target_kotteri_point > 4 then
        set local_point = local_point + 5;
        set local_D_comment = '全体的にこってり感が物足りない。がつんと欲しいね。';
    elseif target_kotteri_point > 2 then
        set local_point = local_point + 10;
        set local_D_comment = 'もう少し濃厚な方がいいな';
    elseif target_kotteri_point > 0 then
        set local_point = local_point + 15;
        set local_D_comment = '全体の濃厚さのバランスは丁度いいね';
    elseif target_kotteri_point > -3 then
        set local_point = local_point + 10;
        set local_D_comment = 'ちょっと全体的に味が濃いかなぁ';
    elseif target_kotteri_point > -5 then
        set local_point = local_point + 5;
        set local_D_comment = 'ちょっと全体的に重た過ぎるね。。明日もたれそう・・。';
    else
        set local_point = local_point + 0;
        set local_D_comment = '全体的に普通・・。';
    end if;


    set target_volume_point = local_goal_volume_point - local_product_volume_point;
    if target_volume_point >= 5 then
        set local_point = local_point + 5;
        set local_E_comment = 'うーんシンプル過ぎるかな。ボリューム不足。';
    elseif target_volume_point >= 2 then
        set local_point = local_point + 10;
        set local_E_comment = 'もう少し具が乗ってたらよかったのに';
    elseif target_volume_point >= 0 then
        set local_point = local_point + 15;
        set local_E_comment = '丁度良いボリュームだね';
    elseif target_volume_point >= -2 then
        set local_point = local_point + 10;
        set local_E_comment = '具が多すぎて麺が生きてないね';
    elseif target_volume_point >= -5 then
        set local_point = local_point + 5;
        set local_E_comment = '具が盛り過ぎて・・';
    else
        set local_point = local_point + 0;
        set local_E_comment = 'ボリュームは普通・・。';
    end if;

    select
        parent_material_name
    into
        local_material_name_1
    from
        parent_material
    where
        parent_material_code = local_hissu_material_code1;



    if  local_hissu_material_code1 = local_parent_material_code_4 or
        local_hissu_material_code1 = local_parent_material_code_5 or
        local_hissu_material_code1 = local_parent_material_code_6 or
        local_hissu_material_code1 = local_parent_material_code_7 or
        local_hissu_material_code1 = local_parent_material_code_8 or
        local_hissu_material_code1 = local_parent_material_code_9 then
        set local_point = local_point + 5;
        set local_F_comment = concat('ラーメンに',local_material_name_1,'は合うね！最高！');
    else
        set local_F_comment = concat('',local_material_name_1,'が入ってないからちょっと不満・・。,');
    end if;


    select
        parent_material_name
    into
        local_material_name_2
    from
        parent_material
    where
        parent_material_code = local_hissu_material_code2;



    if  local_hissu_material_code2 = local_parent_material_code_4 or
        local_hissu_material_code2 = local_parent_material_code_5 or
        local_hissu_material_code2 = local_parent_material_code_6 or
        local_hissu_material_code2 = local_parent_material_code_7 or
        local_hissu_material_code2 = local_parent_material_code_8 or
        local_hissu_material_code2 = local_parent_material_code_9 then
        set local_point = local_point + 5;
        set local_G_comment = concat('やっぱ',local_material_name_2,'が入ってて最高！');
    else
        set local_G_comment = concat('',local_material_name_2,'が入ってるともっとよかった,');
    end if;


    select
        parent_material_name
    into
        local_material_name_3
    from
        parent_material
    where
        parent_material_code = local_hissu_material_code3;


    if  local_hissu_material_code3 = local_parent_material_code_4 or
        local_hissu_material_code3 = local_parent_material_code_5 or
        local_hissu_material_code3 = local_parent_material_code_6 or
        local_hissu_material_code3 = local_parent_material_code_7 or
        local_hissu_material_code3 = local_parent_material_code_8 or
        local_hissu_material_code3 = local_parent_material_code_9 then
        set local_point = local_point + 5;
        set local_H_comment = concat('この',local_material_name_3,'はとてもおいしいね！');
    else
        set local_H_comment = concat('',local_material_name_3,'が無いとラーメンとは言えないかなぁ,');
    end if;

    set local_point = local_point + 20;

    if local_point >= 90 then
        set local_I_comment = '伝説の味だよ！！こんなに美味しいのははじめてだ！';
    elseif local_point >= 80 then
        set local_I_comment = 'これはおいしかった。また食べたいな。';
    elseif local_point >= 60 then
        set local_I_comment = 'まぁまぁおいしかったよ。ありがとう。';
    elseif local_point >= 40 then
        set local_I_comment = '普通の味だった。。ちょっと期待しすぎたかな。';
    elseif local_point >= 20 then
        set local_I_comment = 'あんまりおいしくなかった。。がっかり。';
    else
        set local_I_comment = '不味かった・・。二度と来ないよ。。';
    end if;

    SELECT FLOOR(1 + (RAND() * 8)) into local_comment_genre;

    if local_comment_genre = 1 then
        set local_export_comment = local_A_comment;
        set local_town_human_code = 1;
    elseif local_comment_genre = 2 then
        set local_export_comment = local_B_comment;
        set local_town_human_code = 2;
    elseif local_comment_genre = 3 then
        set local_export_comment = local_C_comment;
        set local_town_human_code = 3;
    elseif local_comment_genre = 4 then
        set local_export_comment = local_D_comment;
        set local_town_human_code = 4;
    elseif local_comment_genre = 5 then
        set local_export_comment = local_E_comment;
        set local_town_human_code = 5;
    elseif local_comment_genre = 6 then
        set local_export_comment = local_F_comment;
        set local_town_human_code = 6;
    elseif local_comment_genre = 7 then
        set local_export_comment = local_G_comment;
        set local_town_human_code = 7;
    elseif local_comment_genre = 8 then
        set local_export_comment = local_H_comment;
        set local_town_human_code = 8;
    elseif local_comment_genre = 9 then
        set local_export_comment = local_I_comment;
        set local_town_human_code = 9;
    else
        set local_export_comment = local_I_comment;
        set local_town_human_code = 9;
    end if;

    select
        sum_exp,sales_product_count,todays_sales_product_count
    into
        local_sum_exp,local_sales_product_count,local_todays_sales_product_count
    from
        members
    where
        member_code = local_member_code
    ;

    set local_add_product_count = truncate((0.0003*(local_sum_exp+3000)+2)*(local_point/100),0);
    set local_added_product_count = local_add_product_count + local_sales_product_count;
    set local_added_todays_product_count = local_add_product_count + local_todays_sales_product_count;

    update
        members
    set
        sales_product_count = local_added_product_count,
        todays_sales_product_count = local_added_todays_product_count
    where
        member_code = local_member_code;

    set local_message_txt = concat(local_export_comment,'  ',local_add_product_count,'杯売れました,','(満足度：',local_point,')');

    select
        sales_history_code,sales_count,max_point
    into
        local_sales_history_code,local_sales_count,local_max_point
    from
        sales_history
    where
        member_code = local_member_code and town_member_code = local_prefecture_code order by last_visited_date limit 1;

    if local_point > local_max_point then
        set local_max_point = local_point;
    end if;
    set local_sales_count = local_sales_count + local_add_product_count;

    update
        sales_history
    set
        sales_count = local_sales_count,
        max_point = local_max_point,
        last_visited_date = now()
    where
        sales_history_code = local_sales_history_code
    ;

    insert into member_town_valuation(
        member_code,title,member_town_code,member_town_name,product_code,decision_date,town_human_code
    )values(
        local_member_code,local_message_txt,local_prefecture_code,local_town_name,local_product_code,now(),local_town_human_code
    );

    if local_point >= 100 then
        call get_exp(local_member_code,83);
    elseif local_point >= 95 then
        call get_exp(local_member_code,82);
    elseif local_point >= 90 then
        call get_exp(local_member_code,81);
    elseif local_point >= 85 then
        call get_exp(local_member_code,80);
    elseif local_point >= 80 then
        call get_exp(local_member_code,79);
    elseif local_point >= 75 then
        call get_exp(local_member_code,78);
    elseif local_point >= 70 then
        call get_exp(local_member_code,77);
    end if;
end
//
delimiter ;