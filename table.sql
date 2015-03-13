create table wytg_users(
    id int unsigned not null auto_increment primary key,
    userid int unsigned not null,
    username varchar(30) not null,
    shop varchar(100) not null,
    avatar varchar(100) not null default '',
    token varchar(60) not null,
    usercode varchar(10) not null,
    is_state tinyint(1) unsigned not null default 0,
    addtime int unsigned not null,
    expiretime int unsigned not null
)engine=myisam,default character set utf8;


create table wytg_cards(
    id int unsigned not null auto_increment primary key,
    userid int unsigned not null,
    tb_orderid varchar(50) not null default '',
    tb_goodid varchar(20) not null,
    cardnum varchar(100) not null,
    cardpwd varchar(100) not null default '',
    is_state tinyint(1) unsigned not null default 0,
    addtime int unsigned not null,
    selltime int unsigned not null,
    index goodid(tb_goodid)
)engine=innodb,default character set utf8;

create table wytg_goods(
    id int unsigned not null auto_increment primary key,
    userid int unsigned not null,
    tb_goodid varchar(20) not null,
    tb_title varchar(50) not null,
    tb_price decimal(10,2) unsigned not null,
    tb_num int unsigned not null default 0,
    tb_img varchar(100) not null default '',
    is_state tinyint(1) unsigned not null default 0,
    tplid int unsigned not null,
    is_card tinyint(1) unsigned not null default 0,
    remark varchar(500) not null default '',
    gettype varchar(20) not null default '',
    addtime int unsigned not null
)engine=myisam,default character set utf8;

create table wytg_msgtpl(
    id int unsigned not null auto_increment primary key,
    userid int unsigned not null,
    name varchar(50) not null,
    title varchar(100) not null,
    tpl nvarchar(500) not null,
    is_state tinyint(1) unsigned not null default 0,
    addtime int unsigned not null
)engine=myisam,default character set utf8;

/*create table wytg_sells(
    id int unsigned not null auto_incremnt primary key,
    goodid int unsigned not null,
    tb_orderid varchar(20) not null,
    addtime int unsigned not null
)engine=myisam,default character set utf8;*/

create table wytg_orders(
    id int unsigned not null auto_increment primary key,
    userid int unsigned not null,
    tb_tradeno varchar(50) not null default '',
    tb_orderid varchar(20) not null,
    tb_goodid varchar(20) not null,
    tb_quantity int unsigned not null,
    tb_status varchar(30) not null,
    is_state tinyint(1) unsigned not null default 0,
    tb_addtime int unsigned not null,
    tb_price decimal(10,2) not null default 0,
    tb_discount decimal(10,2) not null default 0,
    tb_paymoney decimal(10,2) not null default 0,
    buyer_nick varchar(30) not null,
    buyer_alipay_no varchar(50) not null default '',
    buyer_email varchar(50) not null default '',
    buyer_message varchar(50) not null default '',
    addtime int unsigned not null
)engine=myisam,default character set utf8;

create table wytg_newsclass(
 id int unsigned not null auto_increment primary key,
 classname varchar(50) not null
)engine=myisam,default character set utf8;

create table wytg_news(
 id int unsigned not null auto_increment primary key,
 classid int unsigned not null,
 title varchar(100) not null,
 content text,
 is_bold varchar(10) not null default '',
 is_color varchar(10) not null default '',
 is_popup tinyint(1) unsigned not null default 0,
 addtime int unsigned not null,
 views int unsigned not null default 0,
 is_state tinyint(1) unsigned not null default 0,
 is_display_home tinyint(1) unsigned not null default 0
)engine=myisam,default character set utf8;

create table wytg_config(
 id int unsigned not null auto_increment primary key,
 sitename varchar(90) not null default '',
 sitetitle varchar(90) not null default '',
 siteurl varchar(50) not null default '',
 staticurl varchar(100) not null default '',
 keyword nvarchar(100) not null default '',
 description nvarchar(100) not null default '',
 template varchar(10) not null default '',
 qq varchar(12) not null default '',
 tel varchar(12) not null default '',
 address nvarchar(200) not null default '',
 servicemail varchar(50) not null default '',
 reguser tinyint(1) unsigned not null default 0,
 userstate tinyint(1) unsigned not null default 0,
 copyright nvarchar(100) not null default '',
 tongji nvarchar(500) not null default '',
 smtp varchar(50) not null default '',
 email varchar(50) not null default '',
 authkey varchar(50) not null default '',
 icp varchar(20) not null default '',
 sitestate tinyint(1) unsigned not null default 0,
 msgtip nvarchar(400) not null default '',
 woodyapp nvarchar(500) not null default ''
)engine=myisam,default character set utf8;

INSERT INTO `wytg_config` (`sitename`, `siteurl`, `keyword`, `description`, `template`, `qq`, `tel`, `reguser`, `userstate`, `copyright`, `tongji`, `smtp`, `email`, `authkey`,`woodyapp`) VALUES
('白龙卡密寄售平台', '卡密托管，自动发货', '白龙卡密寄售平台', '欢迎使用白龙卡密寄售平台', 'default', 'duckposter', '13900000000', 0, 0, 'CopyRight @ 2015 白龙卡密寄售平台', '', 'smtp.qq.com', 'opennet@vip.qq.com', '123456','本平台由WoodyApp开发设计，并提供技术支持。');

create table wytg_admin(
 id int unsigned not null auto_increment primary key,
 utype tinyint(1) unsigned not null default 0 comment '1 administrator 2 users',
 username varchar(20) not null,
 userpass varchar(40) not null,
 is_safe tinyint(1) unsigned not null default 0,
 userkey varchar(40) not null default '',
 is_verifyip tinyint(1) unsigned not null default 0,
 verifyip varchar(200) not null default '',
 adminlimit nvarchar(500) not null default '',
 is_state tinyint(1) unsigned not null default 0,
 addtime int unsigned not null
)engine=myisam,default character set utf8;

insert into wytg_admin (id,utype,username,userpass,adminlimit,addtime) values(1,1,'admin','926bb74cd932c4b8ae69b145bf7b9c71815d260e','users|userlogs|orders|cards|goods|msgtpl|newsclass|news|adminpwd|adminlist|adminlogs|set|index','1420612970');
    
create table wytg_adminlogs(
 id int unsigned not null auto_increment primary key,
 userid int unsigned not null,
 logip varchar(15) not null default '',
 logtime int unsigned not null,
 index(userid)
)engine=myisam,default character set utf8;

create table wytg_userlogs(
 id int unsigned not null auto_increment primary key,
 userid int unsigned not null,
 logip varchar(15) not null default '',
 logtime int unsigned not null,
 index(userid)
)engine=myisam,default character set utf8;