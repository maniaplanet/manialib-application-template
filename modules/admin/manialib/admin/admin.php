<?php
/**
 * Admin management
 * @author Maxime Raoust
 * @package admin
 */
 
require_once( dirname(__FILE__) . "/../core.inc.php" );

AdminEngine::checkAuthentication();

$request = RequestEngine::getInstance();

////////////////////////////////////////////////////////////////////////////////
// Processing
//////////////////////////////////////////////////////////////////////////////

switch($request->get("a"))
{	
	// Change password
	case "change_password":
		$login = $session->get("login");
		$current = $request->get("current");
		$new = $request->get("new");
		
		if(!$current || !$new) break;
		
		$passwordChanged = AdminEngine::changePassword($login, $current, $new);
	break;
	
	case "add_admin":
		$adminLogin = $request->get("admin_login");
		
		if(!$adminLogin) break;
		
		if(AdminEngine::exists($adminLogin)) break;
		
		$admin = new Admin($adminLogin, $adminLogin);
		$admin->dbUpdate();
		
		$adminCreated = true;
	break;
}

////////////////////////////////////////////////////////////////////////////////
// Gui
//////////////////////////////////////////////////////////////////////////////

require_once( APP_PATH . "header.php" );

$ui = new Navigation;
$ui->title->setText(__("admins"));
$ui->subTitle->setText("");
$ui->logo->setSubStyle("Profile");

switch($request->get("a"))
{
	case "choose_password":
		
		$request->delete("a");
		$link = $request->createLinkArgList();
		$request->restore("a");
		
		$ui->quitButton->setManialink($link);
		$ui->save();
		
		Manialink::beginFrame(15, 35, 2);
			
			$ui = new Panel(50, 50);
			$ui->setHalign("center");
			$ui->setPosition(0, 0, 0);
			$ui->title->setText(__("password_update"));
			$ui->save();
			
			$ui = new Label(35);
			$ui->setHalign("center");
			$ui->setPosition(0, -10, 1);
			$ui->setText(__("current_password") . ":");
			$ui->save();
			
			$ui = new Entry(35);
			$ui->setHalign("center");
			$ui->setPosition(0, -15, 1);
			$ui->setName("current");
			$ui->save();
			
			$request->set("current", "current");
			
			$ui = new Label(35);
			$ui->setHalign("center");
			$ui->setPosition(0, -20, 1);
			$ui->setText(__("new_password") . ":");
			$ui->save();
			
			$ui = new Entry(35);
			$ui->setHalign("center");
			$ui->setPosition(0, -25, 1);
			$ui->setName("new");
			$ui->save();
			
			$request->set("new", "new");
			
			$request->set("a", "change_password");
			$link = $request->createLink();
			$request->restore("a");
			
			$ui = new Button;
			$ui->setHalign("center");
			$ui->setPosition(0, -35, 1);
			$ui->setText("Continue");
			$ui->setManialink($link);
			$ui->save();
			
		Manialink::endFrame();	
		
	break;
	
	case "change_password":
	
		$request->delete("a");
		$link = $request->createLinkArgList();
		$request->restore("a");
		
		$ui->quitButton->setManialink($link);
		$ui->save();
		
		Manialink::beginFrame(15, 35, 2);
			
			$ui = new Panel(50, 50);
			$ui->setHalign("center");
			$ui->setPosition(0, 0, 0);
			$ui->title->setText(__("password_update"));
			$ui->save();
			
			$ui = new Label(35);
			$ui->setHalign("center");
			$ui->setPosition(0, -10, 1);
			if(isset($passwordChanged) && $passwordChanged)
			{
				$ui->setText(__("password_successfully_changed"));
			}
			else
			{
				$ui->setText('$f00' . __("error_while_changing_password"));
			}
			$ui->save();
			
		Manialink::endFrame();	
	break;
	
	case "choose_admin":
		$request->delete("a");
		$link = $request->createLinkArgList();
		$request->restore("a");
		
		$ui->quitButton->setManialink($link);
		$ui->save();
		
		Manialink::beginFrame(15, 35, 2);
			
			$ui = new Panel(50, 50);
			$ui->setHalign("center");
			$ui->setPosition(0, 0, 0);
			$ui->title->setText(__("new_admin"));
			$ui->save();
			
			$ui = new Label(35);
			$ui->setHalign("center");
			$ui->setPosition(0, -10, 1);
			$ui->setText("Login:");
			$ui->save();
			
			$ui = new Entry(35);
			$ui->setHalign("center");
			$ui->setPosition(0, -15, 1);
			$ui->setName("admin_login");
			$ui->save();
			
			$request->set("admin_login", "admin_login");
						
			$request->set("a", "add_admin");
			$link = $request->createLink();
			$request->restore("a");
			
			$ui = new Button;
			$ui->setHalign("center");
			$ui->setPosition(0, -35, 1);
			$ui->setText("Continue");
			$ui->setManialink($link);
			$ui->save();
			
		Manialink::endFrame();	
	break;
	
	case "add_admin":
	
		$request->delete("a");
		$link = $request->createLinkArgList();
		$request->restore("a");
		
		$ui->quitButton->setManialink($link);
		$ui->save();
		
		Manialink::beginFrame(15, 35, 2);
			
			$ui = new Panel(50, 50);
			$ui->setHalign("center");
			$ui->setPosition(0, 0, 0);
			$ui->title->setText(__("new_admin"));
			$ui->save();
			
			$ui = new Label(35);
			$ui->setHalign("center");
			$ui->setPosition(0, -10, 1);
			$ui->enableAutonewline();
			if(isset($adminCreated) && $adminCreated)
			{
				$ui->setText(__("admin_successfully_created", $adminLogin, $adminLogin));
			}
			else
			{
				$ui->setText('$f00' . __("error_while_creating_admin"));
			}
			$ui->save();
			
		Manialink::endFrame();	
	break;
	
	default:
			
		$request->set("a", "choose_admin");
		$link = $request->createLinkArgList(null, "a");
		
		$ui->addItem();
		$ui->lastItem()->text->setText(__("add_admin"));
		$ui->lastItem()->icon->setSubStyle("Solo");
		$ui->lastItem()->setManialink($link);
		
		$request->set("a", "choose_password");
		$link = $request->createLinkArgList(null, "a");
		
		$ui->addItem();
		$ui->lastItem()->text->setText(__("change_your_password"));
		$ui->lastItem()->icon->setSubStyle("Options");
		$ui->lastItem()->setManialink($link);
		
		$ui->quitButton->setManialink($request->createLinkArgList("index.php"));
		$ui->save();	
		}

require_once( APP_PATH . "footer.php" );



?>