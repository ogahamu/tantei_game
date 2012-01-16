delimiter //
drop procedure get_bank_exp//
create procedure get_bank_exp(in local_member_id int,in local_target_point int)
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
    declare local_txt varchar(250);
    declare local_next_exp int;
    declare local_now_exp int;
    declare local_lv_comment varchar(250);

    select
        ifnull(exp,0),
        ifnull(sum_exp,0),
        ifnull(lv,1)
    into
        local_exp,
        local_sum_exp,
        local_lv
    from
        members
    where
        id = local_member_id
    ;
    set local_added_sum_exp=local_sum_exp+local_target_point;
    if local_added_sum_exp < 0 then
        set local_added_sum_exp = 0;
    end if;

    select
        lv,sum_exp,exp
    into
        local_next_level,local_next_level_sum_exp,local_next_exp
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
            lv_up_flag = 1,
            update_date = now()
        where
            id = local_member_id
        ;
        select
            concat('レベル',local_next_level,')に上昇しました。')
        into
            local_message_txt_lv
        ;
    else
        update
            members
        set
            least_next_exp = local_least_next_exp,
            exp = local_now_exp,
            sum_exp = local_added_sum_exp,
            update_date = now()
        where
            id = local_member_id
        ;
    end if;
end
//
delimiter ;