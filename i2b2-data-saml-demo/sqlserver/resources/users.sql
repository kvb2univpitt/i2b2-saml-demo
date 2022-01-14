INSERT INTO i2b2pm.dbo.pm_user_data (user_id,full_name,password,entry_date,status_cd) VALUES ('ckent','Kal-El','9117d59a69dc49807671a51f10ab7f',current_timestamp,'A');
INSERT INTO i2b2pm.dbo.pm_user_data (user_id,full_name,password,entry_date,status_cd) VALUES ('ckent@dailyplanet.com','Clark Kent','9117d59a69dc49807671a51f10ab7f',current_timestamp,'A');

INSERT INTO i2b2pm.dbo.pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent','USER',current_timestamp,'A');
INSERT INTO i2b2pm.dbo.pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent','DATA_DEID',current_timestamp,'A');
INSERT INTO i2b2pm.dbo.pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent','DATA_OBFSC',current_timestamp,'A');
INSERT INTO i2b2pm.dbo.pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent','DATA_AGG',current_timestamp,'A');
INSERT INTO i2b2pm.dbo.pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent','DATA_LDS',current_timestamp,'A');
INSERT INTO i2b2pm.dbo.pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent','EDITOR',current_timestamp,'A');
INSERT INTO i2b2pm.dbo.pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent','DATA_PROT',current_timestamp,'A');

INSERT INTO i2b2pm.dbo.pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent@dailyplanet.com','USER',current_timestamp,'A');
INSERT INTO i2b2pm.dbo.pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent@dailyplanet.com','DATA_DEID',current_timestamp,'A');
INSERT INTO i2b2pm.dbo.pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent@dailyplanet.com','DATA_OBFSC',current_timestamp,'A');
INSERT INTO i2b2pm.dbo.pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent@dailyplanet.com','DATA_AGG',current_timestamp,'A');
INSERT INTO i2b2pm.dbo.pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent@dailyplanet.com','DATA_LDS',current_timestamp,'A');
INSERT INTO i2b2pm.dbo.pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent@dailyplanet.com','EDITOR',current_timestamp,'A');
INSERT INTO i2b2pm.dbo.pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent@dailyplanet.com','DATA_PROT',current_timestamp,'A');

INSERT INTO i2b2pm.dbo.pm_user_params (datatype_cd,user_id,param_name_cd,value,entry_date,status_cd) VALUES ('T','ckent@dailyplanet.com','authentication_method','SAML',current_timestamp,'A');
GO
