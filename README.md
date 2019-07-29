PHP后台管理系统开发
============

create mysql base "test" or "test1"

create table :
    dayoff--
    +------------+-------------+------+-----+---------+----------------+
    | Field      | Type        | Null | Key | Default | Extra          |
    +------------+-------------+------+-----+---------+----------------+
    | off_num    | int(10)     | NO   | PRI | NULL    | auto_increment |
    | name       | varchar(10) | NO   |     | NULL    |                |
    | start_time | date        | NO   |     | NULL    |                |
    | end_time   | date        | NO   |     | NULL    |                |
    | remarks    | tinyint(4)  | NO   |     | NULL    |                |
    +------------+-------------+------+-----+---------+----------------+
    duty--
    +--------+-------------+------+-----+---------+-------+
    | Field  | Type        | Null | Key | Default | Extra |
    +--------+-------------+------+-----+---------+-------+
    | ifduty | tinyint(4)  | NO   | PRI | NULL    |       |
    | days   | float(10,2) | NO   |     | NULL    |       |
    +--------+-------------+------+-----+---------+-------+
    home--
    +-------+-------------+------+-----+---------+-------+
    | Field | Type        | Null | Key | Default | Extra |
    +-------+-------------+------+-----+---------+-------+
    | id    | int(10)     | NO   |     | NULL    |       |
    | name  | varchar(10) | NO   | PRI | NULL    |       |
    | duty  | tinyint(4)  | NO   |     | NULL    |       |
    | start | date        | NO   |     | NULL    |       |
    +-------+-------------+------+-----+---------+-------+
