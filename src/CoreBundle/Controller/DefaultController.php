<?php

namespace CoreBundle\Controller;

use CoreBundle\Services\TraitementFacebook;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $traitementFacebook = new TraitementFacebook();

        // id de la page L'ilot Régal
        $idLilotRegal = 'lilotregal';
        // id de la page Régal du circuit
        $idRegalCircuit = '649823778452363';

        $listMeal= array(
            'poulet à la crème',
            'rougaille saucisse'
        );
        $nbrMenuMax = 3;

        $listMenuLilotRegal = $traitementFacebook->returnListMenu($idLilotRegal, $nbrMenuMax, $listMeal);
        $listMenuRegalCircuit = $traitementFacebook->returnListMenu($idRegalCircuit, $nbrMenuMax, $listMeal);


        return $this->render('CoreBundle:Default:index.html.twig', array(
            "listMenuLilotRegal" => $listMenuLilotRegal,
            "listMenuRegalCircuit" => $listMenuRegalCircuit
        ));
    }



}
