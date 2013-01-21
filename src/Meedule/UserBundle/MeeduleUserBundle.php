<?php

namespace Meedule\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MeeduleUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
