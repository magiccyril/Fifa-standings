<?php
namespace Divona\StandingsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StandingsController extends Controller
{
    public function showAction($display = false)
    {
        if (!$display)
        {
            return $this->redirect($this->generateUrl('DivonaStandingsBundle_standings_show_month'));
        }

        $em = $this->getDoctrine()->getEntityManager();
        $standing = $em->getRepository('DivonaStandingsBundle:Game')->getStanding($display);

        if (!$standing) {
            throw $this->createNotFoundException('Unable to generate this standing.');
        }

        return $this->render('DivonaStandingsBundle:Standings:standing.html.twig', array(
            'standing' => $standing,
        ));
    }

}