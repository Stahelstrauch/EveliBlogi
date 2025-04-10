<?php
class Db {
    private $con; // Ühendus salvestatakse siin

    function __construct()
    {
        $this->con = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if($this->con->connect_errno) {
            echo "<strong>Viga andmebaasiga:<strong>".$this->con->connect_errno;
        }else {
            mysqli_set_charset($this->con, "utf8");
        }
    }

    # UPDATE, INSERT või DELETE sql lausete jaoks
    function dbQuery($sql) {
        if($this->con) {
            $res = mysqli_query($this->con, $sql);
            if($res === false) { // Kolmekordne võrlemine, tüüp peab ka õige olema
                echo "<div>Vigane päring: " .htmlspecialchars($sql). "</div>";
                return false;
            }
            return $res; // Tagastab objekti
        }
        return false;
    }

    # SELECT sql lause jaoks
    function dbGetArray($sql) {
        $res = $this->dbQuery($sql);
        if($res !== false) {
            $data = array(); // Tühja massiivi loomine
            while($row = mysqli_fetch_assoc($res)) {
                $data[] = $row; // Lisa uude massiivi
            }
            return (!empty($data)) ? $data : false; // Kui $data pole tühi (!empty), siis tagasta data
        }
        return false;
    }

    # $_POST / $_GET väärtuse tagastamine - get saad kätte aadressi real oleva info, post - vormi andmed(nt kontakti sisestatud info)
    # ?string saab olla post, get või null (vaikimisi)
    function getVar(string $name, ?string $method = null) {
        if($method === 'post') {
            return $_POST[$name] ?? null;
        } elseif($method === 'get') {
            return $_GET[$name] ?? null;
        } else {
            return $_POST[$name] ?? $_GET[$name] ?? null;
        }

    }

    # Sisendi turvalisemaks muutmine
    function dbFix($var) { 
        if(!$this->con || !($this->con instanceof mysqli)) { // || tähendab or ja && tähendab ja
            return "NULL";
        }

        if(is_null($var)) {
            return "NULL";
        }elseif(is_bool($var)) {
            return $var ? '1' : '0'; // ? kui on tõene ja: kui on väär
        }elseif(is_numeric($var)) {
            return $var;
        }else {
            return $this->con->real_escape_string($var); // varjestab ära tekstis kahtlased märgid nagu ülakomad jne - neid ei või panna andmebaasi
        }
    }
    
    # inimlikul kujul massiivi sisu vaatamine
    function show($arrey) {
        echo "<pre>";
        print_r($arrey);
        echo "</pre>";
    }

    # Input texti jaoks kirjete küsimine andmebaasist
    /**
     * Tagastab valmis HTML value atribuudi, näiteks: value="Andres"
     * @param string $name - massiivi võti (vormi välja nimi) heading või context
     * @param array $source - Massiiv kust väärtus võtta
     * @return string - valmis value="..." või tühi string
    */
    function htmlValue(string $name, array $source): string {
        if(isset($source[$name])) {
            return 'value="' . htmlspecialchars($source[$name], ENT_QUOTES) . '"';
        }
        return '';
    }

    function htmlTextContent(string $name, array $source): string {
        return isset($source[$name]) ? htmlspecialchars($source[$name], ENT_QUOTES) : "";

    }



} // class Db lõpp