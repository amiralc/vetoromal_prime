<?php

namespace App\Security;

use App\Entity\User;

use HWI\Bundle\OAuthBundle\Connect\AccountConnectorInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\EntityUserProvider;
use Symfony\Component\Security\Core\User\UserInterface;

class MyEntityUserProvider extends EntityUserProvider implements AccountConnectorInterface {

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $resourceOwnerName = $response->getResourceOwner()->getName();

        if (!isset($this->properties[$resourceOwnerName])) {
            throw new \RuntimeException(sprintf("No property defined for entity for resource owner '%s'.", $resourceOwnerName));
        }

        $serviceName = $response->getResourceOwner()->getName();
        $setterId = 'set'. ucfirst($serviceName) . 'ID';
        $setterAccessToken = 'set'. ucfirst($serviceName) . 'AccessToken';

        // unique integer
        $username = $response->getUsername();
        $email = $response->getEmail();
        if (null === $membre = $this->findMembre([$this->properties[$resourceOwnerName] => $username])) {
            // TODO: Create new user
            if (null === $membre = $this->findMembre(['email' => $email])){
                $membre = new membre();
                $membre->setIsVerified(true);
                $membre->setEmail($response->getEmail());
                $membre->setPassword(md5(uniqid('', true)));
            }
            else{
                $membre->setIsVerified(true);
            }
            $membre->$setterId($username);
        }

        $membre->$setterAccessToken($response->getAccessToken());
        $this->em->persist($membre);
        $this->em->flush();
        return $membre;
    }

     //param UserInterface $membre The user object
     //param UserResponseInterface $response The oauth response

    public function connect(UserInterface $membre, UserResponseInterface $response)
    {
        if (!$membre instanceof membre) {
            throw new UnsupportedUserException(sprintf('Expected an instance of App\Model\User, but got "%s".', get_class($membre)));
        }

        $property = $this->getProperty($response);
        $username = $response->getUsername();

        if (null !== $previousUser = $this->registry->getRepository(User::class)->findOneBy(array($property => $username))) {
            // 'disconnect' previously connected users
            $this->disconnect($previousUser, $response);
        }


        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set'. ucfirst($serviceName) . 'AccessToken';

        $membre->$setter($response->getAccessToken());

        $this->updateUser($membre, $response);
    }

    /**
     * ##STOLEN#
     * Gets the property for the response.
     *
     * @param UserResponseInterface $response
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function getProperty(UserResponseInterface $response)
    {
        $resourceOwnerName = $response->getResourceOwner()->getName();

        if (!isset($this->properties[$resourceOwnerName])) {
            throw new \RuntimeException(sprintf("No property defined for entity for resource owner '%s'.", $resourceOwnerName));
        }

        return $this->properties[$resourceOwnerName];
    }

    /**
     * Disconnects a user.
     *
     * @param UserInterface $membre
     * @param UserResponseInterface $response
     * @throws \TypeError
     */
    public function disconnect(UserInterface $membre, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $accessor = PropertyAccess::createPropertyAccessor();

        $accessor->setValue($membre, $property, null);

        $this->updateUser($membre, $response);
    }

    /**
     * Update the user and persist the changes to the database.
     * @param UserInterface $membre
     * @param UserResponseInterface $response
     */
    private function updateUser(UserInterface $membre, UserResponseInterface $response)
    {
        $membre->setEmail($response->getEmail());
        // TODO: Add more fields?!

        $this->em->persist($membre);
        $this->em->flush();
    }

}