delimiter //
drop procedure customer//
create procedure customer(in local_prefecture_code int,in local_product_code int)
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

    select
        goal_men_type_code,
        goal_soup_type_code,
        goal_product_price,
        goal_kotteri_point,
        goal_volume_point,
        hissu_material_code1,
        hissu_material_code2,
        hissu_material_code3
    into
        local_goal_men_type_code,
        local_goal_soup_type_code,
        local_goal_product_price,
        local_goal_kotteri_point,
        local_goal_volume_point,
        local_hissu_material_code1,
        local_hissu_material_code2,
        local_hissu_material_code3
    from
        m_prefecture_taste
    where
        prefecture_code = local_prefecture_code
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
        product_men_type_code,
        product_soup_type_code,
        product_price,
        product_kotteri_point,
        product_volume_point
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
        local_product_men_type_code,
        local_product_soup_type_code,
        local_product_price,
        local_product_kotteri_point,
        local_product_volume_point
    from
        product
    where
        product_code = local_product_code
    ;

    /*[1]麺の選定*/
    set local_point = 0;
    if local_product_men_type_code = local_goal_men_type_code then
        set local_point = local_point + 10;
        set local_A_comment = '麺はいいね！';
    else
        set local_A_comment = '麺はやっぱり細めんだよね';
    end if;

    /*[2]スープの選択*/
    if local_product_soup_type_code = local_goal_soup_type_code then
        set local_point = local_point + 10;
        set local_B_comment = 'スープはいいね！';
    else
        set local_B_comment = 'スープはやっぱり豚骨だよ';
    end if;

    /*[3]値段*/
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
    end if;

    /*[4]全体のさっぱりこってり*/
    set target_kotteri_point=local_goal_kotteri_point-local_product_kotteri_point;
    if target_kotteri_point > 4 then
        set local_point = local_point + 5;
        set local_D_comment = 'こってり感が物足りないかなぁ';
    elseif target_kotteri_point > 2 then
        set local_point = local_point + 10;
        set local_D_comment = 'もう少し濃厚な方がいいな';
    elseif target_kotteri_point > 0 then
        set local_point = local_point + 15;
        set local_D_comment = '丁度いいね';
    elseif target_kotteri_point > -3 then
        set local_point = local_point + 10;
        set local_D_comment = 'ちょっと薄い';
    elseif target_kotteri_point > -5 then
        set local_point = local_point + 5;
        set local_D_comment = '物足りない。がつんと欲しい';
    end if;

    /*[5]ボリューム感*/

    set target_volume_point = local_goal_volume_point - local_product_volume_point;
    if target_volume_point >= 5 then
        set local_point = local_point + 5;
        set local_E_comment = 'うーんシンプル過ぎるかな';
    elseif target_volume_point >= 2 then
        set local_point = local_point + 10;
        set local_E_comment = 'もう少し具が乗ってたらよかったのに';
    elseif target_volume_point >= 0 then
        set local_point = local_point + 15;
        set local_E_comment = '丁度良い具の量だね';
    elseif target_volume_point >= -2 then
        set local_point = local_point + 10;
        set local_E_comment = '具が多すぎて麺が生きてないね';
    elseif target_volume_point >= -5 then
        set local_point = local_point + 5;
        set local_E_comment = '具が盛り過ぎて・・';
    end if;

    /*[6]必須の具*/
    if  local_hissu_material_code1 = local_c4_code or
        local_hissu_material_code1 = local_c5_code or
        local_hissu_material_code1 = local_c6_code or
        local_hissu_material_code1 = local_c7_code or
        local_hissu_material_code1 = local_c8_code or
        local_hissu_material_code1 = local_c9_code then
        set local_point = local_point + 5;
        set local_F_comment = 'やっぱラーメンにはだよね';
    else
        set local_F_comment = 'これがあればよかったのに';
    end if;

    /*[7]必須の具2*/
    if  local_hissu_material_code2 = local_c4_code or
        local_hissu_material_code2 = local_c5_code or
        local_hissu_material_code2 = local_c6_code or
        local_hissu_material_code2 = local_c7_code or
        local_hissu_material_code2 = local_c8_code or
        local_hissu_material_code2 = local_c9_code then
        set local_point = local_point + 5;
        set local_G_comment = 'やっぱラーメンにはだよね';
    else
        set local_G_comment = 'これがあればよかったのに';
    end if;

    /*[8]必須の具3*/
    if  local_hissu_material_code3 = local_c4_code or
        local_hissu_material_code3 = local_c5_code or
        local_hissu_material_code3 = local_c6_code or
        local_hissu_material_code3 = local_c7_code or
        local_hissu_material_code3 = local_c8_code or
        local_hissu_material_code3 = local_c9_code then
        set local_point = local_point + 5;
        set local_H_comment = 'やっぱラーメンにはだよね';
    else
        set local_H_comment = 'これがあればよかったのに';
    end if;


    set local_point = local_point + 20;

    /*総合評価*/
    if local_point >= 90 then
        set local_I_comment = '伝説の味！';
    elseif local_point >= 80 then
        set local_I_comment = 'これはおいしかった';
    elseif local_point >= 60 then
        set local_I_comment = 'おいしかった';
    elseif local_point >= 40 then
        set local_I_comment = '普通';
    elseif local_point >= 20 then
        set local_I_comment = 'あんまりおいしくなかった';
    else
        set local_I_comment = '不味かった・・';
    end if;

    /*ランダムで１個コメントする箇所を選択 1-9*/
    SELECT FLOOR(1 + (RAND() * 8)) into local_comment_genre;

    if local_comment_genre = 1 then
        set local_export_comment = local_A_comment;
    elseif local_comment_genre = 2 then
        set local_export_comment = local_B_comment;
    elseif local_comment_genre = 3 then
        set local_export_comment = local_C_comment;
    elseif local_comment_genre = 4 then
        set local_export_comment = local_D_comment;
    elseif local_comment_genre = 5 then
        set local_export_comment = local_E_comment;
    elseif local_comment_genre = 6 then
        set local_export_comment = local_F_comment;
    elseif local_comment_genre = 7 then
        set local_export_comment = local_G_comment;
    elseif local_comment_genre = 8 then
        set local_export_comment = local_H_comment;
    elseif local_comment_genre = 9 then
        set local_export_comment = local_I_comment;
    end if;

    insert into
        customer_hyouka (member_code,title,product_code,decision_date)
    values
        (local_member_code,local_export_comment,local_product_code,now());

end
//
delimiter ;