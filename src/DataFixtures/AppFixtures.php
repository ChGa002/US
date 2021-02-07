<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Post;
use App\Entity\Utilisateur;
use App\Entity\Module;
use App\Entity\Semestre;
use App\Entity\MotCle;
use App\Entity\Ressource;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        /* Création d'un générateur de données à partir de la classe Faker*/
        $faker = \Faker\Factory::create('fr_FR');

        /***************************************
        *** CREATION DES UTILISATEURS ***
        ****************************************/

        for ($i=1 ; $i <= 5; $i++){
            $uti = new Utilisateur();
            $uti->setNom($faker->lastName);
            $uti->setPrenom($faker->firstName);
            $uti->setMail($faker->email);
            $uti->setValide(false);
            $uti->setRoles(['ROLE_USER']);
            $uti->setActivationToken(md5(uniqid()));
            $manager->persist($uti);
        }

            $eb = new Utilisateur();
            $eb->setNom("Blandin");
            $eb->setPrenom("Ewen");
            $eb->setMail("eblandin002@iutbayonne.univ-pau.fr");
            $eb->setPseudo("Altiroh");
            $eb->setValide(true);
            $eb->setDerniereConnexion(\DateTime::createFromFormat('Y-m-d', "2021-01-24"));
            $eb->setMotDePasse("password");
            $eb->setRoles(['ROLE_ADMIN']);
            $manager->persist($eb);

            $ac = new Utilisateur();
            $ac->setNom("Cazabat");
            $ac->setPrenom("Alix");
            $ac->setMail("acazaba1@iutbayonne.univ-pau.fr");
            $ac->setPseudo("Kapricorne");
            $ac->setValide(true);
            $ac->setDerniereConnexion(\DateTime::createFromFormat('Y-m-d', "2021-01-24"));
            $ac->setMotDePasse("password");
            $ac->setRoles(['ROLE_ADMIN']);
            $manager->persist($ac);

            $pm = new Utilisateur();
            $pm->setNom("Massias");
            $pm->setPrenom("Paul");
            $pm->setMail("pmassias001@iutbayonne.univ-pau.fr");
            $pm->setPseudo("D4rkSide");
            $pm->setValide(true);
            $pm->setDerniereConnexion(\DateTime::createFromFormat('Y-m-d', "2021-01-24"));
            $pm->setMotDePasse("password");
            $pm->setRoles(['ROLE_ADMIN']);
            $manager->persist($pm);

            $cg = new Utilisateur();
            $cg->setNom("Gandolfi");
            $cg->setPrenom("Chiara");
            $cg->setMail("cgandolfi@iutbayonne.univ-pau.fr");
            $cg->setPseudo("Kiki");
            $cg->setValide(true);
            $cg->setDerniereConnexion(\DateTime::createFromFormat('Y-m-d', "2021-01-24"));
            $cg->setMotDePasse("password");
            $cg->setRoles(['ROLE_ADMIN']);
            $manager->persist($cg);

            $pe = new Utilisateur();
            $pe->setNom("Etcheverry");
            $pe->setPrenom("Patrick");
            $pe->setMail("petcheverry@iutbayonne.univ-pau.fr");
            $pe->setPseudo("Petche");
            $pe->setValide(true);
            $pe->setDerniereConnexion(\DateTime::createFromFormat('Y-m-d', "2021-01-24"));
            $pe->setMotDePasse("password");
            $pe->setRoles(['ROLE_USER']);
            $manager->persist($cg);


        /***************************************
        *** CREATION DES MOTS CLES ***
        ****************************************/

        $algorithmique = new MotCle();
        $algorithmique->setMotCle("algorithmique");

        $uml = new MotCle();
        $uml->setMotCle("uml");

        $web = new MotCle();
        $web->setMotCle("web");

        $droit = new MotCle();
        $droit->setMotCle("droit");

        $anglais = new MotCle();
        $anglais->setMotCle("anglais");

        $bd = new MotCle();
        $bd->setMotCle("bd");

        $sql = new MotCle();
        $sql->setMotCle("sql");

        $maths = new MotCle();
        $maths->setMotCle("maths");

        $reseau = new MotCle();
        $reseau->setMotCle("réseau");

        $algorithme = new MotCle();
        $algorithme->setMotCle("algorithme");

        $assembleur = new MotCle();
        $assembleur->setMotCle("assembleur");

        $manager->persist($algorithmique);
        $manager->persist($uml);
        $manager->persist($web);
        $manager->persist($droit);
        $manager->persist($anglais);
        $manager->persist($bd);
        $manager->persist($sql);
        $manager->persist($maths);
        $manager->persist($reseau);
        $manager->persist($algorithme);
        $manager->persist($assembleur);

        /***************************************
        *** CREATION DES SEMESTRES ***
        ****************************************/
        for ($num=1; $num <= 4; $num++) {

        ${"semestre".$num} = new Semestre();
        ${"semestre".$num} -> setSigle("S$num");
        ${"semestre".$num} -> setNom("Semestre $num");
        $manager -> persist(${"semestre".$num});

        }

        /***************************************
         ***  LISTE DES MODULES DE DUT INFO   ***
         ****************************************/
        $modulesDutInfo = array(
         "M1101" => "Introduction aux systèmes informatiques",
         "M1102" => "Introduction à l'algorithmique et à la programmation",
         "M1103" => "Structures de données et algorithmes fondamentaux",
         "M1104" => "Introduction aux bases de données",
         "M1105" => "Conception de documents et d'interfaces numériques",
         "M1106" => "Projet tutoré – Découverte",
         "M1201" => "Mathématiques discrètes",
         "M1202" => "Algèbre linéaire",
         "M1203" => "Environnement économique",
         "M1204" => "Fonctionnement des organisations",
         "M1205" => "Fondamentaux de la communication",
         "M1206" => "Anglais et informatique",
         "M1207" => "PPP - Connaître le monde professionnel",

         "M2101" => "Architecture et programmation des mécanismes de base d'un système informatique",
         "M2102" => "Architecture des réseaux",
         "M2103" => "Bases de la programmation orientée objet",
         "M2104" => "Bases de la conception orientée objet",
         "M2105" => "Introduction aux interfaces homme-machine (IHM)",
         "M2106" => "Programmation et administration des bases de données",
         "M2107" => "Projet tutoré – Description et planification de projet",
         "M2201" => "Graphes et langages",
         "M2202" => "Analyse et méthodes numériques",
         "M2203" => "Environnement comptable, financier, juridique et social",
         "M2204" => "Gestion de projet informatique",
         "M2205" => "Communication, information et argumentation",
         "M2206" => "Communiquer en anglais",
         "M2207" => "PPP – Identifier ses compétences",

         "M3101" => "Principes des ystèmes d’exploitation",
         "M3102" => "Services réseaux",
         "M3103" => "Algorithmique avancée",
         "M3104" => "Programmation Web côté serveur",
         "M3105" => "Conception et programmation objet avancées",
         "M3106C" => "Bases de données avancées Ou Complément de théorie des Bases de données",
         "M3201" => "Probabilités et statistique",
         "M3202C" => "Modélisations mathématiques ou Compléments de mathématiques",
         "M3203" => "Droit des technologies de l’information de la communication",
         "M3204" => "Gestion des systèmes d’information",
         "M3205" => "Communication professionnelle",
         "M3206" => "Collaborer en anglais",
         "M3301" => "Méthodologie de la production d’applications",
         "M3302" => "Projets tutorés – Mise en situation professionnelle",
         "M3303" => "PPP – Préciser son projet",
         "M3 Stages" => "Recherche de stage",
         // IPI

         "M4101C IPI" => "Administration système et réseau",
         "M4102C IPI" => "Programmation répartie",
         "M4103C IPI" => "Programmation Web - client riche",
         "M4104C IPI" => "Conception et développement d’applications mobiles Androïd",
         "M4105C IPI" => "Compléments d'informatique en vue d'une insertion immédiate",
         "M4106" => "Projet tutoré - Compléments",
         "M4201C IPI" => "Ateliers de création d’entreprise",
         "M4202C IPI" => "Recherche opérationnelle et aide à la décision",
         "M4203 IPI" => "Communication – Communiquer dans les organisations",
         "M4204" => "Travailler en anglais",
         "M4301" => "Stage professionnel",

         // PEL

         "M4101C PEL" => "Complément de théorie des systèmes d'exploitation et des réseaux",
         "M4102C PEL" => "Architecture et conception des applications web",
         "M4103C PEL" => "Programmation Web - client riche",
         "M4104C PEL" => "Agilité et bonnes pratiques de programmation",
         "M4105C PEL" => "Compléments d'algorithmique",
         "M4201C PEL" => "Reprise d’entreprises",
         "M4202C PEL" => "Compléments de Mathématiques",
         "M4203 PEL" => "Communication – Communiquer dans les organisations"

         );

        foreach ($modulesDutInfo as $codeModule => $titreModule) {
            // ************* Création d'un nouveau module *************
            ${"Module".$codeModule} = new Module();
            // Définition du code du semestre
            ${"Module".$codeModule}->setSigle($codeModule);
            // Définition du titre du semestre
            ${"Module".$codeModule}->setNom($titreModule);
            // Définition du numéro du semestre
            ${"Module".$codeModule}->setSemestre(${"semestre".$codeModule[1]});
            
            // Enregistrement du module créé
            $manager->persist(${"Module".$codeModule});
        }

         /********************************************************
        *** CREATION DES POSTS ***
        *********************************************************/

         // POST 1
            $post = new Post();

            $post->setCreateur($cg);
            $post->setTitre("Sujet controle M1102 de 2013");
            $post->setDescription("Sujet et correction du 2eme examen du module M1102");
            $post->addModule($ModuleM1102);
            $post->setDatePubli(\DateTime::createFromFormat('Y-m-d', "2019-10-24"));
            $post->addMotsCle($algorithmique);

            $ressource = new Ressource();
            $ressource->setNom("sujet");
            $ressource->setTypeDeFichier(".pdf");
            $ressource->setEmplacement("https://drive.google.com/file/d/1N2fh23wjwtucyonVlA8vjkHDanZ8qqpu/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $ressource = new Ressource();
            $ressource->setNom("correction");
            $ressource->setTypeDeFichier(".pdf");
            $ressource->setEmplacement("https://drive.google.com/file/d/1VeDo5DMJxRizDx30SccAowA2pUgAnJ_g/view?usp=sharing");
            
            $ressource->setPost($post);
            $manager->persist($ressource);
            
            $manager -> persist($post);

        // POST 2

            $post = new Post();

            $post->setCreateur($cg);
            $post->setTitre("UMLversC++ Rempli");
            $post->setDescription("Tableau des relations UML en C++");
            $post->addModule($ModuleM3105);
            $post->setDatePubli(\DateTime::createFromFormat('Y-m-d', "2019-12-09"));
            $post->addMotsCle($uml);
            $post->setEmplacementPhoto("https://www.visual-paradigm.com/servlet/editor-content/guide/uml-unified-modeling-language/uml-practical-guide/sites/7/2019/10/uml-banner.png");

            $ressource = new Ressource();
            $ressource->setNom("UMLversC++ Rempli");
            $ressource->setTypeDeFichier(".doc");
            $ressource->setEmplacement("https://www.dropbox.com/s/ozqfuass5bkpcge/UMLversC%2B%2BaTrous.doc?dl=0");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $manager -> persist($post);

        // POST 3
            $post = new Post();

            $post->setCreateur($pm);
            $post->setTitre("TP2 de programmation Web");
            $post->setDescription("Voici mon TP2 complet de prog Web");
            $post->addModule($ModuleM1105);
            $post->setDatePubli(\DateTime::createFromFormat('Y-m-d', "2020-10-21"));
            $post->addMotsCle($web);

            $ressource = new Ressource();
            $ressource->setNom("accueil");
            $ressource->setTypeDeFichier(".html");
            $ressource->setEmplacement("https://drive.google.com/file/d/1_Zyn83Z8nBvgdPBS8a6OOintyG-Ljcnj/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $ressource = new Ressource();
            $ressource->setNom("AB");
            $ressource->setTypeDeFichier(".html");
            $ressource->setEmplacement("https://drive.google.com/file/d/166ItRUEeW7K9St7AKZ9T-2_74uvAhMqR/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $ressource = new Ressource();
            $ressource->setNom("BO");
            $ressource->setTypeDeFichier(".html");
            $ressource->setEmplacement("https://drive.google.com/file/d/1pFpBRNM1S1W3dFPDRlH0RJg_3zgHvhWk/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $ressource = new Ressource();
            $ressource->setNom("rugby-pro-d2");
            $ressource->setTypeDeFichier(".jpeg");
            $ressource->setEmplacement("https://drive.google.com/file/d/1YkjTDIK_fLowSqWsI0_AZBGqwD0_vJD4/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $ressource = new Ressource();
            $ressource->setNom("AB-joueurs");
            $ressource->setTypeDeFichier(".jpeg");
            $ressource->setEmplacement("https://drive.google.com/file/d/1x2gicu6ENm9rXlN2-UOvCDOrvukkT-na/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $manager -> persist($post);


        // POST 4

            $post = new Post();

            $post->setCreateur($cg);
            $post->setTitre("Synthèse TD12");
            $post->setDescription("Synthèse du TD12 de TIC complété");
            $post->addModule($ModuleM3203);
            $post->setDatePubli(\DateTime::createFromFormat('Y-m-d', "2020-11-20"));
            $post->addMotsCle($droit);

            $ressource = new Ressource();
            $ressource->setNom("TD12");
            $ressource->setTypeDeFichier(".pdf");
            $ressource->setEmplacement("https://drive.google.com/file/d/17Iz9s0RDLJkU93ePcO-hfJgkoJjX6M0l/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $manager -> persist($post);

        // POST 5

            $post = new Post();

            $post->setCreateur($ac);
            $post->setTitre("Listening part 1-2");
            $post->setDescription("Exercices de compréhension orale pour TOEIC");
            $post->addModule($ModuleM1206);
            $post->addModule($ModuleM2206);
            $post->addModule($ModuleM3206);
            $post->addModule($ModuleM4204);
            $post->setDatePubli(\DateTime::createFromFormat('Y-m-d', "2020-01-14"));
            $post->addMotsCle($anglais);

            $ressource = new Ressource();
            $ressource->setNom("Track 15(1)");
            $ressource->setTypeDeFichier(".mp3");
            $ressource->setEmplacement("https://drive.google.com/file/d/1c9mruETCf2WGe9YCkClfegmwJZzhy2us/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $ressource = new Ressource();
            $ressource->setNom("Track 14(1)");
            $ressource->setTypeDeFichier(".mp3");
            $ressource->setEmplacement("https://drive.google.com/file/d/1RKz8lm5el3JfXTLDGLFq6Gw4RPtnAw1T/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $manager -> persist($post);

        // POST 6

            $post = new Post();

            $post->setCreateur($ac);
            $post->setTitre("Création des tables Joueur-Equipe");
            $post->setDescription("Fichiers SQL des tables Joueur et Equipe");
            $post->addModule($ModuleM2106);
            $post->addModule($ModuleM1104);
            $post->setDatePubli(\DateTime::createFromFormat('Y-m-d', "2020-09-28"));
            $post->addMotsCle($bd);
            $post->addMotsCle($sql);

            $ressource = new Ressource();
            $ressource->setNom("tableJoueur");
            $ressource->setTypeDeFichier(".sql");
            $ressource->setEmplacement("https://drive.google.com/file/d/1_E7UAVS6ohtDYo7_2GQi84YrCPoyzZjy/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $ressource = new Ressource();
            $ressource->setNom("tabeEquipe");
            $ressource->setTypeDeFichier(".sql");
            $ressource->setEmplacement("https://drive.google.com/file/d/1RvIcRxq5J1nYz4Hdf0_IB9-bDzcvUGxF/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $manager -> persist($post);

        // POST 7

            $post = new Post();

            $post->setCreateur($eb);
            $post->setTitre("Tableau analyse bivariée");
            $post->setDescription("Tableau présentant une analyse bivariée");
            $post->addModule($ModuleM3202C);
            $post->setDatePubli(\DateTime::createFromFormat('Y-m-d', "2020-12-02"));
            $post->addMotsCle($maths);

            $ressource = new Ressource();
            $ressource->setNom("Analyse_bivariée");
            $ressource->setTypeDeFichier(".xls");
            $ressource->setEmplacement("https://drive.google.com/file/d/10x2pBjQVie8yNy4IZ7M_bWuZp_D13eCj/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $manager -> persist($post);

        // POST 8

            $post = new Post();

            $post->setCreateur($eb);
            $post->setTitre("TP1 - code du serveur");
            $post->setDescription("Code en C du serveur");
            $post->addModule($ModuleM3102);
            $post->setDatePubli(\DateTime::createFromFormat('Y-m-d', "2021-01-07"));
            $post->addMotsCle($reseau);

            $ressource = new Ressource();
            $ressource->setNom("serveur");
            $ressource->setTypeDeFichier(".txt");
            $ressource->setEmplacement("https://drive.google.com/file/d/1Ks28wCVbS5IjKAiw927QauvxFxJOFdnN/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $manager -> persist($post);

         // POST 9

            $post = new Post();

            $post->setCreateur($pm);
            $post->setTitre("Tabula rasa");
            $post->setDescription("Code et exécuteur de Tabula Rasa");
            $post->addModule($ModuleM1102);
            $post->addModule($ModuleM1103);
            $post->addModule($ModuleM3103);
            $post->addModule(${"ModuleM4105C PEL"});
            $post->setDatePubli(\DateTime::createFromFormat('Y-m-d', "2020-09-12"));
            $post->addMotsCle($algorithmique);
            $post->addMotsCle($algorithme);

            $ressource = new Ressource();
            $ressource->setNom("TabulaRasa");
            $ressource->setTypeDeFichier(".rar");
            $ressource->setEmplacement("https://drive.google.com/file/d/1mkOYDrGJ5ROmvrbzctH36TSVPQVp8F_p/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $manager -> persist($post);

        // POST 10

            $post = new Post();

            $post->setCreateur($pm);
            $post->setTitre("Formulaire de recherche de stage");
            $post->setDescription("Formulaire à remplir et rendre toutes les 2 semaines");
            $post->addModule(${"ModuleM3 Stages"});
            $post->setDatePubli(\DateTime::createFromFormat('Y-m-d', "2020-11-01"));

            $ressource = new Ressource();
            $ressource->setNom("RechercheStage");
            $ressource->setTypeDeFichier(".odt");
            $ressource->setEmplacement("https://drive.google.com/file/d/16NcGDGOT31j1QrKbgSrAGhsSv_gRXgqe/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $ressource = new Ressource();
            $ressource->setNom("RechercheStage");
            $ressource->setTypeDeFichier(".pdf");
            $ressource->setEmplacement("https://drive.google.com/file/d/1YZKcUoReC9rAqnctHZd_5_7hjo1ntDst/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $manager -> persist($post);

        // POST 11

            $post = new Post();

            $post->setCreateur($eb);
            $post->setTitre("Balle compilee");
            $post->setDescription("Code de la balle en Assembleur compilé");
            $post->addModule($ModuleM2101);
            $post->setDatePubli(\DateTime::createFromFormat('Y-m-d',"2019-04-10"));
            $post->addMotsCle($assembleur);


            $ressource = new Ressource();
            $ressource->setNom("balleCompilee");
            $ressource->setTypeDeFichier(".mpc");
            $ressource->setEmplacement("https://drive.google.com/file/d/1uDu3RVQwXuPOX4DFVxBxPQ5zAWKwBQGf/view?usp=sharing");

            $ressource->setPost($post);
            $manager -> persist($ressource);

            $manager -> persist($post);

            
        // Envoi des objets créés en base de données
        $manager->flush();
    }
}
