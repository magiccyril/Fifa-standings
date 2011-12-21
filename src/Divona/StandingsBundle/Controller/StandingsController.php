<?php
namespace Divona\StandingsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Divona\StandingsBundle\Entity\Game;
use Divona\StandingsBundle\Form\GameType;
use Divona\StandingsBundle\Helper\Paginator;

class StandingsController extends Controller
{
    public function showAction($granularity = false)
    {
        if (!$granularity)
        {
            return $this->redirect($this->generateUrl('DivonaStandingsBundle_standings_show_month'));
        }

        $em = $this->getDoctrine()->getEntityManager();
        $standing = $em->getRepository('DivonaStandingsBundle:Game')->getStanding($granularity);

        if (!$standing) {
            throw $this->createNotFoundException('Unable to generate this standing.');
        }

        return $this->render('DivonaStandingsBundle:Standings:standing.html.twig', array(
            'standing' => $standing,
        ));
    }

    public function listAction()
    {

        $em = $this->getDoctrine()->getEntityManager();

        $page = $this->getRequest()->get('page', 1);
        $count = $em->getRepository('DivonaStandingsBundle:Game')->getGamesCount();
        $paginator = new Paginator($count, $page, 10);

        $games = $em->getRepository('DivonaStandingsBundle:Game')->getGames(null, $paginator->getLimit(), $paginator->getOffset());

        if (!$games) {
            throw $this->createNotFoundException('Unable to get games.');
        }

        return $this->render('DivonaStandingsBundle:Standings:list.html.twig', array(
            'games' => $games,
            'paginator' => $paginator,
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $game = $em->getRepository('DivonaStandingsBundle:Game')->find($id);

        if (!$game) {
            throw $this->createNotFoundException('Unable to get the game.');
        }

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $em = $this->getDoctrine()
                       ->getEntityManager();
                $em->remove($game);
                $em->flush();

                return $this->redirect($this->generateUrl('DivonaStandingsBundle_standings_list'));
        }

        return $this->render('DivonaStandingsBundle:Standings:delete.html.twig', array(
            'game' => $game,
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