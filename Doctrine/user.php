<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\User;
use App\Entity\Vote;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;

class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private $security;

    private $auth;

    public function __construct(Security $security, AuthorizationCheckerInterface $checker)
    {
        $this->security = $security;
        $this->auth = $checker;
    }

    private function addWhere(string $resourceClass, QueryBuilder $queryBuilder)
    {
        $user = $this->security->getUser();

        if (($resourceClass === Vote::class) && (!$this->auth->isGranted('ROLE_ADMIN')) && $user instanceof User) {
            $rootAlias = $queryBuilder->getRootAliases()[0];

            $queryBuilder->andWhere("$rootAlias.user = :user")
                ->setParameter('user', $user);
        }
    }

