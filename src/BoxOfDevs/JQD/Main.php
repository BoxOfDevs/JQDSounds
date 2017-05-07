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

class Main extends PluginBase implements Listener {
	
	/*
	Called when the plugin enables
	*/
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveDefaultConfig("config.yml");
		$this->sounds = new Config($this->getDataFolder()."config.yml", Config::YAML);
		$this->getLogger()->info(C::GREEN."Enabled!");
	}
	
	/*
	Called when a player joins
	@param     $event    \pocketmine\event\player\PlayerJoinEvent
	@return void
	*/
	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$level = $player->getLevel();
		$level->addSound(self::buildSound($this->sounds->get('Join'), $player));
	}
	
	/*
	Called when a player quits
	@param     $event    \pocketmine\event\player\PlayerQuitEvent
	@return void
	*/
	public function onQuit(PlayerQuitEvent $event){
		$player = $event->getPlayer();
		$level = $player->getLevel();
		$level->addSound(self::buildSound($this->sounds->get('Quit'), $player));
	}
	
	/*
	Called when a player dies
	@param     $event    \pocketmine\event\player\PlayerDeathEvent
	@return void
	*/
	public function onDeath(PlayerDeathEvent $event){
		$player = $event->getPlayer();
		$level = $player->getLevel();
		$level->addSound(self::buildSound($this->sounds->get('Death'), $player));
	}
	
	/*
	Called when the plugin disables
	*/
	public function onDisable(){
		$this->getLogger()->info(C::RED."Disabled!");
	}

	/*
	Builds a sound from it's class name.
	@param     $sound    string
	@param     $pos    \pocketmine\level\Position
	@return \pocketmine\level\sound\Sound
	*/
	protected static function buildSound(string $sound, Position $pos) : \pocketmine\level\sound\Sound {
		$sound = "pocketmine\\level\\sound\\".$sound."Sound";
		$r = new \ReflectionMethod($sound, "__construct");
		$sound = "\\".$sound;
		$params = $r->getParameters();
		if(isset($params[1]) && $params[1]->getName() == "pitch"){
			return new $sound($pos, 1);
		}else{
			return new $sound($pos);
		}
	}
}
