<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Question;
use App\Entity\User;


class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 3; $i++) {
            $question = new Question();
            $question->setTitles('Why do we use Symfony 6 ?', $i);
            $question->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce lacinia nisi 
            sapien, a tristique tortor mollis sit amet. Nulla id nulla orci. Curabitur neque lorem, 
            condimentum ac tincidunt eget, sagittis ut enim. Sed sit amet elementum felis, at cursus mauris. 
            Curabitur tincidunt lorem sit amet leo efficitur tincidunt. Sed dictum elit turpis, rutrum accumsan 
            leo vehicula at. Curabitur sodales libero at congue lobortis. Nullam feugiat tellus id ante accumsan,
            sed vestibulum neque fermentum. Donec ut aliquet lacus. Proin ultricies porta enim. Vestibulum rutrum, urnanec 
            dapibus semper, sem purus aliquam felis, eget pretium ligula sapien nec nisi. Fusce volutpat lorem in 
            rutrum pulvinar. Pellentesque quis leo ut orci suscipit sodales a non nisi. Vestibulum blandit, 
            dolor vel dictum lacinia, erat arcu semper ante, non scelerisque justo risus rhoncus risus. ');
            $manager->persist($question);
        }
        $question2 = new Question();
        $question2->setTitles('What is better console Xbox or Ps5 ?', $i);
        $question2->setContent('Lorem èipsum dolor sit amet, consectetur adipiscing elit. Fusce lacinia nisi 
            sapien, a tristique tortor mollis sit amet. Nulla id nulla orci. Curabitur neque lorem, 
            condimentum ac tincidunt eget, sagittis ut enim. Sed sit amet elementum felis, at cursus mauris.
            Curabitur tincidunt lorem sit amet leo efficitur tincidunt. Sed dictum elit turpis, rutrum accumsan 
            leo vehicula at. Curabitur sodales libero at congue lobortis. Nullam feugiat tellus id ante accumsan,
            sed vestibulum neque fermentum. Donec ut aliquet lacus. Proin ultricies porta enim. Vestibulum rutrum, urnanec 
            dapibus semper, sem purus aliquam felis, eget pretium ligula sapien nec nisi. Fusce volutpat lorem in 
            rutrum pulvinar. Pellentesque quis leo ut orci suscipit sodales a non nisi. Vestibulum blandit, 
            dolor vel dictum lacinia, erat arcu semper ante, non scelerisque justo risus rhoncus risus' . $i);
        $manager->persist($question2);

        $user = new User();
        $user->setUsername('Sinex');
        $user->setFirstname('Florian');
        $user->setLastname('Salducci');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setEmail('flo@gmail.com');
        $user->setPassword($this->encoder->encodePassword($user, 'Florian'));
        $manager->persist($user);

        $userList = [];
        for ($i = 0; $i < 40; $i++) {
            $users = new User();
            $users->setUsername($faker->userName());
            $users->setFirstname($faker->firstName());
            $users->setPicture('https://media-exp1.licdn.com/dms/image/C4D03AQH-hn0JKyEobQ/profile-displayphoto-shrink_200_200/0?e=1602720000&v=beta&t=KWzcAe0Jtz9btvvgvQURQ1-MaMwA5jCpcZSacW9m3co');
            $users->setLastname($faker->lastName());
            $users->setEmail($faker->email());
            $users->setRoles(['ROLE_USER']);
            $users->setPassword($this->encoder->encodePassword($users, $users->getUsername()));
            $userList = $users;
            $manager->persist($users);
        }

        $developmentTag = new Tag();
        $developmentTag->setName('Development');
        $manager->persist($developmentTag);

        $technologyTag = new Tag();
        $technologyTag->setName('Technology');
        $manager->persist($technologyTag);

        $phpTag = new Tag();
        $phpTag->setName('Php');
        $manager->persist($phpTag);

        $symfonyTag = new Tag();
        $symfonyTag->setName('Symfony');
        $manager->persist($symfonyTag);

        $javascriptTag = new Tag();
        $javascriptTag->setName('Javascript');
        $manager->persist($javascriptTag);

        $manager->flush();
    }
}
