<?php
// front/templates.php
include ("../../../inc/includes.php");
$plugin = new Plugin();
if (!$plugin->isInstalled('templates') || !$plugin->isActivated('templates')) {
    Html::displayNotFoundError();
}
Html::header('Шаблоны заявок', $_SERVER['PHP_SELF'], 'plugins', 'templates');

// Обработка создания/сохранения шаблона
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action === 'create_template' && !empty($_POST['name'])) {
            create_template($_POST['name']);
            Html::redirect($CFG_GLPI['root_doc'].'/plugins/templates-plugin/front/templates.php');
        }
        if ($action === 'save_template' && !empty($_POST['id'])) {
            $fields = json_decode($_POST['fields'], true);
            save_template((int)$_POST['id'], $_POST['name'], $fields);
            Html::redirect($CFG_GLPI['root_doc'].'/plugins/templates-plugin/front/templates.php');
        }
    }
}

// Если указан id – выводим форму редактирования
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $data = get_template_data($id);
    echo "<h2>Редактирование шаблона</h2>";
    echo "<form method='post'>";
    echo "<input type='hidden' name='action' value='save_template'>";
    echo "<input type='hidden' name='id' value='$id'>";
    echo "<table class='tab_cadre_fixe'><tr><th>Название:</th>";
    echo "<td><input type='text' name='name' value=\"".Html::cleanTextField($data['template']['name'])."\" /></td></tr>";
    echo "<tr><th>Поля шаблона:</th><td>";
    // Выводим существующие поля
    foreach ($data['fields'] as $idx => $content) {
        echo "<div><textarea name='field_{$idx}' class='template-field'>".Html::cleanTextField($content)."</textarea></div>";
    }
    echo "<div id='fields-container'></div>";
    echo "<button type='button' id='add-field'>Добавить поле</button>";
    echo "</td></tr>";
    echo "<tr><th></th><td><input type='submit' value='Сохранить' /></td></tr>";
    echo "</table></form>";
    Html::footer();
    exit;
}

// Иначе – отображаем список шаблонов
echo "<h2>Список шаблонов</h2>";
echo "<table class='tab_cadre_fixe'><tr><th>ID</th><th>Название</th><th>Действия</th></tr>";
$res = $DB->query("SELECT * FROM `glpi_plugin_templates` ORDER BY name");
while ($row = $DB->fetchAssoc($res)) {
    $id = $row['id'];
    $name = Html::cleanTextField($row['name']);
    echo "<tr>";
    echo "<td>$id</td><td>$name</td><td>";
    echo "<a href='".$_SERVER['PHP_SELF']."?id=$id'>Редактировать</a> ";
    echo "<a href='".$_SERVER['PHP_SELF']."?delete=$id' onclick=\"return confirm('Удалить шаблон?');\">Удалить</a>";
    echo "</td></tr>";
}
echo "</table>";

// Форма создания нового шаблона
echo "<h2>Создать шаблон</h2>";
echo "<form method='post'><input type='hidden' name='action' value='create_template'>";
echo "<input type='text' name='name' />";
echo "<input type='submit' value='Создать' />";
echo "</form>";

Html::footer();
