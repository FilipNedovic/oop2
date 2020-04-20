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
            $imenaOdeljenja = ['Hirurgija', 'Intenzivna nega', 'Laboratorija', 'Kardiologija'];

            foreach($imenaOdeljenja as $value) {
                    $odeljenje = new Odeljenje();
                    $odeljenje->imeOdeljenja = $value;

                    $this->odeljenja[] = $odeljenje;
                }
        }

        public function dodajDoktora(Doktor $doktor) {
            $this->doktori[] = $doktor;
        }
    }

    class Odeljenje {
        public static $brojac = 1;

        public $imeOdeljenja;
        public $brojOdeljenja;

        public function __construct() {
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
        public static $brojac = 1;
        public $brojKartona = 1;

        public function __construct($ime, $jmbg) {
            parent::__construct($ime, $jmbg);
            $this->brojKartona = self::$brojac++;
        }
    }

    abstract class Pregled {
        public $doktor;
        public $pacijent;
        public $tipPregleda;
        public $vreme;

        public $nalazi = [];

        public function __construct(Doktor $doktor, Pacijent $pacijent, $tipPregleda) {
            $this->doktor = $doktor;
            $this->pacijent = $pacijent;
            $this->tipPregleda = $tipPregleda;
            $this->setVreme();
        }

        public abstract function uradiNalaze(): Nalaz;

        public function formater($num) {
            array_splice($this->nalazi, $num);

            $keys = [];
            $values = [];
            $i = 0;

            foreach($this->nalazi as $key => $value) {
                if($i % 2 === 0) {
                    $keys[$key] =  $value;
                } else {
                    $values[$key] = $value;
                }

                $i++;
            }
            $this->nalazi = array_combine($keys, $values);
        }

        public function setVreme() {
            $vreme = date('Y-m-d h:i:sa');

            return $this->vreme = $vreme;
        }
    }

    class PregledKrvi extends Pregled {
        public $eritrociti;
        public $leukociti;
        public $trombociti;
        public $hemoglobin;

        public function __construct(Doktor $doktor, Pacijent $pacijent, $tipPregleda) {
            parent::__construct($doktor, $pacijent, $tipPregleda, $this->setVreme());
        }

        public function uradiNalaze(): Nalaz {
            $this->eritrociti = rand(3.7, 5.8);
            $this->leukociti = rand(4.1, 10.9);
            $this->trombociti = rand(150, 400);
            $this->hemoglobin = rand(115, 170);

            foreach($this as $key => $value) {
                array_push($this->nalazi, $key, $value);
            }
            // formatiraj nalaze
            $this->formater(8);

            // kreiranje novog objekta
            $nalaz = new Nalaz();
            $nalaz->rezultati[] = $this->nalazi;

            return $nalaz;
        }

    }

    class PregledPritiska extends Pregled {
        public $gornjaVrednost;
        public $donjaVrednost;

        public function __construct(Doktor $doktor, Pacijent $pacijent, $tipPregleda) {
            parent::__construct($doktor, $pacijent, $tipPregleda, $this->setVreme());
        }

        public function uradiNalaze(): Nalaz {
            $this->gornjaVrednost = rand(80, 180);
            $this->donjaVrednost = rand(50, 110);

            foreach($this as $key => $value) {
                array_push($this->nalazi, $key, $value);
            }

            $this->formater(4);

            $nalaz = new Nalaz();
            $nalaz->rezultati[] = $this->nalazi;

            return $nalaz;
        }

    }

    class PregledHolesterola extends Pregled {
        public $vrednost;

        public function __construct(Doktor $doktor, Pacijent $pacijent, $tipPregleda) {
            parent::__construct($doktor, $pacijent, $tipPregleda);
            $this->vrednost = rand(2, 8);
            $this->vreme = $this->setVreme();
        }

        public function uradiNalaze(): Nalaz {
            foreach($this as $key => $value) {
                array_push($this->nalazi, $key, $value);
            }

            $this->formater(2);

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

    class Recept {
        public $doktor;
    }

    class Loger {}


    $bolnica = new Bolnica('Bolnica Sv. Spasa', 'Vrbas');

    $doktor = new Doktor('Dr Peric', '0923382776611', 'pedijatar');
    $bolnica->dodajDoktora($doktor);

    $pacijent1 = new Pacijent('Mile', '9928477401829');
    $pacijent2 = new Pacijent('Grile', '9328710404529');

    $pregled1 = new PregledKrvi($doktor, $pacijent1, 'analiza krvne slike');
    $pregled2 = new PregledPritiska($doktor, $pacijent1, 'merenje pritiska');
    $pregled3 = new PregledHolesterola($doktor, $pacijent1, 'merenje nivoa holesterola');

    $pregled3->uradiNalaze();

    var_dump($pregled3);

    


?>

