<?php
$userName = new Username();
return $userName->create();

class Username {

        /**
         * create a new random username for unique identification on the plattform
         * 
         * @var array $start contains several adjectives for the first part of the username which should only be positive and for easier spelling written in female (ending with -e)
         * @var array $middle contains several nouns for the middle part of the username including the gender-depending ending letter for the adjective (r for male, s for neuter)
         * @var int $i provides a random number to choose from $start
         * @var int $j provides a random number to choose from $middle
         * @var int $end provides a random number for the last part of the username to provide a greater range of combinations
         * @var string $string contains final username
         * 
         * @return string with freshly baken new userName
         * 
         * usernames have a maximum length of 30 letters in the db
         */
        function create() {            
                $start = array("muntere", "motivierte", "aufmerksame", "begeisterte", "freundliche", "charmante", "ehrliche", "edle", "eifrige", "elegante", "engagierte", "entspannte", "faehige", "fantastische", "fleissige", "frische", "froehliche", "geschickte", "glueckliche", "heitere", "kluge", "laechelnde", "lebendige", "malerische", "positive", "schicke", "sympathische", "treue", "vielfaeltige", "wertvolle", "wunderbare");
                $middle = array("rHund", "Katze", "sKaninchen", "rSpecht", "rSpatz", "rHamster", "sPferd", "Schildkroete", "sAxolotl", "rFisch", "Amsel", "rFink", "Ameise", "rKaefer");
                $i = random_int(0, sizeOf($start)-1);
                $j = random_int(0, sizeOf($middle)-1);
                $end = random_int(0, 100);

            $string = $start[$i] . $middle[$j] . $end;
            return $string;
        }
}
?>