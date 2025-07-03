<?php
// front/ticket.form.php
include ("../../../inc/includes.php");
$plugin = new Plugin();
if (!$plugin->isInstalled('templates') || !$plugin->isActivated('templates')) {
    Html::displayNotFoundError();
}
Html::header('Создать заявку с шаблоном', $_SERVER['PHP_SELF'], 'plugins', 'templates');

// Обработка сохранения заявки (если нужно через плагин)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
   // Создаем новую заявку (упрощенно: только описание)
   $ticket = new Ticket();
   $ticket_id = $ticket->add([
       'name'    => trim(substr($_POST['description'], 0, 50)) ?: 'Новая заявка',
       'content' => $_POST['description']
   ]);
   if ($ticket_id) {
       echo '<div class="confirmation">Заявка создана (ID='.$ticket_id.').</div>';
   }
}

// Интерфейс: поле описания и кнопки
echo "<form method='post'>";
echo "<table class='tab_cadre_fixe'><tr><th>Описание:</th>";
echo "<td><textarea id='description' name='description' rows='5' cols='60'></textarea></td>";
echo "</tr><tr><th></th><td>";
echo "<button type='button' id='choose-template'>Выбор шаблонов</button> ";
echo "<input type='submit' name='save' value='Сохранить заявку' /> ";
echo "<button type='button' id='edit-template'>Редактировать шаблон</button>";
echo "</td></tr></table></form>";

Html::footer();
