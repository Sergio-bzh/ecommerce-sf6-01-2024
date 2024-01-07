<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UsersFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private SluggerInterface $slugger
    ){}

    public function load(ObjectManager $manager): void
    {
        // Création d'un user avec le rôle admin :
        $admin = new Users();
        $admin->setEmail('admin@mail.com');
        $admin->setLastname('ad');
        $admin->setFirstname('min');
        $admin->setAddress('7 rue du Soleil d\'or');
        $admin->setZipcode('28000');
        $admin->setCity('Chartres');
        $admin->setPassword($this->passwordEncoder->hashPassword($admin, 'password'));
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        // Mise en place de la locale pour $faker
        $faker = Factory::create('fr_FR');
        // Boucle pour la création de chaque utilisateur
        for($usr = 1; $usr <= 10; $usr++){
            $user = new Users();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName);
            $user->setAddress($faker->streetAddress);
            $user->setZipcode(str_replace(' ', '', $faker->postcode)); // Avec str_replace on remplace les espaces par rien (chaîne vide)
            $user->setCity($faker->city);
            $user->setPassword($this->passwordEncoder->hashPassword($user, 'password'));
            // Pas de rôle car le rôle par défaut est ROLE_USER

            $manager->persist($user);
        }

        $manager->flush();
    }
}
