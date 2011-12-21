<?php
namespace Divona\StandingsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Divona\StandingsBundle\Entity\Game;
use Divona\StandingsBundle\Form\GameType;

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

    public function addGameAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        $game = new Game();
        $game->setPlayer1($user);
        $game->setScorePlayer1(0);
        $game->setScorePlayer2(0);
        $form = $this->createForm(new GameType(), $game);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $this->get('session')->setFlash('divona-notice', 'Your game was successfully created. Thank you!');

                $em = $this->getDoctrine()
                       ->getEntityManager();
                $em->persist($game);
                $em->flush();

                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('DivonaStandingsBundle_standings_show'));
            }
        }

        return $this->render('DivonaStandingsBundle:Standings:add_game.html.twig', array(
            'form' => $form->createView()
        ));
    }

}