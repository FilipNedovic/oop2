<?php 

    class Bolnica {
        public $ime;
        public $adresa;
        public $odeljenja = [];
        public $doktori = [];

        public function __construct($ime, $adresa) {
            $this->ime = $ime;
            $this->adresa = $adresa;
            $this->dodajOdeljenja($this->odeljenja);
        }

        public function dodajOdeljenja() {
            
        }

        public function dodajDoktora(Doktor $doktor) {
            $this->doktori[] = $doktor;
        }
    }

    class Odeljenje {
        public static $brojac = 1;
        public $brojOdeljenja;
        private $imenaOdeljenja = ['Hirurgija', 'Intenzivna nega', 'Laboratorija', 'Kardiologija'];

        public $imeOdeljenja;

        public function __construct() {
            $this->brojOdeljenja = self::$brojac++;
            $this->imeOdeljenja = $this->imenaOdeljenja[self::$brojac - 2];
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

        public function __construct($ime, $jmbg) {
            parent::__construct($ime, $jmbg);
        }
    }

    abstract class Pregled {
        public $tipPregleda;
        public $vreme;
        public $nalazi = [];
        public $pacijent;
        public $doktor;

        public function __construct(Doktor $doktor, Pacijent $pacijent, $tipPregleda, $vreme) {
            $this->tipPregleda = $tipPregleda;
            $this->vreme = $vreme;
            $this->pacijent = $pacijent;
            $this->doktor = $doktor;
        }

        public abstract function uradiNalaze() : Nalaz;
    }

    class PregledKrvi extends Pregled {
        public $eritrociti;
        public $leukociti;
        public $trombociti;
        public $hemoglobin;

        public $nalazi = [];

        public function __construct(Doktor $doktor, Pacijent $pacijent, $tipPregleda, $vreme) {
            parent::__construct($doktor, $pacijent, $tipPregleda, $vreme);
            $this->eritrociti = rand(3.7, 5.8);
            $this->leukociti = rand(4.1, 10.9);
            $this->trombociti = rand(150, 400);
            $this->hemoglobin = rand(115, 170);
        }

        public function uradiNalaze(): Nalaz {
            foreach($this as $key => $value) {
                array_push($this->nalazi, $key, $value);
            }
            array_splice($this->nalazi, 4);

            $nalaz = new Nalaz();
            $nalaz->rezultati[] = $this->nalazi;

            return $nalaz;
        }
    }

    class PregledPritiska extends Pregled {
        public $gornjaVrednost;
        public $donjaVrednost;

        public function __construct(Doktor $doktor, Pacijent $pacijent, $tipPregleda, $vreme) {
            parent::__construct($doktor, $pacijent, $tipPregleda, $vreme);
            $this->gornjaVrednost = rand(80, 180);
            $this->donjaVrednost = rand(50, 110);
        }

        public function uradiNalaze(): Nalaz {
            foreach($this as $key => $value) {
                array_push($this->nalazi, $key, $value);
            }
            array_splice($this->nalazi, 4);

            $nalaz = new Nalaz();
            $nalaz->rezultati[] = $this->nalazi;

            return $nalaz;
        }

    }

    class PregledHolesterola extends Pregled {
        public $vrednost;

        public $nalazi = [];


        public function __construct(Doktor $doktor, Pacijent $pacijent, $tipPregleda, $vreme ) {
            parent::__construct($doktor, $pacijent, $tipPregleda, $vreme);
            $this->vrednost = rand(2, 8);
        }

        public function uradiNalaze(): Nalaz {
            foreach($this as $key => $value) {
                array_push($this->nalazi, $key, $value);
            }
            array_splice($this->nalazi, 2);

            $nalaz = new Nalaz();
            $nalaz->rezultati = $this->nalazi;

            return $nalaz;
        }
    }

    class Karton {}

    class Nalaz {
        public $rezultati;

        public function __constructor($rezultati) {
            $this->rezultati = $rezultati;
        }
    }

    class Recept {}

    class Loger {}

    $doktor = new Doktor('Dr Peric', '0923382776611', 'pedijatar');
    $pacijent = new Pacijent('Mile', '9928477401829');

    $pregled1 = new PregledKrvi($doktor, $pacijent, 'analiza krvne slike', 'sad');
    $pregled2 = new PregledPritiska($doktor, $pacijent, 'analiza krvne slike', 'sad');
    $pregled3 = new PregledHolesterola($doktor, $pacijent, 'analiza krvne slike', 'sad');

    $pregled3->uradiNalaze();

    // $bolnica = new Bolnica('Bolnica Sv. Spasa', 'Vrbas');
    // var_dump($bolnica);

    // $djina = new Pacijent('Miro', '9283748100288');
    // $pregledPritiska = new PregledPritiska('pregled pritiska', 'sutra',);
    // var_dump($pregledPritiska);
?>

