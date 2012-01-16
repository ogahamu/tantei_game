delimiter //
drop procedure get_money//
create procedure get_money(in local_member_id int,in local_target_price int,in local_get_star_count int)
begin
    declare local_money int;
    declare local_star_count int;

    select
        money,
        star_count
    into
        local_money,
        local_money
    from
        members
    where
        id = local_member_id
    ;
    update
        members
    set
        money = local_money+local_target_price,
        star_count = local_star_count + local_get_star_count,
        update_date = now()
    where
        id = local_member_id
    ;
end
//
delimiter ;