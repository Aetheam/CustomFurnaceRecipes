<?php

namespace royal\furnacerecipes;

use pocketmine\crafting\ExactRecipeIngredient;
use pocketmine\crafting\FurnaceRecipe;
use pocketmine\crafting\FurnaceType;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener
{
    protected function onEnable(): void
    {
        $this->saveDefaultConfig();
        $recipes = $this->getConfig()->get("recipes");
        foreach ($recipes as $recipe){
            $input = StringToItemParser::getInstance()->parse($recipe["input"]);
            $output = StringToItemParser::getInstance()->parse($recipe["output"]);
            $this->registerFurnace($input, $output);
        }
    }
    
    public function registerFurnace(Item $input, Item $output): void {
        $furnaceRecipe = new FurnaceRecipe(
            $output,
            new ExactRecipeIngredient($input)
        );
        $manager = $this->getServer()->getCraftingManager()->getFurnaceRecipeManager(FurnaceType::FURNACE());
        $manager->register($furnaceRecipe);
    }
}
