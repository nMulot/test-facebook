<?php
// src/CoreBundle/Services/TraitementFacebook.php

namespace CoreBundle\Services;

// inclusion du SDK Facebook
use CoreBundle\Entity\Menu;

require_once('lib/facebook.php');

class TraitementFacebook {

    private $config;
    private $facebook;

    public function __construct(){
        $this->config = array();
        $this->config['appId'] = '236864903319386';
        $this->config['secret'] = 'd5a4b11e5a5f1de3bca211e3408f2196';
        $this->config['fileUpload'] = false; // optional

        $this->facebook = new \Facebook($this->config);
    }

    public function returnListMenu($idFacebook, $nbrMsg, $listMeal){
        // récupération des dernier posts de la page
        $page = $this->facebook->api('/' . $idFacebook . '/feed');

        //Enregitrement du contenu des posts dans une liste
        $listMenu = array();
        $i = 0;
        $j = 0;
        while ( $i < $nbrMsg && $i < count($page['data']) ) {
            if ( isset( $page['data'][$j]['message'] ) ) {
                $menu = $this->returnInfo( $page['data'][$j]['message'], $listMeal );
                if ( $menu != null ) {
                    array_push($listMenu, $menu);
                    $i++;
                }
            }
            $j++;
        }
        return $listMenu;
    }

    //Retourne toute les info
    public function returnInfo($msg, $listMeal){
        $menu = new Menu();
        $date = null;
        $listMonth = array(
            '1' => 'janvier',
            '2' => 'février',
            '3' => 'mars',
            '4' => 'avril',
            '5' => 'mai',
            '6' => 'juin',
            '7' => 'juillet',
            '8' => 'août',
            '9' => 'septembre',
            '10' => 'octobre',
            '11' => 'novembre',
            '12' => 'décembre'
        );

        $delimiter = "\n";
        //décomposition du message par ligne
        $listLignes = explode($delimiter,$msg);

        // si la premier ligne n'est pas absente je vérifie si elle contient une date
        if( !empty($listLignes[0]) ) {
            $chaine = strtolower( $listLignes[0] );
            $delimiter = " ";
            $listWords = explode($delimiter, $chaine);

            $yearNow = date('Y');
            $monthNow = date('m');

            foreach ($listWords as $keyWord => $word ) {
                foreach ( $listMonth as $keyMonth => $month ) {
                    //je vérifi si le mot correspond a un mois de l'année
                    if ( $word == $month ) {
                        $year = $yearNow;
                        // Si il y a un menu pour le mois de janvier et que l'on est encore en décembre il faut incrémenter l'année
                        if( (int)$keyMonth == 1 && (int)$monthNow == 12){
                            $year++;
                        }
                        // Si il y a un menu pour le mois de décembre et que l'on est encore en janvier il faut décrémenter l'année
                        if( (int)$keyMonth == 12 && (int)$monthNow == 1){
                            $year--;
                        }

                        $date = new \DateTime( date('Y-m-d', strtotime( $year . '-' . $keyMonth . '-' . $listWords[$keyWord-1] )) );
                    }
                }
            }

            //si la date existe c'est que l'article est un menu
            if ( !empty($date) && $date != false ) {
                $menu->setContent( str_replace("\n", "<br>", $msg) );
                $menu->setDate($date);
                $today = new \DateTime(date('Y-m-d'));
                $diffDate = $today->diff($date);
                if( $diffDate->days == 0 ) {
                    $menu->setForToday(true);
                } else {
                    $menu->setForToday(false);
                }

                $msgLower = strtolower($msg);
                foreach ( $listMeal as $meal ) {
                    $meal = strtolower($meal);
                    // si le repas est disponible
                    if (preg_match('#' . $meal . '#', $msgLower))
                    {
                        $menu->pushNotifyPlate($meal);
                    }
                }
                return $menu;
            }
        }
        return null;
    }

}