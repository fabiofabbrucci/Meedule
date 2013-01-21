<?php

namespace Meedule\UserBundle\Model;

use FOS\UserBundle\Entity\UserManager as BaseUserManager;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * Concrete User Manager implementation 
 *
 */
class UserManager extends BaseUserManager
{
    /**
     * Loads a user by username
     *
     * Overrided method for logon only by email
     * 
     * @param string $email
     * 
     * @return UserInterface
     * 
     */
    public function loadUserByUsername($email)
    {
        $user = $this->findUserByUsernameOrEmail($email);

        if (!$user) {
            throw new UsernameNotFoundException(sprintf('No user with email "%s" was found.', $email));
        }

        return $user;
    }

    /**
     * Updates a user.
     *
     * @param UserInterface $user     UserInterface
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     */
    public function updateUser(UserInterface $user, $andFlush = true)
    {
        parent::updateUser($user, $andFlush);
        $this->em->refresh($user);
    }
}