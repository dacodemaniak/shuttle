<?php
namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class AuthTokenUserProvider implements UserProviderInterface
{

    private $authTokenRepository;
    private $userRepository;
    
    public function __construct(EntityRepository $authTokenRepository, EntityRepository $userRepository) {
        $this->authTokenRepository = $authTokenRepository;
        $this->userRepository = $userRepository;
    }
    
    public function getAuthToken($authTokenHeader) {
        return $this->authTokenRepository->findOneByValue($authTokenHeader);    
    }
    
    public function supportsClass(string $class) {
        return User::class;
    }

    public function refreshUser(UserInterface $user) {
        throw new UnsupportedUserException();
    }

    public function loadUserByUsername(string $email){
        return $this->userRepository->findByEmail($email);
    }

}

