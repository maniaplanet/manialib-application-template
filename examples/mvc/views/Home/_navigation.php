<?php 
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

$ui = new Navigation();
$ui->logo->setImage('logo64.dds');
$ui->title->setText(__('ManiaLib'));
$ui->subTitle->setText(__('empower_your_manialinks'));

$manialink = $request->createLink(Route::CUR, Route::NONE);
$selected = $request->getAction('about') == 'about';

$ui->addItem();
$ui->lastItem->setManialink($manialink);
if($selected) $ui->lastItem->setSelected();
$ui->lastItem->icon->setSubStyle(Icons128x128_1::Manialink);
$ui->lastItem->text->setText(__('about'));

$manialink = $request->createLink(Route::CUR, 'features');
$selected = $request->getAction() == 'features';

$ui->addItem();
$ui->lastItem->setManialink($manialink);
if($selected) $ui->lastItem->setSelected();
$ui->lastItem->icon->setSubStyle(Icons128x128_1::Forever);
$ui->lastItem->text->setText(__('features'));

$manialink = $request->createLink(Route::CUR, 'download');
$selected = $request->getAction() == 'download';

$ui->addItem();
$ui->lastItem->setManialink($manialink);
if($selected) $ui->lastItem->setSelected();
$ui->lastItem->icon->setSubStyle(Icons128x128_1::Load);
$ui->lastItem->text->setText(__('download'));

$manialink = $request->createLink(Route::CUR, 'showcase');
$selected = $request->getAction() == 'showcase';

$ui->addItem();
$ui->lastItem->setManialink($manialink);
if($selected) $ui->lastItem->setSelected();
$ui->lastItem->icon->setSubStyle(Icons128x128_1::ServersSuggested);
$ui->lastItem->text->setText(__('showcase'));

$manialink = $request->createLink('examples', Route::NONE);

$ui->addItem();
$ui->lastItem->setManialink($manialink);
$ui->lastItem->icon->setSubStyle(Icons128x128_1::Browse);
$ui->lastItem->text->setText(__('sample_pages'));

$manialink = $request->createLink('shoutbox', Route::NONE);

$ui->addItem();
$ui->lastItem->setManialink($manialink);
$ui->lastItem->icon->setSubStyle(Icons128x128_1::Share);
$ui->lastItem->text->setText(__('shoutbox'));

$ui->quitButton->setManialink('Manialink:home');
$ui->save();

?>