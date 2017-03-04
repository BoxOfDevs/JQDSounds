<?php

namespace BoxOfDevs\JQD;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\level\Position;
use pocketmine\level\sound\Sound;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\level\sound\AnvilFallSound;
use pocketmine\level\sound\PopSound;
use pocketmine\level\sound\BatSound;
use pocketmine\level\sound\BlazeShootSound;
use pocketmine\level\sound\DoorSound;
use pocketmine\level\sound\FizzSound;
use pocketmine\level\sound\GhastSound;

class Main extends PluginBase implements Listener {
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->sounds = new Config($this->getDataFolder()."config.yml", Config::YAML);
		$this->saveDefaultConfig("config.yml");
		$this->getLogger()->info(C::GREEN."Enabled!");
	}
	
	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$level = $player->getLevel();
		$level->addSound(new ($this->sounds->get("Join"))($player));
	}
	
	public function onQuit(PlayerQuitEvent $event){
		$player = $event->getPlayer();
		$level = $player->getLevel();
		$level->addSound(new ($this->sounds->get("Quit"))($player));
	}
	
	public function onDeath(PlayerDeathEvent $event){
		$player = $event->getPlayer();
		$level = $player->getLevel();
		$level->addSound(new ($this->sounds->get("Death"))($player));
	}
	
	public function onDisable(){
		$this->getLogger()->info(C::RED."Disabled!");
	}
}
