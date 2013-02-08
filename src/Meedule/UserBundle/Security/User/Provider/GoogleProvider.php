<?php

namespace Meedule\UserBundle\Security\User\Provider;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GoogleProvider implements UserProviderInterface
{
    /**
     * @var \GoogleApi
     */
    protected $googleApi;
    protected $userManager;
    protected $validator;
    protected $em;
    protected $container;

    public function __construct($googleApi, $userManager, $validator, $em, $container)
    {
        $this->googleApi = $googleApi;
        $this->userManager = $userManager;
        $this->validator = $validator;
        $this->em = $em;
        $this->container = $container;
    }

    public function supportsClass($class)
    {
        return $this->userManager->supportsClass($class);
    }

    public function loadUserByUsername($username)
    {
        try {
            $gData = $this->googleApi->getOAuth()->userinfo->get();
        } catch (\Exception $e) {
            $gData = null;
        }

        $user = $this->userManager->findUserBy(array('googleID' => $gData['id']));
        if (empty($user)) {
            $user = $this->userManager->findUserByUsername($username);
            if (empty($user)) {
                $user = $this->userManager->findUserByEmail($gData['email']);
            }
        }

        if (!empty($gData)) {
            if (empty($user)) {
                $user = $this->userManager->createUser();
                $user->setEnabled(true);
                $user->setPassword('');
            }

            $user->setGData($gData);
            
            if (count($this->validator->validate($user, 'Google'))) {
                // TODO: the user was found obviously, but doesnt match our expectations, do something smart
                throw new UsernameNotFoundException('The google user could not be stored');
            }
            $this->userManager->updateUser($user);
        }

        if (empty($user)) {
            throw new UsernameNotFoundException('The user is not authenticated on google');
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user)) || !$user->getGoogleId()) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getGoogleId());
    }

}