<?php
// ajax/get_template.php
include ("../../inc/includes.php");
$plugin = new Plugin();
if (!$plugin->isInstalled('templates') || !$plugin->isActivated('templates')) {
    echo json_encode(['error' => 'Plugin not active']);
    exit;
}
$id = (int)$_GET['id'];
$data = get_template_data($id);
echo json_encode($data);
