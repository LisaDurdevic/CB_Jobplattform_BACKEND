<?php

class Username {

    //MAIN FUNCTION
        function create() {
            //username will contain two random words and one random int. You can always add more words. 
            //Watch for correct pronouncing (especially in combination with the middle word) and how people could understand possible combinations
            //maximum length 30!!
            
                //KEYWORDS
                $start = array("muntere", "motivierte", "aufmerksame", "begeisterte", "freundliche", "charmante", "ehrliche", "edle", "eifrige", "elegante", "engagierte", "entspannte", "faehige", "fantastische", "fleissige", "frische", "froehliche", "geschickte", "glueckliche", "heitere", "kluge", "laechelnde", "lebendige", "malerische", "positive", "schicke", "sympathische", "treue", "vielfaeltige", "wertvolle", "wunderbare");
                $middle = array("rHund", "Katze", "sKaninchen", "rSpecht", "rSpatz", "rHamster", "sPferd", "Schildkroete", "sAxolotl", "rFisch", "Amsel", "rFink", "Ameise", "Kaefer");
                $i = random_int(0, sizeOf($start)-1);
                $j = random_int(0, sizeOf($middle)-1);
                $end = random_int(0, 100);

            $string = $start[$i] . $middle[$j] . $end;
            $this->name = $string;
        }

    //TEST FUNCTION
        function createTestperson () {
            if (isset($this->i)) {
                $this->i++;
            } else {
                $this->i = 1;
            }
            $this->name = "Testperson" . $this->i;
        }   
}
?>