<?php 
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

$ui = new Navigation();
$ui->logo->setSubStyle(Icons128x128_1::Browse);
$ui->title->setText(__('sample_pages'));
$ui->subTitle->setText(__('a_few_examples'));

$manialink = $request->createLink(Route::CUR, Route::NONE);
$selected = $request->getAction('layouts') == 'layouts';

$ui->addItem();
$ui->lastItem->setManialink($manialink);
if($selected) $ui->lastItem->setSelected();
$ui->lastItem->icon->setSubStyle(Icons128x128_1::Editor);
$ui->lastItem->text->setText(__('layouts'));

$manialink = $request->createLink(Route::CUR, 'tracks');
$selected = $request->getAction() == 'tracks';

$ui->addItem();
$ui->lastItem->setManialink($manialink);
if($selected) $ui->lastItem->setSelected();
$ui->lastItem->icon->setSubStyle(Icons128x128_1::Editor);
$ui->lastItem->text->setText(__('tracks'));

$manialink = $request->createLink(Route::DEF, Route::NONE);

$ui->quitButton->setManialink($manialink);
$ui->save();

?>