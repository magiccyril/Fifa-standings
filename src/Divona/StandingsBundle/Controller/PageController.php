<?php
namespace Divona\StandingsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('DivonaStandingsBundle:Page:index.html.twig');
    }
}