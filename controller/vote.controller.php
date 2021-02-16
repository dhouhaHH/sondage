<?php


namespace App\Controller;


use App\Entity\Vote;
use App\Repository\PlaceRepository;
use App\Repository\UserRepository;
use App\Repository\VoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class VoteController extends AbstractController
{
    
    private $manager;

  
    private $voteRepository;

    private $userRepository;

    private $placeRepository;

   
    public function __construct(EntityManagerInterface $manager, VoteRepository $voteRepository, UserRepository $userRepository, PlaceRepository $placeRepository)
    {
        $this->manager = $manager;
        $this->voteRepository = $voteRepository;
        $this->userRepository = $userRepository;
        $this->placeRepository = $placeRepository;
    }