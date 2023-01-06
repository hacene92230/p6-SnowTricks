<?php

namespace App\DataFixtures;

use App\Entity\Figure;
use App\Entity\Groupe;
use DateTimeImmutable;
use App\Entity\Comments;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\User;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //création d'un user
        $user = new User();
$user->setName("hacene");
        $user->setEmail("hacenesahraoui.paris@gmail.com");
        $user->setPassword('$2y$13$f1fGqjshfGN90SoHUM4WcOCMs8ewjG02w5/gIqbvZHKwm5gOx7uQu');
        $manager->persist($user);

        //création des groupes
        for ($j = 0; $j < 5; $j++) {
            $_groupe[] = new Groupe();
            if ($j == 0)
                $_groupe[$j]->setName("Figures de base");
            elseif ($j == 1)
                $_groupe[$j]->setName("Figures de freestyle");
            elseif ($j == 2)
                $_groupe[$j]->setName("Figures de jibbing");
            elseif ($j == 3)
                $_groupe[$j]->setName("Figures de half-pipe");
            elseif ($j == 4)
                $_groupe[$j]->setName("Figures de backcountry");
            $manager->persist($_groupe[$j]);
        }

        // création des figures de base
        $figures = [
            ["Virage", "Le virage est une figure de base qui consiste à changer de direction sur le snowboard en inclinant la planche sur le côté."],
            ["Chasse-neige", "Le chasse-neige est une figure de base qui consiste à effectuer des mouvements de serpentin sur le snowboard pour créer de la poudreuse."],
            ["Stop-and-go", "Le stop-and-go est une figure de base qui consiste à s'arrêter et à repartir en utilisant des mouvements de pivot."],
            ["Traversée", "La traversée est une figure de base qui consiste à se déplacer sur le snowboard en diagonale pour traverser une piste de ski."],
            ["Glissade", "La glissade est une figure de base qui consiste à glisser sur le snowboard sans utiliser les bords."],
            ["Chaîne de virages", "La chaîne de virages est une figure de base qui consiste à enchaîner plusieurs virages de suite sur le snowboard."]
        ];

        foreach ($figures as list($name, $description)) {
            $figure = new Figure();
            $figure->setName($name);
            $figure->setDescription($description);
            $figure->setGroupe($_groupe[0]);
            $now = new DateTimeImmutable();
            $interval = new \DateInterval('P' . rand(1, 365) . 'D');
            $figure->setCreatedAt($now->sub($interval));

            $interval = new \DateInterval('P' . rand(1, 365) . 'D');
            $figure->setModifiedAt($figure->getCreatedAt()->add($interval));
            $figure->setAuthor($user);
            $manager->persist($figure);
        }

        // création des figures de freestyle
        $figures = [
            ["Ollie", "L'ollie est une figure de freestyle qui consiste à effectuer un saut en utilisant l'élasticité de la planche pour s'élever dans les airs."],
            ["Grind", "Le grind est une figure de freestyle qui consiste à glisser sur un rail ou une box en utilisant les bords de la planche."],
            ["Slide", "Le slide est une figure de freestyle qui consiste à glisser sur un rail ou une box en utilisant le dessous de la planche."],
            ["Backside", "Le backside est une figure de freestyle qui consiste à effectuer un saut en tournant le dos vers l'obstacle."],
            ["Frontside", "Le frontside est une figure de freestyle qui consiste à effectuer un saut en tournant le visage vers l'obstacle."],
            ["360", "Le 360 est une figure de freestyle qui consiste à effectuer un saut en tournant sur soi-même trois cent soixante degrés."]
        ];

        foreach ($figures as list($name, $description)) {
            $figure = new Figure();
            $figure->setName($name);
            $figure->setDescription($description);
            $figure->setGroupe($_groupe[1]);
            $now = new DateTimeImmutable();
            $interval = new \DateInterval('P' . rand(1, 365) . 'D');
            $figure->setCreatedAt($now->sub($interval));

            $interval = new \DateInterval('P' . rand(1, 365) . 'D');
            $figure->setModifiedAt($figure->getCreatedAt()->add($interval));
            $figure->setAuthor($user);
            $manager->persist($figure);
        }

        // création des figures de jibbing

        $figures = [
            ["50-50", "Le 50-50 est une figure de jibbing qui consiste à glisser sur un rail ou une box en utilisant les bords de la planche de chaque côté."],
            ["Lipslide", "Le lipslide est une figure de jibbing qui consiste à glisser sur un rail ou une box en utilisant le bord de la planche et en posant le pied sur le rail ou la box."],
            ["Boardslide", "Le boardslide est une figure de jibbing qui consiste à glisser sur un rail ou une box en utilisant le dessous de la planche et en posant le pied sur le rail ou la box."],
            ["Nosegrind", "Le nosegrind est une figure de jibbing qui consiste à glisser sur un rail ou une box en utilisant la pointe de la planche."],
            ["Tailslide", "Le tailslide est une figure de jibbing qui consiste à glisser sur un rail ou une box en utilisant la queue de la planche."],
            ["Crooks", "Le crooks est une figure de jibbing qui consiste à glisser sur un rail ou une box en utilisant le bord de la planche et en tournant le buste de côté pour passer le rail ou la box à angle droit."]
        ];

        foreach ($figures as list($name, $description)) {
            $figure = new Figure();
            $figure->setName($name);
            $figure->setDescription($description);
            $figure->setGroupe($_groupe[2]);
            $now = new DateTimeImmutable();
            $interval = new \DateInterval('P' . rand(1, 365) . 'D');
            $figure->setCreatedAt($now->sub($interval));

            $interval = new \DateInterval('P' . rand(1, 365) . 'D');
            $figure->setModifiedAt($figure->getCreatedAt()->add($interval));
            $figure->setAuthor($user);
            $manager->persist($figure);
        }

        // création des figures de half-pipe
        $figures = [
            ["Airs", "Les airs sont des figures de half-pipe qui consistent à sauter dans les airs en utilisant la force de propulsion de la pente de la half-pipe."],
            ["Spins", "Les spins sont des figures de half-pipe qui consistent à effectuer des rotations dans les airs en utilisant la force de propulsion de la pente de la half-pipe."],
            ["Grinds", "Les grinds sont des figures de half-pipe qui consistent à glisser sur les bords de la half-pipe en utilisant les bords de la planche."],
            ["Flips", "Les flips sont des figures de half-pipe qui consistent à effectuer des retournements dans les airs en utilisant la force de propulsion de la pente de la half-pipe."],
            ["Grabs", "Les grabs sont des figures de half-pipe qui consistent à saisir le bord de la planche ou la barre de snowboard avec les mains en effectuant des sauts dans les airs."],
            ["Inverts", "Les inverts sont des figures de half-pipe qui consistent à effectuer des rotations sur le dos ou le ventre en utilisant la force de propulsion de la pente de la half-pipe."]
        ];

        foreach ($figures as list($name, $description)) {
            $figure = new Figure();
            $figure->setName($name);
            $figure->setDescription($description);
            $figure->setGroupe($_groupe[3]);
            $now = new DateTimeImmutable();
            $interval = new \DateInterval('P' . rand(1, 365) . 'D');
            $figure->setCreatedAt($now->sub($interval));

            $interval = new \DateInterval('P' . rand(1, 365) . 'D');
            $figure->setModifiedAt($figure->getCreatedAt()->add($interval));
            $figure->setAuthor($user);
            $manager->persist($figure);
        }

        // création des figures de backcountry
        $figures = [
            ["Butter", "Le butter est une figure de backcountry qui consiste à effectuer des mouvements de balancement sur la planche en utilisant le poids du corps."],
            ["Carve", "Le carve est une figure de backcountry qui consiste à effectuer des virages précis en inclinant la planche sur le côté."],
            ["Jib", "Le jib est une figure de backcountry qui consiste à glisser sur des obstacles naturels tels que des branches, des rochers ou des troncs d'arbres en utilisant les bords de la planche."],
            ["Wallride", "Le wallride est une figure de backcountry qui consiste à glisser sur un mur ou une paroi en utilisant les bords de la planche."],
            ["Gap", "Le gap est une figure de backcountry qui consiste à sauter par-dessus un obstacle en utilisant la force de propulsion de la pente du terrain."],
            ["Pipe ride", "Le pipe ride est une figure de backcountry qui consiste à glisser dans un tuyau ou un tunnel en utilisant les bords de la planche."]
        ];

        foreach ($figures as list($name, $description)) {
            $figure = new Figure();
            $figure->setName($name);
            $figure->setDescription($description);
            $figure->setGroupe($_groupe[4]);
            $now = new DateTimeImmutable();
            $interval = new \DateInterval('P' . rand(1, 365) . 'D');
            $figure->setCreatedAt($now->sub($interval));

            $interval = new \DateInterval('P' . rand(1, 365) . 'D');
            $figure->setModifiedAt($figure->getCreatedAt()->add($interval));
            $figure->setAuthor($user);
            $manager->persist($figure);
        }


        $manager->flush();
    }
}
