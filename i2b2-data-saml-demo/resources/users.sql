INSERT INTO pm_user_data (user_id,full_name,"password",entry_date,status_cd) VALUES ('ckent','Clark Kent','9117d59a69dc49807671a51f10ab7f',current_timestamp,'A');
INSERT INTO pm_user_data (user_id,full_name,"password",entry_date,status_cd) VALUES ('kdanvers','Kara Danvers','9117d59a69dc49807671a51f10ab7f',current_timestamp,'A');

INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','kdanvers','USER',current_timestamp,'A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','kdanvers','DATA_DEID',current_timestamp,'A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','kdanvers','DATA_OBFSC',current_timestamp,'A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','kdanvers','DATA_AGG',current_timestamp,'A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','kdanvers','DATA_LDS',current_timestamp,'A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','kdanvers','EDITOR',current_timestamp,'A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','kdanvers','DATA_PROT',current_timestamp,'A');

INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent','USER',current_timestamp,'A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent','DATA_DEID',current_timestamp,'A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent','DATA_OBFSC',current_timestamp,'A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent','DATA_AGG',current_timestamp,'A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent','DATA_LDS',current_timestamp,'A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent','EDITOR',current_timestamp,'A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,entry_date,status_cd) VALUES ('Demo','ckent','DATA_PROT',current_timestamp,'A');

INSERT INTO pm_user_params (datatype_cd,user_id,param_name_cd,value,entry_date,status_cd) VALUES ('T','kdanvers','eppn','karadanvers@catco.com',current_timestamp,'A');
INSERT INTO pm_user_params (datatype_cd,user_id,param_name_cd,value,entry_date,status_cd) VALUES ('T','ckent','eppn','ckent@dailyplanet.com',current_timestamp,'A');
INSERT INTO pm_user_params (datatype_cd,user_id,param_name_cd,value,entry_date,status_cd) VALUES ('T','ckent','eppn','clarkkent@catco.com',current_timestamp,'A');
