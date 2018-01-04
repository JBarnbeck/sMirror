<?php
/**
 * Created by PhpStorm.
 * User: Matthias
 * Date: 02.01.2018
 * Time: 20:32
 */
require __DIR__ . '/vendor/autoload.php';

/*use Tracy\Debugger;

Debugger::enable();*/

$config = parse_ini_file('config.ini');
if (!$config || !isset($config['kategorie'])) {
    throw new \Exception('Datei config.ini nicht vorhanden, oder keine Kategorie eingetragen');
}
$kategorie = $config['kategorie'];

$file = fopen(__DIR__ . '/smirror-sprueche.csv', 'r');

if (!$file) {
    throw new \Exception('Datei smirror-sprueche.csv ist nicht vorhanden / nicht lesbar');
}

$sprueche = [];
while (($line = fgetcsv($file)) !== FALSE) {
    $sprueche[] = $line;
}
fclose($file);


$ausgewaehlteSprueche = [];

foreach ($sprueche as $spruch) {
    if ($spruch[0] == $kategorie) {
        $ausgewaehlteSprueche[] = $spruch;
    }
}

if (count($ausgewaehlteSprueche) == 0) {
    throw new \Exception('Keine Sprüche in dieser Kategorie vorhanden');
}

$anzahlSprueche = count($ausgewaehlteSprueche);
$spruchDesTages = spruchDesTages((int) date('d'), $anzahlSprueche);

$spruch = $ausgewaehlteSprueche[$spruchDesTages - 1];

function spruchDesTages($tag, $anzahlSprueche)
{
    $nummer = $tag % $anzahlSprueche;
    if ($nummer == 0) {
        $nummer = $anzahlSprueche;
    }

    return $nummer;
}