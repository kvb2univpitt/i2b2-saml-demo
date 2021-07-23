INSERT INTO pm_user_data (user_id,full_name,"password",status_cd) VALUES ('ckent','Clark Kent','9117d59a69dc49807671a51f10ab7f','A');
INSERT INTO pm_user_data (user_id,full_name,"password",status_cd) VALUES ('kdanvers','Kara Danvers','9117d59a69dc49807671a51f10ab7f','A');

INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,status_cd) VALUES ('Demo','kdanvers','USER','A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,status_cd) VALUES ('Demo','kdanvers','DATA_DEID','A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,status_cd) VALUES ('Demo','kdanvers','DATA_OBFSC','A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,status_cd) VALUES ('Demo','kdanvers','DATA_AGG','A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,status_cd) VALUES ('Demo','kdanvers','DATA_LDS','A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,status_cd) VALUES ('Demo','kdanvers','EDITOR','A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,status_cd) VALUES ('Demo','kdanvers','DATA_PROT','A');

INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,status_cd) VALUES ('Demo','ckent','USER','A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,status_cd) VALUES ('Demo','ckent','DATA_DEID','A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,status_cd) VALUES ('Demo','ckent','DATA_OBFSC','A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,status_cd) VALUES ('Demo','ckent','DATA_AGG','A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,status_cd) VALUES ('Demo','ckent','DATA_LDS','A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,status_cd) VALUES ('Demo','ckent','EDITOR','A');
INSERT INTO pm_project_user_roles (project_id,user_id,user_role_cd,status_cd) VALUES ('Demo','ckent','DATA_PROT','A');

INSERT INTO pm_user_params (datatype_cd,user_id,param_name_cd,value,entry_date,status_cd) VALUES ('T','kdanvers','eppn','karadanvers@catco.com',current_timestamp,'A');
INSERT INTO pm_user_params (datatype_cd,user_id,param_name_cd,value,entry_date,status_cd) VALUES ('T','ckent','eppn','ckent@dailyplanet.com',current_timestamp,'A');
INSERT INTO pm_user_params (datatype_cd,user_id,param_name_cd,value,entry_date,status_cd) VALUES ('T','ckent','eppn','clarkkent@catco.com',current_timestamp,'A');
