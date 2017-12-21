#SQL-скрипт останавливал своё выполнение из-за того, что внешние ключи не создавались из-за разных типов полей, поэтому в скрипт создания таблиц и записей после создания таблиц добавил:

#ALTER TABLE `machines_options`
#	CHANGE COLUMN `machine_id` `machine_id` BIGINT UNSIGNED NOT NULL;

#ALTER TABLE `machines_options_set`
#	CHANGE COLUMN `machine_id` `machine_id` BIGINT UNSIGNED NOT NULL;

#Предполагаю, что связь между machines и machines_options один к одному, хотя изначальная структура таблицы machines_options говорит о том, что связь один ко многим. Для удобства работы и для создания связи один к одному добавил primary key:
#ALTER TABLE `machines_options`
#	ADD PRIMARY KEY (`machine_id`); 


#Таблицы machines и machines_options_set имеют связь один ко многим. Оставил данную связь без изменений, однако чтобы можно было, например, удалять запись, добавил поле id:

#ALTER TABLE `machines_options_set`
#	ADD COLUMN `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT 
#		PRIMARY KEY FIRST;

##ниже с учётом комментариев обновлённый скрипт создания таблиц и записей
CREATE TABLE machines (  
	id SERIAL PRIMARY KEY NOT NULL,  
	serial bigint NOT NULL ); 
CREATE UNIQUE INDEX machines_serial_index ON machines (serial);

CREATE TABLE machines_options (  
	machine_id int NOT NULL,  
	firmware VARCHAR(32),  
	connect_freq int NOT NULL ); 
CREATE INDEX machines_options_machine_id_index 
	ON machines_options (machine_id);
ALTER TABLE `machines_options`
	CHANGE COLUMN `machine_id` `machine_id` BIGINT UNSIGNED NOT NULL;
ALTER TABLE `machines_options`
	ADD PRIMARY KEY (`machine_id`);
ALTER TABLE machines_options 
	ADD FOREIGN KEY (machine_id) REFERENCES machines (id);

CREATE TABLE machines_options_set (  
	machine_id int NOT NULL,  
	connect_freq int ); 
CREATE INDEX machines_options_set_mahcine_id_index 
	ON machines_options_set (machine_id); 
ALTER TABLE `machines_options_set`
	CHANGE COLUMN `machine_id` `machine_id` BIGINT UNSIGNED NOT NULL;
ALTER TABLE machines_options_set 
	ADD FOREIGN KEY (machine_id) REFERENCES machines (id);
ALTER TABLE `machines_options_set`
	ADD COLUMN `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT 
		PRIMARY KEY FIRST;

INSERT INTO machines (serial) VALUES (123456789012345); 
INSERT INTO machines_options (machine_id, firmware, connect_freq) 
	VALUES (1, '1.01a', 5); 
INSERT INTO machines_options_set (machine_id, connect_freq) VALUES (1, 10);
