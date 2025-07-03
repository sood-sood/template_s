<?php
// inc/hook.php
if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

/**
 * Установка плагина: создание таблиц glpi_plugin_templates и glpi_plugin_templates_fields
 */
function plugin_templates_install() {
   global $DB;
   $migration = new Migration(100);

   // Таблица шаблонов
   if (!$DB->tableExists('glpi_plugin_templates')) {
      $query = "CREATE TABLE `glpi_plugin_templates` (
                  `id` INT(11) NOT NULL AUTO_INCREMENT,
                  `name` VARCHAR(255) NOT NULL,
                  PRIMARY KEY (`id`)
               ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
      $DB->queryOrDie($query, $DB->error());
   }
   // Таблица полей шаблона
   if (!$DB->tableExists('glpi_plugin_templates_fields')) {
      $query = "CREATE TABLE `glpi_plugin_templates_fields` (
                  `id` INT(11) NOT NULL AUTO_INCREMENT,
                  `templates_id` INT(11) NOT NULL,
                  `content` TEXT NOT NULL,
                  PRIMARY KEY (`id`),
                  INDEX (`templates_id`)
               ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
      $DB->queryOrDie($query, $DB->error());
   }

   $migration->executeMigration();
   return true;
}

/**
 * Удаление плагина: удаление таблиц
 */
function plugin_templates_uninstall() {
   global $DB;
   $tables = ['templates', 'templates_fields'];
   foreach ($tables as $suffix) {
      $tablename = "glpi_plugin_templates" . ($suffix ? "_$suffix" : "");
      if ($DB->tableExists($tablename)) {
         $DB->queryOrDie("DROP TABLE `$tablename`", $DB->error());
      }
   }
   return true;
}
