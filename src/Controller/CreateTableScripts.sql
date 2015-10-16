CREATE IF NOT EXISTS TABLE [answer]
 ('AnswerId' INTEGER NOT NULL PRIMARY KEY, 
'UserId' INTEGER, 
'DestId' INTEGER, 
'OptionId' INTEGER, 
'CreatedDate' DATETIME);

CREATE TABLE [destination] 
            ('DestId' INTEGER NOT NULL PRIMARY KEY, 
            'DestName' TEXT NOT NULL, 
            'Lat' BOOLEAN NOT NULL, 
            'Long' BOOLEAN NOT NULL);
                    
CREATE TABLE [question] 
            ('QuestionId' INTEGER NOT NULL PRIMARY KEY, 
             'QuestionText' TEXT NOT NULL);

CREATE TABLE [comment_and_like] 
('UserId' INTEGER NOT NULL, 
'DestId' INTEGER NOT NULL, 
'LikeCount' INTEGER NOT NULL, 
'CommentText' TEXT, 
'CreatedDate' DATETIME NOT NULL);



CREATE TABLE [images] 
('ImageId' INTEGER NOT NULL PRIMARY KEY, 
'ImagePath' TEXT NOT NULL, 
'UserId' INTEGER NOT NULL, 
'DestId' INTEGER NOT NULL,
'ImageSeen'  BOOLEAN NOT NULL);

CREATE TABLE [options]
 ('OptionId' INTEGER NOT NULL PRIMARY KEY,
 'OptionText' TEXT NOT NULL, 
'QuestionId' INTEGER NOT NULL);

CREATE TABLE [stat_conf] 
('Key' TEXT NOT NULL PRIMARY KEY,
 'Value' TEXT NOT NULL);

CREATE TABLE [user] 
('UserId' INTEGER NOT NULL PRIMARY KEY, 
'UserName' TEXT NOT NULL,
'PhotoURL'  TEXT NOT NULL);



CREATE TABLE [MyMap]
('MapId'    INTEGER PRIMARY KEY AUTOINCREMENT,
'RouteName'     TEXT NOT NULL,
'RouteJson'     TEXT NOT NULL,
'CreatedDate'   DATETIME NOT NULL);

CREATE TABLE [MyImages]
('ImageId' INTEGER PRIMARY KEY  AUTOINCREMENT,
'ImagePath'           TEXT   NOT NULL,
'CreateDate'          DATETIME   NOT NULL); 

CREATE TABLE [TempData]
('Id' INTEGER PRIMARY KEY AUTOINCREMENT,
 'DestId'           INT   NOT NULL,
'DestName'         TEXT   NOT NULL,
'Lat'              DOUBLE NOT NULL,
'Long'             DOUBLE NOT NULL );

CREATE TABLE [MyUser]
('UserId'    INTEGER PRIMARY KEY NOT NULL ,
 'UserName'     TEXT NOT NULL,
 'UserEmail'     TEXT NOT NULL,
 'PhotoURL'      TEXT NOT NULL,
 'APIKey'        TEXT NOT NULL,
 'LginSource'    TEXT NOT NULL); 


CREATE TABLE [Sync](
'SyncAutoNo' INT PRIMARY KEY NOT NULL AUTOINCREMENT,
'UserId'     INT NOT NULL,
'JsonSync'   TEXT NOT NULL,
'TableName'  TEXT NOT NULL); 


              