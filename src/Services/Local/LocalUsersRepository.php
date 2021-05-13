<?php

namespace Osana\Challenge\Services\Local;

use MyCLabs\Enum\Enum;
use Osana\Challenge\Domain\Users\Company;
use Osana\Challenge\Domain\Users\Id;
use Osana\Challenge\Domain\Users\Location;
use Osana\Challenge\Domain\Users\Login;
use Osana\Challenge\Domain\Users\Name;
use Osana\Challenge\Domain\Users\Profile;
use Osana\Challenge\Domain\Users\Type;
use Osana\Challenge\Domain\Users\User;
use Osana\Challenge\Domain\Users\UsersRepository;
use Tightenco\Collect\Support\Collection;

class LocalUsersRepository implements UsersRepository
{

    private function searchProfile($prof){
        $p = null;
        $profiles = array_map('str_getcsv', file('../data/profiles.csv'));

        for ($i=0; $i < count($profiles); $i++) { 
            if($profiles[$i][0] == $prof){
                $prof = new Profile( new Name($profiles[$i][3]), new Company($profiles[$i][1]), new Location($profiles[$i][2]));
                return $prof;
            }
        }

        return $p;
    }

    private function searchUser($user){
        $u = null;
        $users = array_map('str_getcsv', file('../data/users.csv'));

        for ($i=0; $i < count($users); $i++) { 
            if($users[$i][1] == $user){
                $prof = $this->searchProfile($users[$i][0]);
                $u = new User( new Id($users[$i][0]), new Login($users[$i][1]), Type::Local(),$prof);
           
                return $u;                
            }
        }

        return $u;
    }


    public function findByLogin(Login $login, int $limit = 0): Collection
    {

        $uers = array_map('str_getcsv', file('../data/users.csv'));
        // $profiles = array_map('str_getcsv', file('../data/profiles.csv'));
        // print_r($profiles[2]);
        // dd();
        // $id = 'CSV1';

        // $tipo = new Type(Type::LOCAL)
        // dd($tipo);
        // dd(Type::LOCAL);
        // dd(Type::Local());
// 
        // $prof = new Profile( $profiles[2][0],$profiles[2][1],$profiles[2][3]);
        // $prof = new Profile( new Name("tptp"), new Company("asd"), new Location("arg"));
        // $prof = $this->searchProfile('CSV1');
        // $u = new User($uers[2][0],$uers[2][1],$uers[2][2],$prof);
        // $u = new User( new Id("juan"), new Login("juan"), new Type("local"),$prof);
        // dd($u);
        
        // dd($login->getValue());

        // echo "buscar: ".$login->getValue();
        // echo "<hr>";

        // dd($prof);
        
        // dd(count($uers));

        $encontrados = [];
        for ($i=0; $i < count($uers); $i++) { 
            // echo "buscando en: ".$uers[$i][1];
            // echo "<br>";
            // if($uers[$i][1] == 'etipsum'){
            if($uers[$i][1] == $login->getValue()){
                
                $prof = $this->searchProfile($uers[$i][0]);
                // dd("encontro");
                // $u = new User( new Id("juan"), new Login("juan"), new Type("local"),$prof);
                // $u = new User( new Id($uers[$i][0]), new Login($uers[$i][1]), new Type($uers[$i][2]),$prof);
                $u = new User( new Id($uers[$i][0]), new Login($uers[$i][1]), Type::Local(),$prof);
                // $prof = new Profile( new Name("tptp"), new Company("asd"), new Location("arg"));
                // dd("encontro");
                // $encontrados[] = $uers[$i];
                $encontrados[] = $u;
                // $encontrados[] = new User($uers[$i][0],$uers[$i][1],$uers[$i][2],$uers[$i][0]);
            }
        }

        // dd($encontrados);
        // dd($csv);

        // TODO: implement me
        $col = new Collection($encontrados);
        return $col;
    }

    public function getByLogin(Login $login, int $limit = 0): User
    {
        // TODO: implement me       
        return $this->searchUser($login->getValue());
    }

    public function add(User $user): void
    {
        // TODO: implement me
    }
}
