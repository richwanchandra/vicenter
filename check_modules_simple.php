<?php
// Simple check without Laravel bootstrap
$pdo = new PDO('mysql:host=127.0.0.1;dbname=vilokantordb', 'root', '');

echo "=== Modules containing 'Penggajian' ===" . PHP_EOL;
$stmt = $pdo->prepare("SELECT id, name, parent_id FROM modules WHERE LOWER(name) LIKE ?");
$stmt->execute(['%penggajian%']);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: {$row['id']}, Name: {$row['name']}, Parent: {$row['parent_id']}\n";
}

echo "\n=== HRD Direct Children ===" . PHP_EOL;
$stmt = $pdo->prepare("
    SELECT m.id, m.name FROM modules m
    WHERE m.parent_id = (SELECT id FROM modules WHERE name LIKE '%HRD%' LIMIT 1)
    ORDER BY m.name
");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "  - {$row['name']}\n";
}
