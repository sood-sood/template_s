<?php
// setup.php
define('TEMPLATES_VERSION', '1.0.0');

/**
 * Инициализация плагина - регистрируем хуки
 */
function plugin_init_templates() {
    global $PLUGIN_HOOKS;
    // Плагин совместим с CSRF
    $PLUGIN_HOOKS['csrf_compliant']['templates'] = true;
    // Здесь можно регистрировать дополнительные классы/хуки, если надо
}

/**
 * Информация о плагине (отображается в интерфейсе GLPI)
 */
function plugin_version_templates() {
    return [
        'name'           => 'Шаблоны заявок',
        'version'        => TEMPLATES_VERSION,
        'author'         => 'AutoGen',
        'license'        => 'GLPv3',
        'homepage'       => '',
        'minGlpiVersion' => '10.0.16'
    ];
}

/**
 * Проверка преприсловий (опционально)
 */
function plugin_templates_check_prerequisites() {
    return true;
}

/**
 * Проверка конфигурации (опционально)
 */
function plugin_templates_check_config($verbose = false) {
    return true;
}
