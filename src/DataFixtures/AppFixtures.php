<?php

namespace App\DataFixtures;

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
        for ($i = 0; $i < 3; $i++) {
            $question = new Question();
            $question->setTitles('Why do we use Symfony 6 ?', $i);
            $question->setContent('Sit similique quam et libero nihil sed voluptatibus adipisci et vero quod. 
            Et iusto sint aut autem temporibus eos quia error non omnis repellat quo voluptatibus explicabo! 
            Qui repellat pariatur quo doloribus quia aut incidunt quos et soluta deleniti est natus itaque aut saepe temporibus
            Et nisi nihil aut tempore in ipsam nisi eos ducimus veritatis aut harum voluptatem eum consequatur repellendus et rerum sapiente. 
            Et deserunt quia qui blanditiis tenetur sit autem eligendi. Aut amet cumque aut
             quae esse rem ducimus autem et exercitationem voluptatem quo quibusdam magni sed harum eius! ', $i);
            $manager->persist($question);
        }
        $question2 = new Question();
        $question2->setTitles('What is better console Xbox or Ps5 ?', $i);
        $question2->setContent('Contrary to popular belief, Lorem Ipsum is not simply random text. 
            It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, 
            from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. 
            Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, 
            written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. 
            he first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32?');
        $manager->persist($question2);

        $user = new User();
        $user->setFirstname('Florian');
        $user->setLastname('Salducci');
        $user->setEmail('flo@gmail.com');
        $user->setPassword($this->encoder->encodePassword($user, 'Florian'));
        $manager->persist($user);


        $manager->flush();
    }
}
