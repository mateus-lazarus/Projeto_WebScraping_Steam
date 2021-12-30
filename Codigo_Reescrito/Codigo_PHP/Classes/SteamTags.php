<?php


class SteamTags 
{
    public int $multiplayer = 3859;
    public int $action = 19;
    public int $online_coop = 3843;
    public int $coop = 1685;
    public int $strategy = 9;
    public int $software = 8013;
    
    public function linkComTag($tag1, $valorMaximo, $tag2 = null, $tag3 = null) : string
    {
        if ($tag3 != null) {
            $steamLink = "https://store.steampowered.com/search/?maxprice=$valorMaximo&tags=$tag1%2C$tag2%2C$tag3&specials=1";
        }

        elseif ($tag2 != null) {
            $steamLink = "https://store.steampowered.com/search/?maxprice=$valorMaximo&tags=$tag1%2C$tag2&specials=1";
        }
            
        elseif ($tag1 != null) {
            $steamLink = "https://store.steampowered.com/search/?maxprice=$valorMaximo&tags=$tag1&specials=1";
        }
            
        else {
            var_dump(debug_backtrace());
        }

        return $steamLink;
    }
}