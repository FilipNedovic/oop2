<?php 

    class Bolnica {}

    class Odeljenje {}
    
    abstract class Osoba {}

    class Doktor extends Osoba {}

    class Pacijent extends Osoba {}

    abstract class Pregled {}

    class PregledKrvi extends Pregled {}

    class PregledPluca extends Pregled {}

    class PregledSrca extends Pregled {}

    class Nalaz {}

    class Recept {}

    class Loger {}
?>