<?php
namespace Divona\StandingsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PartialController extends Controller
{
    public function latestGamesAction($limit = 10)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $games = $em->getRepository('DivonaStandingsBundle:Game')->getGames(null, $limit);

        return $this->render('DivonaStandingsBundle:Partial:latestGames.html.twig', array(
            'latestGames' => $games
        ));
    }

    public function standingAction($granularity = 'month')
    {
        $em = $this->getDoctrine()->getEntityManager();
        $standing = $em->getRepository('DivonaStandingsBundle:Game')->getStanding($granularity);

        if ($standing) {
            return $this->render('DivonaStandingsBundle:Partial:standing.html.twig', array(
                'granularity' => $granularity,
                'standing' => $standing,
            ));
        }
    }
}