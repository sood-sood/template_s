// js/script.js
$(document).ready(function() {
  // Переход к состоянию 2: загрузка списка шаблонов
  $('#choose-template').click(function() {
    $.get('ajax/get_template.php', {}, function() {
      // Логика перехода на страницу templates.php
      window.location = '../front/templates.php';
    });
  });

  // Кнопка «Редактировать шаблон»: просто переходит к списку,
  // где пользователь может нажать «Редактировать» у выбранного шаблона.
  $('#edit-template').click(function() {
    window.location = '../front/templates.php';
  });

  // Добавление нового поля (в состоянии 3)
  $(document).on('click', '#add-field', function() {
    $('#fields-container').append('<div><textarea class="template-field"></textarea></div>');
  });

  // Подготовка данных полей при отправке (конвертация в JSON)
  $('form').submit(function() {
    var fields = [];
    $('.template-field').each(function() {
      fields.push($(this).val());
    });
    $('<input>').attr({
        type: 'hidden',
        name: 'fields',
        value: JSON.stringify(fields)
    }).appendTo('form');
    return true;
  });
});
