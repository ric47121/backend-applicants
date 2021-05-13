<?php

namespace Osana\Challenge\Http\Controllers;

use Osana\Challenge\Domain\Users\Login;
use Osana\Challenge\Domain\Users\Type;
use Osana\Challenge\Services\Local\LocalUsersRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ShowUserController
{
    /** @var LocalUsersRepository */
    private $localUsersRepository;

    public function __construct(LocalUsersRepository $localUsersRepository)
    {
        $this->localUsersRepository = $localUsersRepository;
    }

    public function __invoke(Request $request, Response $response, array $params): Response
    {
        $type = new Type($params['type']);
        $login = new Login($params['login']);

        // TODO: implement me
        $localUser = $this->localUsersRepository->getByLogin($login);
        // $localUser = $this->localUsersRepository->findByLogin($login);

        $all = [];
        $all[] = [
            'id' => $localUser->getId()->getValue(),
            'login' => $localUser->getLogin()->getValue(),
            'type' => $localUser->getType()->getValue(),
            'profile' => [
                'name' => $localUser->getProfile()->getName()->getValue(),
                'company' => $localUser->getProfile()->getCompany()->getValue(),
                'location' => $localUser->getProfile()->getLocation()->getValue(),
            ]
        ];       

        $response->getBody()->write( json_encode($all));

        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200, 'OK');
        
        return $response;
    }
}
