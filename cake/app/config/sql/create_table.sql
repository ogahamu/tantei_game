CREATE unique INDEX idx_mqd_on_mqi_and_dn ON member_quest_details(member_quest_id, detail_no);
CREATE unique INDEX idx_qd_on_qi_and_dn ON quest_details(quest_id,detail_no);
CREATE unique INDEX idx_mq_on_mi_and_qi ON member_quests(member_id,quest_id);

CREATE INDEX idx_mq_on_mi ON member_quests(member_id);
CREATE INDEX idx_mqd_on_mi ON member_quest_details(member_id);
CREATE INDEX idx_me_on_mi ON member_evidences(member_id);
CREATE INDEX idx_me_on_ei ON member_evidences(evidence_id);
CREATE INDEX idx_me_on_mi ON member_evidences(member_id);
CREATE INDEX idx_me_on_mqi ON member_evidences(member_quest_id);

create table test_names(
id int NOT NULL auto_increment,
name varchar(250),
PRIMARY KEY(`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;




insert into test_names (name)values('');



http://test4.blamestitch.com/cake/top/top/
//request 初期化
update
members
set
member_request_id = 0,
power=10000,
money = 50,
lv = 1,
exp = 0,
mission_count = 0,
success_count = 0,
mistake_count = 0,
sum_exp = 0,
least_next_exp = 1000;
delete from member_requests;
delete from member_treasures;




create table m_lv_exp(
lv int NOT NULL auto_increment,
exp int,
sum_exp int,
PRIMARY KEY(`lv`)
)TYPE=InnoDB AUTO_INCREMENT=1;


insert into m_lv_exp(lv,exp,sum_exp)values(1,1000,0);
insert into m_lv_exp(lv,exp,sum_exp)values(2,1100,1000);
insert into m_lv_exp(lv,exp,sum_exp)values(3,1210,2100);
insert into m_lv_exp(lv,exp,sum_exp)values(4,1331,3310);
insert into m_lv_exp(lv,exp,sum_exp)values(5,1464,4641);
insert into m_lv_exp(lv,exp,sum_exp)values(6,1610,6105);
insert into m_lv_exp(lv,exp,sum_exp)values(7,1771,7715);
insert into m_lv_exp(lv,exp,sum_exp)values(8,1948,9486);
insert into m_lv_exp(lv,exp,sum_exp)values(9,2142,11434);
insert into m_lv_exp(lv,exp,sum_exp)values(10,2356,13576);
insert into m_lv_exp(lv,exp,sum_exp)values(11,2591,15932);
insert into m_lv_exp(lv,exp,sum_exp)values(12,2850,18523);
insert into m_lv_exp(lv,exp,sum_exp)values(13,3135,21373);
insert into m_lv_exp(lv,exp,sum_exp)values(14,3448,24508);
insert into m_lv_exp(lv,exp,sum_exp)values(15,3792,27956);
insert into m_lv_exp(lv,exp,sum_exp)values(16,4171,31748);
insert into m_lv_exp(lv,exp,sum_exp)values(17,4588,35919);
insert into m_lv_exp(lv,exp,sum_exp)values(18,5046,40507);
insert into m_lv_exp(lv,exp,sum_exp)values(19,5550,45553);
insert into m_lv_exp(lv,exp,sum_exp)values(20,6105,51103);
insert into m_lv_exp(lv,exp,sum_exp)values(21,6715,57208);
insert into m_lv_exp(lv,exp,sum_exp)values(22,7386,63923);
insert into m_lv_exp(lv,exp,sum_exp)values(23,8124,71309);
insert into m_lv_exp(lv,exp,sum_exp)values(24,8936,79433);
insert into m_lv_exp(lv,exp,sum_exp)values(25,9829,88369);
insert into m_lv_exp(lv,exp,sum_exp)values(26,10811,98198);
insert into m_lv_exp(lv,exp,sum_exp)values(27,11892,109009);
insert into m_lv_exp(lv,exp,sum_exp)values(28,13081,120901);
insert into m_lv_exp(lv,exp,sum_exp)values(29,14389,133982);
insert into m_lv_exp(lv,exp,sum_exp)values(30,15827,148371);
insert into m_lv_exp(lv,exp,sum_exp)values(31,17409,164198);
insert into m_lv_exp(lv,exp,sum_exp)values(32,19149,181607);
insert into m_lv_exp(lv,exp,sum_exp)values(33,21063,200756);
insert into m_lv_exp(lv,exp,sum_exp)values(34,23169,221819);
insert into m_lv_exp(lv,exp,sum_exp)values(35,25485,244988);
insert into m_lv_exp(lv,exp,sum_exp)values(36,28033,270473);
insert into m_lv_exp(lv,exp,sum_exp)values(37,30836,298506);
insert into m_lv_exp(lv,exp,sum_exp)values(38,33919,329342);
insert into m_lv_exp(lv,exp,sum_exp)values(39,37310,363261);
insert into m_lv_exp(lv,exp,sum_exp)values(40,41041,400571);
insert into m_lv_exp(lv,exp,sum_exp)values(41,45145,441612);
insert into m_lv_exp(lv,exp,sum_exp)values(42,49659,486757);
insert into m_lv_exp(lv,exp,sum_exp)values(43,54624,536416);
insert into m_lv_exp(lv,exp,sum_exp)values(44,60086,591040);
insert into m_lv_exp(lv,exp,sum_exp)values(45,66094,651126);
insert into m_lv_exp(lv,exp,sum_exp)values(46,72703,717220);
insert into m_lv_exp(lv,exp,sum_exp)values(47,79973,789923);
insert into m_lv_exp(lv,exp,sum_exp)values(48,87970,869896);
insert into m_lv_exp(lv,exp,sum_exp)values(49,96767,957866);
insert into m_lv_exp(lv,exp,sum_exp)values(50,106443,1054633);
insert into m_lv_exp(lv,exp,sum_exp)values(51,117087,1161076);
insert into m_lv_exp(lv,exp,sum_exp)values(52,128795,1278163);
insert into m_lv_exp(lv,exp,sum_exp)values(53,141674,1406958);
insert into m_lv_exp(lv,exp,sum_exp)values(54,155841,1548632);
insert into m_lv_exp(lv,exp,sum_exp)values(55,171425,1704473);
insert into m_lv_exp(lv,exp,sum_exp)values(56,188567,1875898);
insert into m_lv_exp(lv,exp,sum_exp)values(57,207423,2064465);
insert into m_lv_exp(lv,exp,sum_exp)values(58,228165,2271888);
insert into m_lv_exp(lv,exp,sum_exp)values(59,250981,2500053);
insert into m_lv_exp(lv,exp,sum_exp)values(60,276079,2751034);
insert into m_lv_exp(lv,exp,sum_exp)values(61,303686,3027113);
insert into m_lv_exp(lv,exp,sum_exp)values(62,334054,3330799);
insert into m_lv_exp(lv,exp,sum_exp)values(63,367459,3664853);
insert into m_lv_exp(lv,exp,sum_exp)values(64,404204,4032312);
insert into m_lv_exp(lv,exp,sum_exp)values(65,444624,4436516);
insert into m_lv_exp(lv,exp,sum_exp)values(66,489086,4881140);
insert into m_lv_exp(lv,exp,sum_exp)values(67,537994,5370226);
insert into m_lv_exp(lv,exp,sum_exp)values(68,591793,5908220);
insert into m_lv_exp(lv,exp,sum_exp)values(69,650972,6500013);
insert into m_lv_exp(lv,exp,sum_exp)values(70,716069,7150985);
insert into m_lv_exp(lv,exp,sum_exp)values(71,787675,7867054);
insert into m_lv_exp(lv,exp,sum_exp)values(72,866442,8654729);
insert into m_lv_exp(lv,exp,sum_exp)values(73,953086,9521171);
insert into m_lv_exp(lv,exp,sum_exp)values(74,1048394,10474257);
insert into m_lv_exp(lv,exp,sum_exp)values(75,1153233,11522651);
insert into m_lv_exp(lv,exp,sum_exp)values(76,1268556,12675884);
insert into m_lv_exp(lv,exp,sum_exp)values(77,1395411,13944440);
insert into m_lv_exp(lv,exp,sum_exp)values(78,1534952,15339851);
insert into m_lv_exp(lv,exp,sum_exp)values(79,1688447,16874803);
insert into m_lv_exp(lv,exp,sum_exp)values(80,1857291,18563250);
insert into m_lv_exp(lv,exp,sum_exp)values(81,2043020,20420541);
insert into m_lv_exp(lv,exp,sum_exp)values(82,2247322,22463561);
insert into m_lv_exp(lv,exp,sum_exp)values(83,2472054,24710883);
insert into m_lv_exp(lv,exp,sum_exp)values(84,2719259,27182937);
insert into m_lv_exp(lv,exp,sum_exp)values(85,2991184,29902196);
insert into m_lv_exp(lv,exp,sum_exp)values(86,3290302,32893380);
insert into m_lv_exp(lv,exp,sum_exp)values(87,3619332,36183682);
insert into m_lv_exp(lv,exp,sum_exp)values(88,3981265,39803014);
insert into m_lv_exp(lv,exp,sum_exp)values(89,4379391,43784279);
insert into m_lv_exp(lv,exp,sum_exp)values(90,4817330,48163670);
insert into m_lv_exp(lv,exp,sum_exp)values(91,5299063,52981000);
insert into m_lv_exp(lv,exp,sum_exp)values(92,5828969,58280063);
insert into m_lv_exp(lv,exp,sum_exp)values(93,6411865,64109032);
insert into m_lv_exp(lv,exp,sum_exp)values(94,7053051,70520897);
insert into m_lv_exp(lv,exp,sum_exp)values(95,7758356,77573948);
insert into m_lv_exp(lv,exp,sum_exp)values(96,8534191,85332304);
insert into m_lv_exp(lv,exp,sum_exp)values(97,9387610,93866495);
insert into m_lv_exp(lv,exp,sum_exp)values(98,10326371,103254105);
insert into m_lv_exp(lv,exp,sum_exp)values(99,11359008,113580476);

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





