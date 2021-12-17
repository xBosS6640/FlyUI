<?php


namespace xBosS;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\TextFormat;
use jojoe77777\FormAPI\FormAPI;
use jojoe77777\FormAPI\SimpleForm;


class Main extends PluginBase implements Listener {
	
	public function onEnable() {
		$this->getLogger()->info(TEXTFORMAT::GREEN . "Plugin is enabled !");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	public function onDisable() {
		$this->getLogger()->info(TEXTFORMAT::RED . "Plugin is disabled !");
	}
	
	public function checkDepends() {
	  	$this->formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        if(is_null($this->formapi)){
            $this->getLogger()->info("[Disable] §cYou need FormAPI!");
            $this->getPluginLoader()->disablePlugin($this);
        }
	  }
	  
	  public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
	  	 switch($cmd->getName()) {
	  	 	 case "fly":
	  	 	   if ($sender instanceof Player) {
	  	 	   	  if ($sender->hasPermission("fly.command")) {
	  	 	   	  	$this->openFlyForm($sender);
	  	 	   	  } else {
	  	 	   	  	$sender->sendMessage(TEXTFORMAT::RED . "You haven't permission to do that.");
	  	 	   	  	 return false;
	  	 	   	  }
	  	 	   } else {
	  	 	   	 $sender->sendMessage(TEXTFORMAT::RED . "You must use this command in-game.");
	  	 	   	  return false;
	  	 	   }
	  	 }
	  	 return true;
	  }
	  
	  public function openFlyForm($player) {
	  	$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
	  	$form = $api->createSimpleForm(function(Player $player, int $data = null) {
	  		 if ($data === null) {
	  		 	 return true;
	  		 }
	  		  switch($data) {
	  		  	 case 0:
	  		  	  $player->setFlying(true);
	  		  	  $player->setAllowFlight(true);
	  		  	  $player->sendMessage(TEXTFORMAT::GREEN . "Fly mode is enabled !");
	  		  	   break;
	  		  	 case 1:
	  		  	  $player->setFlying(false);
	  		  	  $player->setAllowFlight(false);
	  		  	  $player->sendMessage(TEXTFORMAT::RED . "Fly mode is disabled !");
	  		  	   break;
	  		  	 case 2:
	  		  	   break;
	  		  }
	  	});
	  	
	  	$form->setTitle(TEXTFORMAT::BLUE . "Fly mode");
	  	$form->addButton(TEXTFORMAT::GREEN . "Enable", 0, "textures/gui/newgui/Dot1");
	  	$form->addButton(TEXTFORMAT::RED . "Disable", 0, "textures/gui/newgui/Dot2");
	  	$form->addButton(TEXTFORMAT::RED . "Exit", 0, "textures/ui/cancel");
	  	$form->sendToPlayer($player);
	  	 return $form;
	  }
	  
	  public function onJoin(PlayerJoinEvent $ev) {
	  	$pl = $ev->getPlayer();	  	
	  	$pl->setFlying(false);
	  	$pl->setAllowFilght(false);
	  }
}
