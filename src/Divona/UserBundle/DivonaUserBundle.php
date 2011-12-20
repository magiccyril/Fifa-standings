<?php

namespace Divona\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DivonaUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
