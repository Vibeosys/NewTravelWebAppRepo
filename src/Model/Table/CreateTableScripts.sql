CREATE TABLE [answer]
 ('AnswerId' TEXT NOT NULL PRIMARY KEY, 
'UserId' TEXT, 
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
('UserId' TEXT NOT NULL, 
'DestId' INTEGER NOT NULL, 
'LikeCount' INTEGER NOT NULL DEFAULT 0, 
'CommentText' TEXT, 
'CreatedDate' DATETIME);



CREATE TABLE [images] 
('ImageId' TEXT NOT NULL PRIMARY KEY, 
'ImagePath' TEXT NOT NULL, 
'UserId' TEXT NOT NULL, 
'DestId' INTEGER NOT NULL,
'ImageSeen'  BOOLEAN NOT NULL);

CREATE TABLE [options]
 ('OptionId' INTEGER NOT NULL PRIMARY KEY,
 'OptionText' TEXT NOT NULL, 
'QuestionId' INTEGER NOT NULL);

CREATE TABLE [stat_conf] 
('Key' TEXT NOT NULL,
 'Value' TEXT NOT NULL);

CREATE TABLE [user] 
('UserId' TEXT NOT NULL PRIMARY KEY, 
'UserName' TEXT NOT NULL,
'PhotoURL'  TEXT NOT NULL);



CREATE TABLE [MyMap]
('MapId'    INTEGER PRIMARY KEY AUTOINCREMENT,
'RouteName'     TEXT NOT NULL,
'RouteJson'     TEXT NOT NULL,
'CreatedDate'   DATETIME NOT NULL);

CREATE TABLE [MyImages]
('ImageId' TEXT PRIMARY KEY,
'ImagePath'           TEXT   NOT NULL,
'CreateDate'          DATETIME   NOT NULL); 

CREATE TABLE [TempData]
('Id' INTEGER PRIMARY KEY AUTOINCREMENT,
 'DestId'           INTEGER   NOT NULL,
 'DestName'         TEXT   NOT NULL,
 'Lat'              DOUBLE NOT NULL,
 'Long'             DOUBLE NOT NULL );

CREATE TABLE [MyUser]
('UserId'    TEXT PRIMARY KEY NOT NULL ,
 'UserName'     TEXT  NULL,
 'UserEmail'     TEXT  NULL,
 'PhotoURL'      TEXT  NULL,
 'APIKey'        TEXT  NULL,
 'LginSource'    TEXT  NULL); 


CREATE TABLE [Sync](
 'SyncAutoNo' INTEGER PRIMARY KEY AUTOINCREMENT,
 'UserId'     TEXT NOT NULL,
 'JsonSync'   TEXT NOT NULL,
 'TableName'  TEXT NOT NULL); 


              