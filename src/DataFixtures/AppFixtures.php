<?php

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 4; $i++) {
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

        $manager->flush();
    }
}
