<?php

namespace Divona\UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

/**
 * Controller managing the user profile
 */
class ProfileController extends BaseController
{
    /**
     * Show the user
     */
    public function showAction($id = null)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        if (is_null($id)) {
            $user = $this->container->get('security.context')->getToken()->getUser();
        }
        else {
            $user = $userManager->findUserBy(array('id' => $id));
        }

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Profile:show.html.twig', array('user' => $user));
    }
}
