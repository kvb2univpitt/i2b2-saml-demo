UPDATE i2b2pm.pm_cell_data SET url = 'https://localhost/webclient/i2b2/services/QueryToolService/' WHERE cell_id  = 'CRC';
UPDATE i2b2pm.pm_cell_data SET url = 'https://localhost/webclient/i2b2/services/FRService/' WHERE cell_id  = 'FRC';
UPDATE i2b2pm.pm_cell_data SET url = 'https://localhost/webclient/i2b2/services/OntologyService/' WHERE cell_id  = 'ONT';
UPDATE i2b2pm.pm_cell_data SET url = 'https://localhost/webclient/i2b2/services/WorkplaceService/' WHERE cell_id  = 'WORK';
UPDATE i2b2pm.pm_cell_data SET url = 'https://localhost/webclient/i2b2/services/IMService/' WHERE cell_id  = 'IM';

COMMIT;

exit;
