
---先建完表和触发器再插入数据 否则触发器功能无法实现 最后一个触发器最后执行

create database HmsDB on primary(
	name='hmsDB_data',
	filename='D:\SQL项目文件\HmsDB_data.mdf',
	size=10mb,
	maxsize=1000mb,
	filegrowth=20%
),filegroup First
(name='HmsFG1',
filename='D:\SQL项目文件\HmsFG1.ndf',
size=250mb,
maxsize=500mb,
filegrowth=10%
),filegroup Second
(name='HmsFG2',
filename='D:\SQL项目文件\HmsFG@.ndf',
size=250mb,
maxsize=500mb,
filegrowth=10%
),filegroup Third-------分区必须对应于文件‘组’而不是次文件，分区用文件组名
(name='HmsFG3',
filename='D:\SQL项目文件\HmsFG3.ndf',
size=250mb,
maxsize=500mb,
filegrowth=10%
)
log on(
	name='hmsDB_log',
	filename='D:\SQL项目文件\hmsDB_log.ldf',
	size=5mb,
	filegrowth=10mb
)
go
use hmsDB
go

create schema People
go-----这就是一个批次的完结符号
create schema MeData
go
create schema Affairs
go

create partition function Date_f(date)
as range left for values('2015-01-01','2018-01-01')----日期加单引号
go

create PARTITION SCHEME Date_s ----分区方案绑定的表中的键，在sql中必须是主键或unique（索引），要么这个表里没主键就不用绑定主键或unique
as PARTITION Date_f
to (First,Second,Third)
go


if exists(
select * from sysobjects where name='People.Patient'
)
drop table People.Patient
create table People.Patient(
	PaID int primary key not null,
	PaName varchar(20) not null,
	PaGender CHAR(1) constraint CK_PaGender check(PaGender in('F','M')),
	RoomID int not null,
    PaMobile CHAR(11) constraint CK_PaMobile check(
	PaMobile like '1[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]'
	)
	constraint UN_PaMobile unique(PaMobile),
	PaDate date not null
) 
go
insert People.Patient values(1,'pa','M',1,'12345678901','2013-01-02')
insert People.Patient values(2,'pb','F',2,'12345678902','2013-01-02')
insert People.Patient values(3,'pc','F',3,'12345678903',GETDATE())
insert People.Patient values(4,'pd','M',4,'12345678904',GETDATE())
insert People.Patient values(5,'pe','M',5,'12345678905',GETDATE())
go

if exists(
select * from sysobjects where name='People.Doctor'
)
drop table People.Doctor
create table People.Doctor(
	DrID int constraint PK_DrID primary key not null,
	DrName varchar(20) not null,
	DrGender CHAR(1) constraint CK_Gender check(DrGender in('F','M')),

	DrMobile CHAR(11) constraint CK_Mobile check(
	DrMobile like '1[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]'
	)
	constraint UN_Mobile unique(DrMobile),
)
go
insert People.Doctor values(1,'da','F',12345678901)
insert People.Doctor values(2,'db','F',12345678902)
insert People.Doctor values(3,'dc','M',12345678903)
insert People.Doctor values(4,'dd','F',12345678904)
insert People.Doctor values(5,'de','F',12345678905)
go

if exists(
select * from sysobjects where name='People.Office'
)
drop table People.Office 
create table People.Office(
	OffName varchar(20) not null,
	DrID int not null constraint RE_OffDrID references People.Doctor(DrID),
	PaID int not null constraint Off_PaID references People.Patient(PaID)
)
go
insert People.Office values('oa',1,1)
insert People.Office values('ob',2,2)
insert People.Office values('oc',3,3)
insert People.Office values('od',4,4)
insert People.Office values('oe',5,5)
go

if exists(
select * from sysobjects where name='MeData.Medicine'
)
drop table MeData.Medicine
create table MeData.Medicine(
	MeID int primary key identity(1,1) not null,
	MeName varchar(20) not null,
	MePrice money not null,
	MeSales_volume int not null,
	MeDate date not null,----上次进货时间
	MeLeft int not null
)
go
insert MeData.Medicine values('ma',10,0,'2013-01-02',1000)
insert MeData.Medicine values('mb',20,0,'2013-01-02',1000)
insert MeData.Medicine values('mc',30,0,GETDATE(),1000)
insert MeData.Medicine values('md',40,0,GETDATE(),1000)
insert MeData.Medicine values('me',50,0,GETDATE(),1000)
go


