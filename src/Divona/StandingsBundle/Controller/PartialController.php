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

    public function listUserGamesAction($user_id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $games = $em->getRepository('DivonaStandingsBundle:Game')->getGamesOfUser($user_id);

        $player = $this->container->get('fos_user.user_manager')->findUserBy(array('id' => $user_id));

        return $this->render('DivonaStandingsBundle:Partial:userGames.html.twig', array(
            'games' => $games,
            'player' => $player,
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

    public function bestPlayerAction($granularity = null)
    {
        if (($granularity != 'day'
            && $granularity != 'week'
            && $granularity != 'month'
            && $granularity != 'year'
            && $granularity != 'all')
            || is_null($granularity)) {
                $granularity = 'month';
            }

        $em = $this->getDoctrine()->getEntityManager();
        $best = $em->getRepository('DivonaStandingsBundle:Game')->getBestPlayer($granularity);
        $player = $best['player'];

        return $this->render('DivonaStandingsBundle:Partial:bestPlayer.html.twig', array(
            'granularity' => $granularity,
            'player' => $player,
        ));
    }
}