<?php
namespace Divona\StandingsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Divona\StandingsBundle\Entity\Enquiry;
use Divona\StandingsBundle\Form\EnquiryType;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('DivonaStandingsBundle:Page:index.html.twig');
    }

    public function contactAction()
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject($enquiry->getSubject())
                    ->setFrom($enquiry->getEmail())
                    ->setTo($this->container->getParameter('divona_standings.emails.contact_email'))
                    ->setBody($this->renderView('DivonaStandingsBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
                $this->get('mailer')->send($message);

                $this->get('session')->setFlash('divona-notice', 'Your contact enquiry was successfully sent. Thank you!');
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('DivonaStandingsBundle_contact'));
            }
        }

        return $this->render('DivonaStandingsBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

}