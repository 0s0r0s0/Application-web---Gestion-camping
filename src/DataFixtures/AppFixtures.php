<?php

namespace App\DataFixtures;

use App\Entity\Biens;
use App\Entity\Pictures;
use App\Entity\Roles;
use App\Entity\Saisons;
use App\Entity\Tarifications;
use App\Entity\Templates;
use App\Entity\Users;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $this->loadRoles($manager);
        $this->loadUsers($manager);
        $this->loadTemplates($manager);
        $this->loadBiens($manager);
        $this->loadPictures($manager);
        $this->loadSaisons($manager);
        $this->loadTarifications($manager);

    }

    public function loadRoles(ObjectManager $manager)
    {

        $roles_names = ['ROLE_ADMIN', 'ROLE_USER'];
        foreach ($roles_names as $kn => $name){
            $roles = new Roles();
            $roles->setLabel($name);
            $this->setReference('roles-'.$kn, $roles);
            $manager->persist($roles);
        }
        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager)
    {
        $users = new Users();
        $users->setEmail('a@a.a')
            ->setPassword($this->encoder->encodePassword($users, 'admin'))
            ->setNom('Trump')
            ->setPrenom('Didi')
            ->setAdresse('66, Avenue du Soleil')
            ->setCity('Port-Vendres')
            ->setTelephone('0666066606');
        $users->setRole($this->getReference('roles-0'));
        $manager->persist($users);

        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++){
            $users = new Users();
            $users->setEmail($faker->email)
                ->setPassword($this->encoder->encodePassword($users, '12345'))
                ->setNom($faker->lastName)
                ->setPrenom($faker->firstName)
                ->setAdresse($faker->address)
                ->setCity($faker->city)
                ->setTelephone($faker->mobileNumber)
                ->setRole($this->getReference('roles-1'))
            ;
            $this->setReference('user-'.$i, $users);
            $manager->persist($users);
        }

        $manager->flush();

    }


    public function loadBiens(ObjectManager $manager)
    {
        for($i = 0; $i < 50 ; $i++) {
            $biens = new Biens();
            $biens->setUser( $this->getReference(
                'user-' . \rand(0, 49)
            ))
                ->setTemplate( $this->getReference('template-' . \rand(0, 3)) )
            ;
            $this->setReference( 'bien-' . $i, $biens );
            $manager->persist( $biens );
        }
        $manager->flush();
        return $this;
    }


    public function loadPictures(ObjectManager $manager)
    {
        for($i = 0; $i < 9; $i++) {
            $picture = new Pictures();

            $picture->setTemplate( $this->getReference('template-' . $i) )
                ->setFilename('main_picture.png')
                ->setPrincipale('main_picture.png')
            ;

            $manager->persist($picture);
        }
        $manager->flush();
        return $this;
    }


    public function loadSaisons(ObjectManager $manager)
    {

        $sais_nom = [
            ['basse', new \DateTime('2020/05/05'), new \DateTime('2020/10/10')],
            ['haute', new \DateTime('2020/06/21'), new \DateTime('2020/08/31')]
        ];
        foreach ($sais_nom as $kn => $season)
        {
            $saisons = new Saisons();
            $saisons->setType($season[0])
            ->setDateStart($season[1])
            ->setDateEnd($season[2]);

            $manager->persist($saisons);
        }
        $manager->flush();
    }

    public function loadTarifications(ObjectManager $manager)
    {
        $taro = [
            ['piscine_adulte', 1.5, '€'],
            ['piscine_enfant', 1, '€'],
            ['sejour_adulte', 0.65, '€'],
            ['sejour_enfant', 0.35, '€']
        ];
        foreach ($taro as $kn => $tarif)
        {
            $rifta = new Tarifications();
            $rifta->setCode($tarif[0])
                ->setValue($tarif[1])
                ->setType($tarif[2]);
            $manager->persist($rifta);
        }
        $manager->flush();

    }

    public function loadTemplates (ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        $templates = [
            [3, 15, 20,'mobile-home 3 places ', 'mobile-home'],
            [4, 15, 24,'mobile-home 4 places ', 'mobile-home'],
            [5, 10, 27,'mobile-home 5 places ', 'mobile-home'],
            [8, 10, 34,'mobile-home 6-8 places ', 'mobile-home'],
            [2, 3, 15, 'caravane 2 places ', 'caravane'],
            [4, 3, 18, 'caravane 4 places ', 'caravane'],
            [6, 4, 24, 'caravane 6 places ', 'caravane'],
            [8, 15, 12, 'emplacement 8 m² ', 'emplacement'],
            [12, 15, 14, 'emplacement 12 m² ', 'emplacement']
        ];
        $u = 1;
        for ($i = 0; $i < count($templates); $i++){
            $couchages = $templates[$i][0];
            $nombre = $templates[$i][1];
            $prix = $templates[$i][2];
            $titre = $templates[$i][3];
            $label = $templates[$i][4];

            for($a = 0; $a < $nombre; $a++) {
                $template = new Templates();
                $template->setLabel($label)
                    ->setPrix($prix)
                    ->setTitre($titre)
                    ->setDescription($faker->text)
                    ->setCouchage($couchages);
                $this->setReference('template-' .$i, $template);
                $u++;
                $manager->persist($template);

            }

        }
        $manager->flush();
    }


}
