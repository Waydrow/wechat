## 宠物管理系统 数据库设计文档

### pet (宠物信息表)

|字段 	| 类型	| 说明	| default
| ----- |-----	| ----- | ----- |
|id		| int	| primary key	|
roomid	| int	| 居住房间id, room表外键
petname	| varchar | 姓名
img 	| varchar | 图片	| null
breed	| varchar | 种类
age		| int	  | 年龄
sex		| varchar | 性别
entertime| date	  | 收容日期
leavetime| date	  | 领养日期	| null
isback	| int	  | 是否退回 	| 0
backreason | varchar | 退回原因 | null
character  | varchar | 性格		| null
healthy	   | varchar | 健康状况 | null
istaken	   | int	 | 是否被领养 |0: 未领养<br> 1: 已领养

### room (房间信息表)

|字段 	| 类型	| 说明	| default
| ----- |-----	| -----| ----- |
|id		| int	| primary key
| name  | varchar| 房间名字 | unique
| capacity| int | 房间容量
| nownum | int  | 当前居住的宠物数量 | 0

### careworker (护工信息表)

|字段 	| 类型	| 说明	| default
| ----- |-----	| ----- | ----- |
id		| int	| primary key
name	| varchar| 姓名
sex		| varchar| 性别
phone	| varchar| 电话
idcard  | char	 | 身份证号
address | varchar| 地址 | null

### lookafter (护工-宠物关系表)

|字段 	| 类型	| 说明	|
| ----- |-----	| ----- |
id		| int	| primary key
careworkerid| int | 护工id, carworker表外键
petid	| int	| 宠物id, pet表外键

### user (用户信息表)

|字段 	| 类型	| 说明	| default
| ----- |-----	| ----- | ----- |
id		| int	| primary key
username| varchar| 用户名
realname| varchar| 真实姓名
password| varchar| 密码
sex		| varchar| 性别
phone	| varchar| 电话
idcard  | char	 | 身份证号
address | varchar| 地址 | null
badrecord| varchar| 不良记录| null

### application (用户-宠物关系表)

|字段 	| 类型	| 说明	| default
| ----- |-----	| ----- | ---- |
id		| int	| primary key
userid  | int 	| 用户id, user表外键
petid	| int	| 宠物id, pet表外键
ispass  | int   | 申请是否通过 | -1: 拒绝<br>0: 待处理<br>1: 成功