if exists(
select * from sysobjects where name='MeData.Supplier'
)
drop table MeData.Supplier
create table MeData.Supplier(
	SupID int not null primary key,
    SupName varchar(20) not null,
    SupMobile CHAR(11) constraint CK_SupMobile check(
	SupMobile like '1[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]'),
	SupAmount int not null,----一次供给量
	SupPrice money not null,
	MeID int not null references MeData.Medicine(MeID),
	SupDate date not null
)
go

insert MeData.Supplier values(1,'sa','19876543201',1000,5,1,'2013-01-02')
insert MeData.Supplier values(2,'sb','19876543202',1000,10,2,'2013-01-02')
insert MeData.Supplier values(3,'sc','19876543203',1000,15,3,'2013-01-02')
insert MeData.Supplier values(4,'sd','19876543204',1000,20,4,GETDATE())
insert MeData.Supplier values(5,'se','19876543205',1000,25,5,GETDATE())
go

if exists(
select * from sysobjects where name='Affairs.Check_Service')
drop table Affairs.Check_Service
create table Affairs.Check_Service(
	ChID int identity(1,1),
	ChName varchar(20) not null,
	ChPrice money not null,
	ChDate date not null,
	DrID int not null references People.Doctor(DrID),
	PaID int not null references People.Patient(PaID)
	)on Date_s(ChDate)
go
insert Affairs.Check_Service values('ca',10,'2013-01-02',1,1)
insert Affairs.Check_Service values('cb',10,'2013-01-02',2,2)
insert Affairs.Check_Service values('cc',10,GETDATE(),3,3)
insert Affairs.Check_Service values('cd',10,GETDATE(),4,4)
insert Affairs.Check_Service values('ce',10,GETDATE(),5,5)
go

--------挂号表-------
if exists(
select * from sysobjects where name='Affairs.Registration'
)
drop table Affairs.registration
create table Affairs.registration (
ReID int not null identity(1,1),
PaID int not null references People.Patient(PaID),
ReType varchar(20) check(ReType in ('Normal','Expert')),
RePrice money not null,
OffName varchar(20) not null check(OffName in ('oa','ob','oc','od','oe')),
DrID int not null references People.Doctor(DrID),
ReDate date not null,
)on Date_s(ReDate)
go
insert Affairs.registration values(1,'Normal',10,'oa',1,'2013-01-02')
insert Affairs.registration values(2,'Expert',20,'ob',2,'2013-01-02')
insert Affairs.registration values(3,'Normal',10,'oc',3,GETDATE())
insert Affairs.registration values(4,'Expert',20,'od',4,GETDATE())
insert Affairs.registration values(5,'Normal',10,'oe',5,GETDATE())
go

------药品划价表-------
if exists(select * from sysobjects where name='MeData.MedicineSales')
drop table MeData.MedicineSales
create table MeData.MedicineSales(
	SalesID int identity(1,1),
	PaID int not null references People.Patient(PaID), 	
	MeID int not null references MeData.Medicine(MeID),
	DrID int not null references People.Doctor(DrID),
	MSDate date not null,
	SalesAmount int not null,
	MePrice money null,
	MeFee money null
 )on Date_s(MSDate)
go

insert MeData.MedicineSales values(1,1,1,'2013-01-02',10,null,null)
insert MeData.MedicineSales values(2,2,2,'2013-01-02',9,null,null)
insert MeData.MedicineSales values(3,3,3,GETDATE(),5,null,null)
insert MeData.MedicineSales values(4,4,4,GETDATE(),5,null,null)
insert MeData.MedicineSales values(5,5,5,GETDATE(),5,null,null)
go

------药品划价添加记录药品数量，同时药品表中数量对应删减，这两个操作要么完成要么全部不完成，药品库存量小于100时提醒供货------
 create trigger MeCount on MeData.MedicineSales 
 for insert,update as
 begin
 begin transaction
	 declare @l int, @s int,@Sup int,@i int,@m money
	 select @s=SalesAmount,@i=MeID from inserted
	 select @l=MeLeft,@m=MePrice from MeData.Medicine where MeData.Medicine.MeID=@i
	 if(@l<@s)
		begin
		print'药品余量不足，交易失败'
		rollback transaction
		end 
	 if(@l-@s<100)
		begin
		print'药品余量不及100件，请通知供应商'
		end----这个end要放在update前面
		update MeData.Medicine set MeLeft=@l-@s,MeSales_volume=MeSales_volume+@s where MeData.Medicine.MeID=@i
		update MeData.MedicineSales set MePrice=@m where MeData.MedicineSales.MeID=@i
		update MeData.MedicineSales set MeFee=MePrice*SalesAmount where MeData.MedicineSales.MeID=@i 
commit transaction		
 end 
 go

 ---------------------------------------需要做的查询存储过程--------------------------------------------
 -------------------------------------------------------------------------------------------------------

 -------各个科室经营状况-------
