<?php
namespace Divona\StandingsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StandingsController extends Controller
{
    public function showAction($display = 'month')
    {
        $em = $this->getDoctrine()->getEntityManager();

        $standing = $em->getRepository('DivonaStandingsBundle:Game')->getStanding($display);

        if (!$standing) {
            throw $this->createNotFoundException('Unable to generate this standing.');
        }

        return $this->render('DivonaStandingsBundle:Standings:month.html.twig', array(
            'standing' => $standing,
        ));
    }

}