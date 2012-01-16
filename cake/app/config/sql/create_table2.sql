create table m_evidences(
id int NOT NULL auto_increment,
name varchar(250),
img_id varchar(250),
PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;



create table quest_detail_titles(
id int NOT NULL auto_increment,
title_1 varchar(250),
comment_1 varchar(250),
title_2 varchar(250),
comment_2 varchar(250),
title_3 varchar(250),
comment_3 varchar(250),
PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;



事件現場で感じた違和感の原因を突き止めろ
何かおかしい。通常の事件現場にはない雰囲気の元を調べろ

複数犯の可能性あり！？
被害者に残された傷跡の形や状態が違うようだ。被害状態を観察せよ。




insert into quest_detail_titles(
title_1,
comment_1,
title_2,
comment_2,
title_3,
comment_3
)values(
'1.現場検証から手掛かりを探せ...',
'殺害現場には何か証拠になるものがあるかもしれない... ',
'2.聞き込みで怪しい人物を探せ...',
'被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',
'3.殺害トリックを導き出せ',
'いよいよ殺害を行ったトリックを考え、確信を突くのだ....'
);

insert into quest_detail_titles(
title_1,
comment_1,
title_2,
comment_2,
title_3,
comment_3,
)values(
'1.現場検証から手掛かりを探せ...',
'殺害現場には何か証拠になるものがあるかもしれない... ',
'2.聞き込みで怪しい人物を探せ...',
'被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',
'3.殺害トリックを導き出せ',
'いよいよ殺害を行ったトリックを考え、確信を突くのだ....'
);

insert into quest_detail_titles(
title_1,
comment_1,
title_2,
comment_2,
title_3,
comment_3,
)values(
'1.現場検証から手掛かりを探せ...',
'殺害現場には何か証拠になるものがあるかもしれない... ',
'2.聞き込みで怪しい人物を探せ...',
'被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',
'3.殺害トリックを導き出せ',
'いよいよ殺害を行ったトリックを考え、確信を突くのだ....'
);

insert into quest_detail_titles(
title_1,
comment_1,
title_2,
comment_2,
title_3,
comment_3,
)values(
'1.第一発見者から状況を聞け...',
'捜査の第一鉄則は第一発見者を疑うことだ... ',
'2.残された証拠から関連人物を挙げろ...',
'被害者に残された証拠から誰が関係しているのかを調べるのだ....',
'3.殺害トリックを導き出せ',
'いよいよ殺害を行ったトリックを考え、確信を突くのだ....'
);

insert into quest_detail_titles(
title_1,
comment_1,
title_2,
comment_2,
title_3,
comment_3,
)values(
'1.現場検証から手掛かりを探せ...',
'殺害現場には何か証拠になるものがあるかもしれない... ',
'2.聞き込みで怪しい人物を探せ...',
'被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',
'3.殺害トリックを導き出せ',
'いよいよ殺害を行ったトリックを考え、確信を突くのだ....'
);

insert into quest_detail_titles(
title_1,
comment_1,
title_2,
comment_2,
title_3,
comment_3,
)values(
'1.現場検証から手掛かりを探せ...',
'殺害現場には何か証拠になるものがあるかもしれない... ',
'2.聞き込みで怪しい人物を探せ...',
'被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',
'3.殺害トリックを導き出せ',
'いよいよ殺害を行ったトリックを考え、確信を突くのだ....'
);

insert into quest_detail_titles(
title_1,
comment_1,
title_2,
comment_2,
title_3,
comment_3,
)values(
'1.現場検証から手掛かりを探せ...',
'殺害現場には何か証拠になるものがあるかもしれない... ',
'2.聞き込みで怪しい人物を探せ...',
'被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',
'3.殺害トリックを導き出せ',
'いよいよ殺害を行ったトリックを考え、確信を突くのだ....'
);

insert into quest_detail_titles(
title_1,
comment_1,
title_2,
comment_2,
title_3,
comment_3,
)values(
'1.現場検証から手掛かりを探せ...',
'殺害現場には何か証拠になるものがあるかもしれない... ',
'2.聞き込みで怪しい人物を探せ...',
'被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',
'3.殺害トリックを導き出せ',
'いよいよ殺害を行ったトリックを考え、確信を突くのだ....'
);

insert into quest_detail_titles(
title_1,
comment_1,
title_2,
comment_2,
title_3,
comment_3,
)values(
'1.現場検証から手掛かりを探せ...',
'殺害現場には何か証拠になるものがあるかもしれない... ',
'2.聞き込みで怪しい人物を探せ...',
'被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',
'3.殺害トリックを導き出せ',
'いよいよ殺害を行ったトリックを考え、確信を突くのだ....'
);

delete from members;
delete from member_quests;
delete from member_evidences;
delete from member_quest_details;
delete from messages;
insert into members (id,mixi_account_id,name,power,max_power,money,lv,exp,least_next_exp,sum_exp,star_count
)values(
1,1,'TestUser',1000,1000,1000,1,0,1000,0,10);
insert into member_quests (
id,
member_id,
title,
comment,
quest_exp,
quest_price,
resolved_flag,
evidence_appear_rate,
challenge_count,
quest_id,
insert_time
)values(
100,
1,
'観覧車殺人事件',
'遊園地の観覧車内で起きた殺人事件の犯人を追え！',
300,
30,
0,
5,
4,
1,
NOW()
);
insert into member_quest_details (
member_quest_id,
detail_no,
resoluved_flag,
member_id,
title,
comment,
exp,
distance,
all_distance,
last_marker_flag,
quest_detail_id,
insert_time
)values(
100,
1,
0,
1,
'現場検証をせよ',
'現場検証を行い手掛かりを探せ',
100,
0,
100,
0,
1,
NOW()
);
select * from member_quest_details\G;

create table evidences(
id int NOT NULL auto_increment,
name varchar(250),
img_id varchar(250),
quest_id int,
quest_detail_id int,
PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;


create table member_evidences(
id int NOT NULL auto_increment,
evidence_id int,
member_id varchar(250),
PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;



create table messages(
id int NOT NULL auto_increment,
member_id int,
title varchar(250),
comment varchar(250),
genre_id int default 0 ,
read_flag int default 0 ,
insert_time datetime,
PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;




http://test4.blamestitch.com/cake/top/top/
//request 初期化
update members set member_request_id = 0,power=10000;
update member_requests set process_status = 4;
delete from member_requests;
delete from member_treasures;







insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(12,1,'現場検証を行なって手掛かりを探せ','殺害現場には何か証拠になるものがあるかもしれない...',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(12,2,'怪しい人物を特定せよ','被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(12,3,'殺害トリックを導き出せ ','いよいよ殺害を行ったトリックを考え、確信を突くのだ....',50,100,1);

insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(13,1,'現場検証を行なって手掛かりを探せ','殺害現場には何か証拠になるものがあるかもしれない...',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(13,2,'怪しい人物を特定せよ','被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(13,3,'殺害トリックを導き出せ ','いよいよ殺害を行ったトリックを考え、確信を突くのだ....',50,100,1);

insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(14,1,'現場検証を行なって手掛かりを探せ','殺害現場には何か証拠になるものがあるかもしれない...',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(14,2,'怪しい人物を特定せよ','被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(14,3,'殺害トリックを導き出せ ','いよいよ殺害を行ったトリックを考え、確信を突くのだ....',50,100,1);

insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(15,1,'現場検証を行なって手掛かりを探せ','殺害現場には何か証拠になるものがあるかもしれない...',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(15,2,'怪しい人物を特定せよ','被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(15,3,'殺害トリックを導き出せ ','いよいよ殺害を行ったトリックを考え、確信を突くのだ....',50,100,1);

insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(16,1,'現場検証を行なって手掛かりを探せ','殺害現場には何か証拠になるものがあるかもしれない...',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(16,2,'怪しい人物を特定せよ','被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(16,3,'殺害トリックを導き出せ ','いよいよ殺害を行ったトリックを考え、確信を突くのだ....',50,100,1);

insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(17,1,'現場検証を行なって手掛かりを探せ','殺害現場には何か証拠になるものがあるかもしれない...',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(17,2,'怪しい人物を特定せよ','被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(17,3,'殺害トリックを導き出せ ','いよいよ殺害を行ったトリックを考え、確信を突くのだ....',50,100,1);

insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(17,1,'現場検証を行なって手掛かりを探せ','殺害現場には何か証拠になるものがあるかもしれない...',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(17,2,'怪しい人物を特定せよ','被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(17,3,'殺害トリックを導き出せ ','いよいよ殺害を行ったトリックを考え、確信を突くのだ....',50,100,1);

insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(18,1,'現場検証を行なって手掛かりを探せ','殺害現場には何か証拠になるものがあるかもしれない...',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(18,2,'怪しい人物を特定せよ','被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(18,3,'殺害トリックを導き出せ ','いよいよ殺害を行ったトリックを考え、確信を突くのだ....',50,100,1);

insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(19,1,'現場検証を行なって手掛かりを探せ','殺害現場には何か証拠になるものがあるかもしれない...',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(19,2,'怪しい人物を特定せよ','被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(19,3,'殺害トリックを導き出せ ','いよいよ殺害を行ったトリックを考え、確信を突くのだ....',50,100,1);

insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(20,1,'現場検証を行なって手掛かりを探せ','殺害現場には何か証拠になるものがあるかもしれない...',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(20,2,'怪しい人物を特定せよ','被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(20,3,'殺害トリックを導き出せ ','いよいよ殺害を行ったトリックを考え、確信を突くのだ....',50,100,1);

insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(21,1,'現場検証を行なって手掛かりを探せ','殺害現場には何か証拠になるものがあるかもしれない...',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(21,2,'怪しい人物を特定せよ','被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',50,100,0);
insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(21,3,'殺害トリックを導き出せ ','いよいよ殺害を行ったトリックを考え、確信を突くのだ....',50,100,1);




create table banks(
id int NOT NULL auto_increment,
name varchar(250),
country_name varchar(250),
lv int,
price int,
max_spell int,
max_count int,
PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;

insert into banks
(id,name,country_name,lv,price,max_spell,max_count
)values(
1,'ムンタイバンク','tailand',1,1000,5,20
);
insert into banks
(id,name,country_name,lv,price,max_spell,max_count
)values(
2,'コモンウェルカムズ','maley',1,1000,7,20
);
insert into banks
(id,name,country_name,lv,price,max_spell,max_count
)values(
3,'ミズモバンク','japan',1,1000,9,20
);
insert into banks
(id,name,country_name,lv,price,max_spell,max_count
)values(
4,'カナダABCDバンク','Canada',1,1000,10,20
);
insert into banks
(id,name,country_name,lv,price,max_spell,max_count
)values(
5,'スタンディングチャーチル','England',1,1000,8,15
);
insert into banks
(id,name,country_name,lv,price,max_spell,max_count
)values(
6,'MPオルガン・チャース','USA',1,1000,10,15
);
insert into banks
(id,name,country_name,lv,price,max_spell,max_count
)values(
7,'インターナショナルユニオンバンク','USA',1,1000,10,10
);










/*
1:全回復 100
2:100回復 100
3:１箇所開く 100
4:１ワード開示 100
5:半分に減らす
5:ワープ 100

*/
create table items(
id int NOT NULL auto_increment,
name varchar(250),
genre_id int,
price int,
PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;

insert into items(id,name,genre_id,price)values(1,'全回復',1,100);
insert into items(id,name,genre_id,price)values(2,'100回復',1,100);
insert into items(id,name,genre_id,price)values(3,'１箇所開く',1,100);
insert into items(id,name,genre_id,price)values(4,'１ワード開示',1,100);
insert into items(id,name,genre_id,price)values(5,'半分に減らす',1,100);
insert into items(id,name,genre_id,price)values(6,'ワープ',1,100);
insert into items(id,name,genre_id,price)values(7,'故障を増やす',1,100);

create table member_items(
id int NOT NULL auto_increment,
member_id int,
item_name varchar(250),
item_genre_id int,
used_flag int,
insert_time datetime,
update_time datetime,
PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;


insert into members (mixi_account_id,name,power,max_power,member_request_id)values(1,'aa',1000,1000,1);


alter table members add mission_count int default 0;
alter table members add success_count int default 0;
alter table members add mistake_count int default 0;

create table members(
  `id` int NOT NULL auto_increment,
  `mixi_account_id` varchar(250) default NULL,
  `thumnail_url` longtext,
  `name` longtext,
  `mail` longtext,
  `password` longtext,
   power int,
   max_power int,
   money int,
   lv int default NULL,
   exp int default null,
   member_request_id int,
   insert_date date,
   update_date date,
  PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;


create table member_treasures(
  id int NOT NULL auto_increment,
  member_id int,
  treasure_id int,
  treasure_name varchar(250),
  series_id int,
  insert_time datetime,
  update_time datetime,
  PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;



insert into member_treasures (member_id,treasure_id,treasure_name,series_id,insert_time)values(1,1,'イエローゴールド',1,now());
insert into member_treasures (member_id,treasure_id,treasure_name,series_id,insert_time)values(1,2,'グリーンゴールド',1,now());
insert into member_treasures (member_id,treasure_id,treasure_name,series_id,insert_time)values(1,3,'ピンクゴールド',1,now());
insert into member_treasures (member_id,treasure_id,treasure_name,series_id,insert_time)values(1,4,'レッドゴールド',1,now());
insert into member_treasures (member_id,treasure_id,treasure_name,series_id,insert_time)values(1,5,'ペイジ',2,now());
insert into member_treasures (member_id,treasure_id,treasure_name,series_id,insert_time)values(1,6,'アクアマリン',3,now());
insert into member_treasures (member_id,treasure_id,treasure_name,series_id,insert_time)values(1,6,'アズライト',4,now());

create table treasures(
  id int NOT NULL auto_increment,
  name varchar(250),
  series_id int,
  lv int,
  PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;

create table treasure_series(
  id int NOT NULL auto_increment,
  name varchar(250),
  compleate_count int,
  PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;

insert into treasure_series(id,name)values(1,'金塊');
insert into treasure_series(id,name)values(2,'コイン');
insert into treasure_series(id,name)values(3,'指輪');
insert into treasure_series(id,name)values(4,'宝石');
insert into treasure_series(id,name)values(5,'陶器');
insert into treasure_series(id,name)values(6,'名画');
insert into treasure_series(id,name)values(7,'海賊');
insert into treasure_series(id,name)values(8,'江戸');
insert into treasure_series(id,name)values(9,'シェークスピア');
insert into treasure_series(id,name)values(10,'エジプト');
insert into treasure_series(id,name)values(11,'ギリシャ');



insert into treasures (name,series_id,lv)values('イエローゴールド',1,1);
insert into treasures (name,series_id,lv)values('グリーンゴールド',1,1);
insert into treasures (name,series_id,lv)values('ピンクゴールド',1,1);
insert into treasures (name,series_id,lv)values('レッドゴールド',1,1);
insert into treasures (name,series_id,lv)values('ホワイトゴールド',1,1);

insert into treasures (name,series_id,lv)values('ペイジ',2,1);
insert into treasures (name,series_id,lv)values('ナイト',2,1);
insert into treasures (name,series_id,lv)values('クイーン',2,1);
insert into treasures (name,series_id,lv)values('キング',2,1);
insert into treasures (name,series_id,lv)values('エース',2,1);

insert into treasures (name,series_id,lv)values('アイオライト',3,1);
insert into treasures (name,series_id,lv)values('アクアマリン',3,1);
insert into treasures (name,series_id,lv)values('アクアオーラ',3,1);
insert into treasures (name,series_id,lv)values('アズライト',3,1);
insert into treasures (name,series_id,lv)values('アベンチュリン',3,1);

insert into treasures (name,series_id,lv)values('アイオライト',4,1);
insert into treasures (name,series_id,lv)values('アクアマリン',4,1);
insert into treasures (name,series_id,lv)values('アクアオーラ',4,1);
insert into treasures (name,series_id,lv)values('アズライト',4,1);
insert into treasures (name,series_id,lv)values('アベンチュリン',4,1);

insert into treasures (name,series_id,lv)values('膳所焼のつぼ',5,1);
insert into treasures (name,series_id,lv)values('信楽焼の皿',5,1);
insert into treasures (name,series_id,lv)values('萩焼の湯のみ',5,1);
insert into treasures (name,series_id,lv)values('九谷焼の皿',5,1);
insert into treasures (name,series_id,lv)values('有田焼の茶碗',5,1);

insert into treasures (name,series_id,lv)values('モナリザ',6,1);
insert into treasures (name,series_id,lv)values('落穂ひろい',6,1);
insert into treasures (name,series_id,lv)values('睡蓮',6,1);
insert into treasures (name,series_id,lv)values('真珠の耳飾の少女',6,1);
insert into treasures (name,series_id,lv)values('晩鐘',6,1);

insert into treasures (name,series_id,lv)values('海賊の宝箱',7,1);
insert into treasures (name,series_id,lv)values('海賊の刀剣',7,1);
insert into treasures (name,series_id,lv)values('海賊の帽子',7,1);
insert into treasures (name,series_id,lv)values('海賊の船舵',7,1);
insert into treasures (name,series_id,lv)values('海賊のほら貝',7,1);

insert into treasures (name,series_id,lv)values('慶長小判',8,1);
insert into treasures (name,series_id,lv)values('エレキテル',8,1);
insert into treasures (name,series_id,lv)values('江戸切子の硝子細工',8,1);
insert into treasures (name,series_id,lv)values('浮世絵',8,1);
insert into treasures (name,series_id,lv)values('七宝焼',8,1);




create table member_spells(
  id int NOT NULL auto_increment,
  member_id int,
  first_spell_id int,
  second_spell_id int,
  third_spell_id int,
  insert_time datetime,
  update_time datetime,
  PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;


alter table requests add money int default 0;

update requests set money = 1000;

create table requests(
id int NOT NULL auto_increment,
title varchar(250),
txt varchar(250),
country varchar(250),
lv int,
max_spell int,
max_count int,
PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;

insert requests(id,title,txt,country,lv,max_spell,max_count)values(
1,'アイタカ銀行','','タイ',1,5,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
2,'ハンコック銀行','','タイ',1,5,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
3,'ムンタイ銀行','','タイ',1,5,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
4,'アッサム商業銀行','','タイ',1,5,20);

insert requests(id,title,txt,country,lv,max_spell,max_count)values(
11,'バンコ・デ・オルロ','','メキシコ',2,6,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
12,'バンカ・ミッシェル','','メキシコ',2,6,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
13,'バンカ・アムロ','','メキシコ',2,6,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
14,'バンカ・テクテカ','','メキシコ',2,6,20);

insert requests(id,title,txt,country,lv,max_spell,max_count)values(
21,'PM銀行','','マレーシア',3,7,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
22,'プライベート銀行','','マレーシア',3,7,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
23,'セイバンク','','マレーシア',3,7,20);

insert requests(id,title,txt,country,lv,max_spell,max_count)values(
31,'コモンウェルカムズ銀行','','オーストラリア',4,8,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
32,'イーストパック銀行','','オーストラリア',4,8,20);

insert requests(id,title,txt,country,lv,max_spell,max_count)values(
41,'みずも銀行','','日本',5,9,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
42,'三葉東京ABC銀行','','日本',5,9,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
43,'三葉住吉銀行','','日本',5,9,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
44,'りそだ銀行','','日本',5,9,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
45,'旧生銀行','','日本',5,9,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
46,'くもりぞら銀行','','日本',5,9,20);

insert requests(id,title,txt,country,lv,max_spell,max_count)values(
51,'カナダ/ドッペルゲンガー商業銀行','','カナダ',6,10,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
52,'メタセコイヤ銀行','','カナダ',6,10,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
53,'タランタ・ドミニカ銀行','','カナダ',6,10,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
54,'ローレンチャン銀行','','カナダ',6,10,20);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
55,'カナダABCD銀行','','カナダ',6,10,20);

insert requests(id,title,txt,country,lv,max_spell,max_count)values(
61,'スタンディングチャーチル銀行','','イギリス',6,10,15);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
62,'ベストベアー銀行','','イギリス',6,10,15);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
63,'バームネイン銀行','','イギリス',6,10,15);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
64,'スーザン・モック','','イギリス',6,10,15);

insert requests(id,title,txt,country,lv,max_spell,max_count)values(
71,'アメリカンバンク','','アメリカ',6,10,10);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
72,'セコビア銀行','','アメリカ',6,10,10);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
73,'ステット・ロード','','アメリカ',6,10,10);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
74,'ウォルト・マンゴー','','アメリカ',6,10,10);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
75,'MPオルガン・チャース','','アメリカ',6,10,10);
insert requests(id,title,txt,country,lv,max_spell,max_count)values(
76,'オニオン・バンク','','アメリカ',6,10,10);




create table member_requests(
  id int NOT NULL auto_increment,
  member_id int,
  title varchar(250),
  message_body varchar(250),
  bank_id int,
  all_distance int,
  process_status int,
  read_flag int,
  challenge_count int,
  max_challenge_count int,
  max_spell int,
  first_spell_id int,
  second_spell_id int,
  third_spell_id int,
  treasure_id int,
  treasure_name varchar(250),
  insert_time datetime,
  update_time datetime,
  PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;


alter table member_requests add dead_line_time datetime;
alter table member_requests add information_flag int;
alter table member_requests add limit_time datetime;
alter table member_requests add limit_hour int;
create table member_requests(
  id int NOT NULL auto_increment,
  member_id int,
  request_id int,
  request_title varchar(250),
  distance int,
  all_distance int,
  process_status int,
  challenge_count int,
  first_spell_id int,
  second_spell_id int,
  third_spell_id int,
  insert_time datetime,
  update_time datetime,
  max_challenge_count int,
  read_flag int,
  max_spell int,
  resolve_count int,
  message_body varchar(250),
  PRIMARY KEY (`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;

insert into member_requests(id,member_id,request_id,request_title,distance,all_distance,
process_status,challenge_count,first_spell_id,second_spell_id,third_spell_id,
insert_time,update_time
)values(1,1,1,'チュートリアル１',0,1000,0,0,1,2,3,NOW(),NOW());
insert into member_requests(id,member_id,request_id,request_title,distance,all_distance,
process_status,challenge_count,first_spell_id,second_spell_id,third_spell_id,
insert_time,update_time
)values(2,1,1,'チュートリアル2',0,1000,0,0,1,2,3,NOW(),NOW());
insert into member_requests(id,member_id,request_id,request_title,distance,all_distance,
process_status,challenge_count,first_spell_id,second_spell_id,third_spell_id,
insert_time,update_time
)values(3,1,1,'チュートリアル3',0,1000,0,0,1,2,3,NOW(),NOW());


create table spells(
  id int,
  name varchar(250),
PRIMARY KEY (`id`)
);

insert into spells (id,name) value(0,'kami');
insert into spells (id,name) value(1,'hito');
insert into spells (id,name) value(2,'zou');
insert into spells (id,name) value(3,'tora');
insert into spells (id,name) value(4,'usagi');
insert into spells (id,name) value(5,'kirin');
insert into spells (id,name) value(6,'tori');
insert into spells (id,name) value(7,'hebi');
insert into spells (id,name) value(8,'tatsu');
insert into spells (id,name) value(9,'mushi');