create procedure OfficeRunning as
begin
--select o.OffName'科室名称',,sum(c.ChPrice)'检查费',,sum(r.RePrice)'挂号费' from People.Office o,Affairs.Check_Service c,MeDatA.MedicineSales m,MeData.Supplier s,Affairs.registration rgroup by rollup(o.OffName,m.MeID)select r. from People.Office o,Affairs.registration r,
select o.OffName,sum(c.ChPrice)'检查利润',sum(r.RePrice)'挂号利润' from People.Office o join Affairs.Check_Service c on o.DrID=c.DrID join Affairs.registration r on c.DrID=r.DrID
group by rollup(o.OffName)
end
go

------药房中每年药品营收记录-------(后有触发器不许删表，所以不能用表，批次中也不能镶嵌视图 
------不要惯性思维钻进牛角尖进小范围，前面怎么做后面不一定要模式相同，可以从其他范围或角度重新寻找方法,思维懒惰反而会使方法更复杂;不要把问题复杂化了再想一个简单的解决办法,先想一个简单有效的方法再将问题丰富完善从而改进方法)
create procedure MedicineInocme as
begin
select datepart(yyyy,ms.MSDate)as'年份',m.MeName as'药品名称',ms.MeID'药品ID',m.MePrice'零售价',s.SupPrice'批发价',
sum((m.MePrice-s.SupPrice)*m.MeSales_volume)'营收'
from MeData.Medicine m join MeData.MedicineSales ms on m.MeID=ms.MeID join MeData.Supplier s on ms.MeID=s.MeID
group by ms.MSDate,m.MeName,ms.MeID,m.MePrice,s.SupPrice------group by后面多个列不用括号 直接逗号
select sum(s.MePrice*s.SalesAmount)'总营收' from MeData.MedicineSales s-------总营收实现不要复杂化了 直接来别受上面的惯性思维 不要把问题复杂化了再想一个简单的解决办法 先想一个简单有效的方法再将问题丰富完善
end
go

------每个医生经手的病人记录------
create procedure DrPatient as
begin
select r.DrID,r.PaID from Affairs.registration r order by r.DrID
end
go

------不同科室的病人按月份时间分布显示------
create procedure OffPatient as
begin
select r.OffName'科室',DATEPART(mm,p.PaDate)'月份',p.PaName'病人姓名',r.PaID'病人ID' from People.Patient p join Affairs.registration r on p.PaID=r.PaID order by p.PaDate
end
go

------销售量最高及销售利润最高的药品及供货商信息-----
create procedure MeSales as
begin
select Max(m.MeSales_volume)'销售量最高' ,m.MeName,m.MeID,s.SupName,s.SupID,s.SupMobile
from MeData.Medicine m join MeData.Supplier s on m.MeID=s.MeID group by m.MeName,m.MeID,s.SupName,s.SupID,s.SupMobile
select Max(m.MePrice-s.SupPrice)'利润最高' ,m.MeName,m.MeID,s.SupName,s.SupID,s.SupMobile
from MeData.Medicine m join MeData.Supplier s on m.MeID=s.MeID group by m.MeName,m.MeID,s.SupName,s.SupID,s.SupMobile
end
go


-----------------------------------------各种触发器---------------------------------------
------------------------------------------------------------------------------------------- 
------禁止对数据库中表的删除-----
create trigger Safety on DATABASE
for DROP_TABLE as
print 'You cannot drop table'
rollback
go

------设触发器给office表增添挂号病人ID------
create trigger ReOffPa on Affairs.registration
for insert,update as
begin
declare @a int,@b int,@c varchar(20)
select @a=PaID,@b=DrID,@c=OffName from inserted
insert People.Office values(@c,@b,@a)
end
go
------设触发器给Medicine当供货商发货时更新药品余量MeLeft和上次供应时间MeDate-------
create trigger MeSup on MeData.Supplier
for insert,update as
begin
declare @a int,@b int
select @a=MeID,@b=SupAmount from inserted
update MeData.Medicine set MeLeft=MeLeft+@b,MeDate=GETDATE() where MeID=@a
end
go


----------------------------------------------------------------------------------------------
-----------------演示 PLAY-----------------------------------------------
select * from MeData.Medicine where MeID=1
insert MeData.Supplier values(6,'sa','19876543201',1000,5,1,'2013-01-02')



exec OfficeRunning
exec MedicineInocme
exec DrPatient
exec OffPatient
exec MeSales

drop table People.Office

insert People.Patient values(8,'ph','M',1,'12345678918','2013-01-02')
insert Affairs.registration values(8,'Normal',10,'oa',1,'2013-01-12')
select * from People.Office









