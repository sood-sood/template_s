<?php
// inc/templates.function.php

/**
 * Создает новый шаблон и возвращает его ID.
 */
function create_template($name) {
    $template = new Template();
    return $template->add(['name' => $name]);
}

/**
 * Сохраняет изменения в шаблоне: обновляет имя и поля.
 */
function save_template($id, $name, $fields) {
    global $DB;
    $template = new Template();
    $template->update(['id' => $id, 'name' => $name]);

    // Удаляем старые поля
    $DB->query("DELETE FROM `glpi_plugin_templates_fields` WHERE templates_id = $id");
    // Добавляем новые поля из массива $fields
    foreach ($fields as $content) {
        $field = new Field();
        $field->add(['templates_id' => $id, 'content' => $content]);
    }
}

/**
 * Возвращает шаблон и его поля (для AJAX).
 */
function get_template_data($id) {
    global $DB;
    $out = ['template' => null, 'fields' => []];
    $res = $DB->query("SELECT * FROM `glpi_plugin_templates` WHERE id = $id");
    if ($DB->numRows($res)) {
        $out['template'] = $DB->fetchAssoc($res);
        $res2 = $DB->query("SELECT * FROM `glpi_plugin_templates_fields` WHERE templates_id = $id");
        while ($row = $DB->fetchAssoc($res2)) {
            $out['fields'][] = $row['content'];
        }
    }
    return $out;
}
