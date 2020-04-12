<?php 

    class Bolnica {
        public $ime;
        public $adresa;
        public $odeljenja = [];
        public $doktori = [];

        public function __construct($ime, $adresa) {
            $this->ime = $ime;
            $this->adresa = $adresa;
            $this->dodajOdeljenja();
        }

        public function dodajOdeljenja() {
            for($i = 0; $i <= 3; $i++) {
                $imeOdeljenja = ['Hirurgija', 'Intenzivna nega', 'Laboratorija', 'Kardiologija'];
                $this->odeljenja[] = new Odeljenje($imeOdeljenja[$i]);
            }
        }
    }

    class Odeljenje {
        public static $brojac = 1;
        public $brojOdeljenja;
        public $imeOdeljenja;

        public function __construct($imeOdeljenja) {
            $this->imeOdeljenja = $imeOdeljenja;
            $this->brojOdeljenja = self::$brojac++;
        }
    }
    
    abstract class Osoba {
        public $ime;
        private $jmbg;

        public function __construct($ime, $jmbg) {
            $this->ime = $ime;
            $this->jmbg = $jmbg;
        }
    }

    class Doktor extends Osoba {
        public $specijalizacija;

        public function __construct($ime, $jmbg, $specijalizacija) {
            parent::__construct($ime, $jmbg);
            $this->specijalizacija = $specijalizacija;
        }
    }

    class Pacijent extends Osoba {
        public $brojKartona;

        public function __construct($ime, $jmbg, $brojKartona) {
            parent::__construct($ime, $jmbg);
            $this->brojKartona = $brojKartona;
        }
    }

    abstract class Pregled {
        public $tipPregleda;
        public $vreme;
        public $nalazi = [];

        public function __construct($tipPregleda, $vreme) {
            $this->tipPregleda = $tipPregleda;
            $this->vreme = $vreme;
        }
    }

    class PregledKrvi extends Pregled {
        public $eritrociti;
        public $leukociti;
        public $trombociti;
        public $hemoglobin;

        public function __construct($tipPregleda, $vreme) {
            parent::__construct($tipPregleda, $vreme);
            $this->eritrociti = rand(3.7, 5.8);
            $this->leukociti = rand(4.1, 10.9);
            $this->trombociti = rand(150, 400);
            $this->hemoglobin = rand(115, 170);
        }
    }

    class PregledPritiska extends Pregled {
        public $gornjaVrednost;
        public $donjaVrednost;

        public function __construct($tipPregleda, $vreme) {
            parent::__construct($tipPregleda, $vreme);
            $this->gornjaVrednost = rand(80, 180);
            $this->donjaVrednost = rand(50, 110);
        }
    }

    class PregledHolesterola extends Pregled {
        public $vrednost;

        public function __construct($tipPregleda, $vreme) {
            parent::__construct($tipPregleda, $vreme);
            $this->vrednost = rand(2, 8);
        }
    }

    class Karton {}

    class Nalaz {}

    class Recept {}

    class Loger {}

    $bolnica = new Bolnica('Bolnica Sv. Spasa', 'Vrbas');
    var_dump($bolnica);
?>