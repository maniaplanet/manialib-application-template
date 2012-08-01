<?php

use ManiaLib\Gui\Cards\Navigation\Menu;
use ManiaLib\Gui\Elements\Icons128x128_1;

// Navigation menu that looks like the official menus
// This file is to be included in other pages

$ui = new Menu();
$ui->setPosition(-150, 90, 1);
$ui->logo->setSubStyle(Icons128x128_1::Advanced);
$ui->title->setText('ManiaLib');
$ui->subTitle->setText('Examples to help you get started');
//$ui->titleBg->setImage('http://some-url/title-background.jpg', true);

$ui->addItem();
$ui->lastItem->icon->setSubStyle(Icons128x128_1::Beginner);
$ui->lastItem->text->setText('GUI toolkit');
$ui->lastItem->setManialink('./gui-toolkit.php');
$ui->lastItem->setSelected(); // With an if condition, you can easilly select the right button...

$ui->addItem();
$ui->lastItem->icon->setSubStyle(Icons128x128_1::Easy);
$ui->lastItem->text->setText('ManiaScript framework');
$ui->lastItem->setManialink('./maniascript-framework.php');

$ui->quitButton->text->setText('Quit');
$ui->quitButton->setAction(0); // Use "0" to close the Manialink browser

$ui->save();
?>