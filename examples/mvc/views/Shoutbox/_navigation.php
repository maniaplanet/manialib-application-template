<?php 
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

$ui = new Navigation();
$ui->logo->setSubStyle(Icons128x128_1::Share);
$ui->title->setText(__('shoutbox'));
$ui->subTitle->setText(__('shoutbox_example'));

$manialink = $request->createLink(Route::CUR, Route::NONE);
$selected = $request->getAction('viewShouts') == 'viewShouts';

$ui->addItem();
$ui->lastItem->setManialink($manialink);
if($selected) $ui->lastItem->setSelected();
$ui->lastItem->icon->setSubStyle(Icons128x128_1::Share);
$ui->lastItem->text->setText(__('view_shouts'));

$manialink = $request->createLink(Route::DEF, Route::NONE);

$ui->quitButton->setManialink($manialink);
$ui->save();

?>