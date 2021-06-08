<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $random_estado = array('baja','alta');
        $random_sexo = array('hombre','mujer');

        for ($i=0; $i < 100 ; $i++) { 

            $user = new User();
            $user->setNombre(sprintf('nombre_'.$i, $i));
            $user->setApellido(sprintf('apellido_'.$i, $i));
            $user->setNacimiento(new \DateTime(date('Y-m-d H:i:s')), $i);
            $user->setEstado($random_estado[array_rand($random_estado)], $i);
            $user->setSexo($random_sexo[array_rand($random_sexo)], $i);
            $manager->persist($user);

        }

        $manager->flush();
    }
}
