<?php

/*
 * objet de gestion de logs
 * Auteur : ARNO
 * date : 22/04/2013
 * version : 1.0
 * 
 */

class arnoLogger {
    
    private $file_name ;

    private $dir_name ;
    
    private $log_level ;
    
    private $log_fd ;
    
    function arnoLogger($logName,$dirName) {
        
        $this->file_name = $logName.".log" ;
        
        if (is_dir ( $dirName )) {
            $this->dir_name = $dirName ;
        } else {
            echo ">>ERREUR : le Répertoire ".$dirName." n existe pas !!!\n";
        }
        
        $fullFileName = $dirName.$logName.".log";
        if (is_file($fullFileName) && !is_writeable($fullFileName)) {
            echo ">>ERREUR : le Fichier ".$fullFileName." existe déjà ou n est pas accessible en ecriture!!!\n";        
        } else {
            // Ouverture du fichier
            $this->log_fd = fopen($fullFileName, "w") ;
            if (!$this->log_fd) {
                echo ">>ERREUR : Ouverture du fichier ".$fullFileName." en écriture !!!\n";
            } else {
                //
                // initialisation de l'entete du fichier
                //
                $this->initHeader();
            }
            
        } 
    }
    
    function get_log_dir() {
        return $this->dir_name;
    }
    
    function write_line($texte) {
        fwrite($this->log_fd,date("d/m/Y H:i:s")." - ".$texte."\n") ;
    }
    
    function write_array($texte,$array_towrite) {
        $this->write_line("----------- TABLEAU : ".$texte);
        ob_start();
        var_dump($array_towrite);
        $data = ob_get_clean();
        fwrite($this->log_fd, $data);
        $this->write_line("----------- FIN TABLEAU : ".$texte);
    }

    function closeLog ($text = "") {
        $this->initFooter($text);
        fclose($this->log_fd);
    }
    
    private function initHeader () {
        fwrite($this->log_fd,"*****************************************************\n") ;
        fwrite($this->log_fd," Fichier : ".$this->file_name."\n") ;
        fwrite($this->log_fd," Date    : ".date("d/m/Y H:i:s")."\n") ;
        fwrite($this->log_fd,"*****************************************************\n") ;
    }

    private function initFooter ($text = "") {
        fwrite($this->log_fd,"*****************************************************\n") ;
        fwrite($this->log_fd," Fin du Fichier \n") ;
        fwrite($this->log_fd," Date    : ".date("d/m/Y H:i:s")."\n") ;
        if ($text != "")
        fwrite($this->log_fd," ".$text."\n") ;
        fwrite($this->log_fd,"*****************************************************\n") ;
    }
    
}
?>
