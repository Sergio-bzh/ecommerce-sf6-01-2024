<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;

    public function __construct(private SluggerInterface $slugger)
    {
        //A partir de PHP 8 il n'y a plus besoin de mettre en place le $this->slugger = $slugger
        // et les getters & setters sont induits implicitement
    }

    public function load(ObjectManager $manager): void
    {

        $parent = $this->createCategory('Informatique', null, $manager);

        $this->createCategory('Ordinateurs', $parent, $manager);
        $this->createCategory('Ecrans', $parent, $manager);
        $this->createCategory('Souris', $parent, $manager);

        $parent = $this->createCategory('Mode', null, $manager);

        $this->createCategory('Homme', $parent, $manager);
        $this->createCategory('Femme', $parent, $manager);
        $this->createCategory('Enfant', $parent, $manager);

        $manager->flush();
    }

    public function createCategory(string $name, Categories $parent = null, ObjectManager $manager)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);

        // Création des références pour les catégories qui serviront pour le rattachement des produits
        $this->addReference('cat-'.$this->counter, $category);
        $this->counter++;

        return $category;
    }
}
