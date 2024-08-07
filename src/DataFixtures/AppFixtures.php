<?php

namespace App\DataFixtures;

use App\Entity\Descriptor;
use App\Entity\Domain;
use App\Entity\Level;
use App\Entity\Site;
use App\Entity\Skill;
use App\Entity\SkillFramework;
use App\Entity\Structure;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
          
    }
    
    public function load(ObjectManager $manager): void
    {        
        
        $apcData = [
            [
                'code' => 'Domaine 1',
                'name' => 'COMMUNIQUER (à l\'oral et à l\'écrit)',
                'skills' => [
                    [
                        'code' => '1a',
                        'name' => 'Traiter des informations orales ou écrites',
                        'descriptors' => [
                            'Identifier les propos tenus dans un dialogue, une interaction', 
                            'Identifier les auteurs d\'un message écrit',
                            'Identifier la nature et la fonction d\'une information transmise oralement',
                            'Identifier la nature et la fonction d\'un document',
                            'Identifier les différentes sources d\'informations écrites ou orales',
                            'Identifier les informations contenues dans un document',
                            'Comparer l\'information de sources différentes',
                            'Sélectionner la source utile à sa démarche',
                            'Mémoriser et conserver l\'information reçue (prise de notes, par exemple)',
                        ]
                    ],
                    [
                        'code' => '1b',
                        'name' => 'Transmettre des informations à l\'oral et à l\'écrit',
                        'descriptors' => [
                            'Restituer l’essentiel d\'un message oral ou écrit',
                            'Choisir le moyen de communication le plus adapté à la situation (oral, écrit, échange direct, lettre, mail, sms…)',
                            'Transmettre oralement une information, une consigne avec le vocabulaire approprié',
                            'Transmettre par écrit une information, une consigne avec le vocabulaire approprié',
                            'Renseigner différents types de formulaires (questionnaires, tableaux à double entrées…)',
                        ]
                    ],
                    [
                        'code' => '1c',
                        'name' => 'Échanger oralement avec autrui',
                        'descriptors' => [
                            'Identifier les interlocuteurs présents et leur attentes',
                            'Exprimer un propos tenant compte de son interlocuteur et de la situation (utiliser le registre de langue et le lexique approprié à l\'interlocuteur et à la situation)',
                            'Poser des questions pour comprendre',
                            'Répondre à des questions ou poser des questions adaptées à la situation de communication',
                            'Décrire de manière compréhensible pour autrui une situation, un objet, un problème ou un sentiment'
                        ]
                    ],
                    [
                        'code' => '1d',
                        'name' => 'Échanger par écrit avec autrui',
                        'descriptors' => [
                            'Produire un message adapté à l\'objectif de communication',
                            'Rédiger un texte en respectant les règles de construction d\'une phrase (sujet, verbe, complément)',
                            'Rédiger un texte avec le vocabulaire approprié à la situation',
                            'Repérer des anomalies dans un texte et les modifier'
                        ]
                    ],
                    [
                        'code' => '1e',
                        'name' => 'Argumenter un point de vue personnel',
                        'descriptors' => [
                            'Identifier ce qui est en jeu dans une situation de communication',
                            'Échanger avec autrui de manière appropriée dans la situation',
                            'Identifier les différents points de vue en jeu dans un échange',
                            'Élaborer un point de vue personnel',
                            'Participer à un débat en expliquant son point de vue'
                        ]
                    ],
                ]
            ],
            [
                'code' => 'Domaine 2',
                'name' => 'MOBILISER LES RÈGLES DE CALCUL ET LE RAISONNEMENT EN MATHÉMATIQUES',
                'skills' => [
                    [
                        'code' => '2a',
                        'name' => 'Utiliser les nombres dans la vie quotidienne et professionnelle',
                        'descriptors' => [
                            'Analyser les informations chiffrées',
                            'Choisir les raisonnements adaptés pour répondre à des situations courantes',
                            'Évaluer un ordre de grandeur',
                            'Réaliser mentalement un calcul',
                            'Vérifier la cohérence de résultats'
                        ]
                    ],
                    [
                        'code' => '2b',
                        'name' => 'Utiliser les outils mathématiques dans les situations de vie quotidienne et professionnelle',
                        'descriptors' => [
                            'Résoudre des problèmes en utilisant les 4 opérations',
                            'Résoudre des problèmes en combinant les opérations',
                            'Résoudre des problèmes en mobilisant la règle de 3 et de proportionnalité',
                            'Utiliser les pourcentages',
                            'Réaliser un calcul proportionnel'
                        ]
                    ],
                    [
                        'code' => '2c',
                        'name' => 'Utiliser les notions de grandeurs et de mesures dans les situations de la vie quotidienne et professionnelle',
                        'descriptors' => [
                            'Calculer les proportions nécessaires (pour les besoins d\'une recette, d\'un chantier…)',
                            'Réaliser une mesure avec l\'instrument adapté',
                            'Exploiter différents types de représentations tableaux, diagrammes, graphiques',
                            'Réaliser différents types de représentations tableaux, diagrammes, graphiques',
                            'Identifier les erreurs',
                            'Effectuer des calculs de périmètres, surfaces et volumes'
                        ]
                    ],
                    [
                        'code' => '2d',
                        'name' => 'Se repérer dans l\'espace et le temps',
                        'descriptors' => [
                            'Utiliser les unités de temps',
                            'Utiliser un planning, une grille d\'horaires (de bus, de cinéma…)',
                            'Extraire des informations utiles d\'un plan, une carte, un schéma',
                            'Renseigner correctement les horaires',
                            'Estimer le temps nécessaire pour conduire une action',
                            'Planifier une action dans le temps'
                        ]
                    ],
                ]
            ],
            [
                'code' => 'Domaine 3',
                'name' => 'UTILISER LES TECHNIQUES USUELLES DE L\'INFORMATION ET DE LA COMMUNICATION NUMÉRIQUE',
                'skills' => [
                    [
                        'code' => '3a',
                        'name' => 'Se repérer dans l\'univers numérique',
                        'descriptors' => [
                            'Identifier différents outils numériques et leurs fonctions',
                            'Distinguer les usages personnels et professionnels des outils numériques',
                            'Repérer dans son environnement les différentes ressources liées au numérique'
                        ]
                    ],
                    [
                        'code' => '3b',
                        'name' => 'Utiliser les fonctionnalités des outils numériques pour communiquer',
                        'descriptors' => [
                            'Choisir l\'outil numérique adapté à sa démarche',
                            'Gérer une messagerie et un fichier de contacts',
                            'Exploiter des documents bureautiques au moyen de différentes interfaces numériques',
                            'Exploiter des fichiers multimédia au moyen de différentes interfaces numériques'
                        ]
                    ],
                    [
                        'code' => '3c',
                        'name' => 'Utiliser le numérique dans ses pratiques de la vie courante',
                        'descriptors' => [
                            'Renseigner un formulaire numérique',
                            'Enregistrer des informations',
                            'Sauvegarder des données',
                            'Utiliser un navigateur pour accéder à Internet',
                            'Se repérer dans une page web',
                            'Utiliser un moteur de recherche',
                            'Analyser la nature des sites proposés par le moteur de recherche',
                            'Accéder à des services en ligne',
                            'Identifier les sites pratiques ou d\'informations liés à la vie politique, culturelle, sociale et à l\'environnement professionnel'
                        ]
                    ],
                    [
                        'code' => '3d',
                        'name' => 'Gérer son identité numérique',
                        'descriptors' => [
                            'Gérer ses profils numériques',
                            'Protéger son identité numérique',
                            'Identifier l\'impact de son activité sur les réseaux sociaux (valorisation de l\'image de soi et des autres et/ou atteinte à l\'image de soi et des autres)',
                            'Gérer les traces de son activité numérique',
                            'Gérer l\'impact de son identité numérique sur ses pratiques professionnelles et sociales'
                        ]
                    ],
                    [
                        'code' => '3e',
                        'name' => 'Adopter une ligne de conduite dans la société numérique',
                        'descriptors' => [
                            'Identifier les conséquences des usages numériques des autres sur mon identité numérique',
                            'Identifier les règles régissant les usages (droit à l\'oubli, droit à l\'image, droit d\'auteur…)',
                            'Gérer les différents paramètres (notamment ceux de confidentialité, sécurité…)',
                            'Mettre en oeuvre des pratiques respectueuses du droit des autres'
                        ]
                    ],

                ]
            ],
            [
                'code' => 'Domaine 4',
                'name' => 'AGIR DANS LE CADRE D\'UN COLLECTIF (équipe, groupe de stagiaires, association, groupe projet…)',
                'skills' => [
                    [
                        'code' => '4a',
                        'name' => 'Identifier les règles du collectif',
                        'descriptors' => [
                            'Repérer les règles annoncées et les règles non dîtes (implicites et explicites)',
                            'Identifier les documents qui définissent les droits et devoirs des personnes',
                            'Analyser les fonctions des documents institutionnels (chartes, règlement intérieur…)'
                        ]
                    ],
                    [
                        'code' => '4b',
                        'name' => 'Adapter son comportement au cadre collectif',
                        'descriptors' => [
                            'Identifier les rôles et responsabilités des membres du collectif',
                            'Déterminer sa propre place au sein du collectif',
                            'Agir avec les membres du groupe en prenant en compte les règles du collectif'
                        ]
                    ],
                    [
                        'code' => '4c',
                        'name' => 'Apporter sa contribution au collectif',
                        'descriptors' => [
                            'Identifier les objectifs du collectif',
                            'Faire des propositions',
                            'S\'impliquer dans des actions concrètes du collectif',
                            'Prendre des responsabilités au sein du collectif',
                            'Identifier les conséquences de ses actions sur le collectif'
                        ]
                    ],
                ]
            ],
            [
                'code' => 'Domaine 5',
                'name' => 'PRÉPARER SON AVENIR PROFESSIONNEL',
                'skills' => [
                    [
                        'code' => '5a',
                        'name' => 'Formuler des objectifs personnels et/ou professionnels',
                        'descriptors' => [
                            'Déterminer des priorités',
                            'Déterminer son intérêt à formuler un projet notamment professionnel',
                            'Définir ses attentes personnelles',
                            'Déterminer ses objectifs en fonction de sa situation et ses perspectives personnelles, familiales, sociales et/ou professionnelles',
                            'Formuler les objectifs à atteindre dans le cadre de son projet'
                        ]
                    ],
                    [
                        'code' => '5b',
                        'name' => 'Mettre en oeuvre ses objectifs en fonction de ses priorités',
                        'descriptors' => [
                            'Déterminer la faisabilité de ses objectifs',
                            'Solliciter les personnes ressources',
                            'Organiser son temps et planifier son activité'
                        ]
                    ],
                    [
                        'code' => '5c',
                        'name' => 'Adapter ses objectifs en fonction de ses opportunités et contraintes',
                        'descriptors' => [
                            'Organiser son activité',
                            'Gérer les imprévus et saisir les opportunités',
                            'Repérer les contraintes internes et externes (mobilité…)',
                            'Anticiper les résultats',
                            'Modifier les objectifs de départ si nécessaire',
                            'Évaluer ses objectifs a posteriori'
                        ]
                    ],
                ]
            ],
            [
                'code' => 'Domaine 6',
                'name' => 'APPRENDRE TOUT AU LONG DE LA VIE',
                'skills' => [
                    [
                        'code' => '6a',
                        'name' => 'Identifier ses acquis (connaissances, manières d\'apprendre et de faire, habiletés…)',
                        'descriptors' => [
                            'Repérer dans son parcours les différentes situations d\'apprentissage qui ont conduit à des acquis',
                            'Nommer ses acquis',
                            'Identifier les conditions d\'apprentissage efficaces pour soi',
                            'Formaliser ses acquis et leurs évolutions (CV, portefeuille de compétences…)'
                        ]
                    ],
                    [
                        'code' => '6b',
                        'name' => 'Entretenir ses acquis',
                        'descriptors' => [
                            'Associer objectifs de formation et projet (personnel et professionnel)',
                            'Formuler ses exigences pour optimiser son parcours',
                            'Identifier l\'offre de formation et de qualification',
                            'Identifier les formations pertinentes et possibles pour soi',
                            'Faire reconnaître ses acquis'
                        ]
                    ],
                    [
                        'code' => '6c',
                        'name' => 'Utiliser ses relations pour évoluer professionnellement et/ou socialement',
                        'descriptors' => [
                            'Repérer les sources d\'information mobilisables',
                            'Prendre contact avec les personnes ressources (rencontres, mail,...)',
                            'Se renseigner sur les besoins en compétences et les possibilités de formation associées à ses projets',
                            'Se faire connaître (utilisation du CV et de ses identités numériques)',
                            'Illustrer son parcours par ses réalisations positives'
                        ]
                    ],
                ]
            ],
            [
                'code' => 'Domaine 7',
                'name' => 'AGIR DANS SON ENVIRONNEMENT ET AU TRAVAIL',
                'skills' => [
                    [
                        'code' => '7a',
                        'name' => 'Repérer les règles en vigueur dans son environnement',
                        'descriptors' => [
                            'Identifier les règles et leurs fonctions',
                            'Identifier les personnes ressources permettant d\'expliquer et/ou d\'agir sur les règles',
                            'Proposer des améliorations'
                        ]
                    ],
                    [
                        'code' => '7b',
                        'name' => 'Agir en toute sécurité, pour soi-même et pour les autres',
                        'descriptors' => [
                            'Adopter les gestes, réflexes et postures adaptés aux différentes situations afin d\'éviter les risques pour soi et pour les autres',
                            'Identifier un dysfonctionnement dans son périmètre d\'activité ainsi que les risques associés s\'il y a lieu',
                            'Alerter les interlocuteurs concernés par les dysfonctionnements et les risques constatés',
                            'Se protéger avec les équipements adéquats et selon les règles transmises'
                        ]
                    ],
                    [
                        'code' => '7c',
                        'name' => 'Appliquer les gestes de premier secours',
                        'descriptors' => [
                            'Maîtriser les gestes de premiers secours',
                            'Réagir de manière adaptée à une situation dangereuse',
                            'Identifier le bon interlocuteur à alerter selon les situations les plus courantes'
                        ]
                    ],
                    [
                        'code' => '7d',
                        'name' => 'Contribuer à la préservation de l\'environnement et aux économies d\'énergie',
                        'descriptors' => [
                            'Appliquer les règles de gestion des déchets',
                            'Respecter les règles élémentaires de recyclage',
                            'Faire un usage optimal des installations et des équipements en termes d\'économie d\'énergie',
                            'Utiliser de manière adaptée les produits d\'usage courant (papeterie, entretien…)',
                            'Proposer des actions de nature à favoriser le respect de l\'environnement'
                        ]
                    ],
                ]
            ],
            [
                'code' => 'Domaine 8',
                'name' => 'S\'OUVRIR À LA VIE CULTURELLE, SOCIALE ET CITOYENNE',
                'skills' => [
                    [
                        'code' => '8a',
                        'name' => 'Pratiquer une activité physique ou sportive',
                        'descriptors' => [
                            'Identifier les liens entre activité physique et bien-être',
                            'Mettre en oeuvre des pratiques visant son bien-être physique',
                            'Participer à des activités collectives',
                            'Identifier ses besoins en matière de bien-être'
                        ]
                    ],
                    [
                        'code' => '8b',
                        'name' => 'Participer à des activités culturelles',
                        'descriptors' => [
                            'Découvrir l\'offre culturelle de son environnement',
                            'Diversifier ses pratiques culturelles',
                            'Organiser une activité culturelle'
                        ]
                    ],
                    [
                        'code' => '8c',
                        'name' => 'Participer à la vie sociale et citoyenne',
                        'descriptors' => [
                            'S\'informer sur les droits et devoirs du citoyen',
                            'Identifier les organisations associatives, civiques et politiques de son environnement',
                            'Exprimer ses opinions dans un collectif',
                            'S\'impliquer dans des activités sociales et/ ou citoyennes'
                        ]
                    ],
                ]
            ],
            [
                'code' => 'Domaine 9',
                'name' => 'COMMUNIQUER (à l\'oral et à l\'écrit) EN LANGUE ÉTRANGÈRE',
                'skills' => [
                    [
                        'code' => '9a',
                        'name' => 'Traiter des informations orales ou écrites en langue étrangère',
                        'descriptors' => [
                            'Identifier les propos tenus dans un dialogue, une interaction',
                            'Identifier les auteurs d\'un message écrit',
                            'Identifier la nature et la fonction d\'une information transmise oralement',
                            'Identifier la nature et la fonction d\'un document',
                            'Identifier les différentes sources d\'informations écrites ou orales',
                            'Identifier les informations contenues dans un document',
                            'Comparer l\'information de sources différentes',
                            'Sélectionner la source utile à sa démarche',
                            'Mémoriser et conserver l\'information reçue (prise de notes, par exemple)'
                        ]
                    ],
                    [
                        'code' => '9b',
                        'name' => 'Transmettre des informations à l\'oral et à l\'écrit en langue étrangère',
                        'descriptors' => [
                            'Restituer l\'essentiel d\'un message oral ou écrit',
                            'Choisir le moyen de communication le plus adapté à la situation (oral, écrit, échange direct, lettre, mail, sms…)',
                            'Transmettre oralement une information, une consigne avec le vocabulaire approprié',
                            'Transmettre par écrit une information, une consigne avec le vocabulaire approprié',
                            'Renseigner différents types de formulaires (questionnaires, tableaux à double entrées…)'
                        ]
                    ],
                    [
                        'code' => '9c',
                        'name' => 'Échanger oralement avec autrui en langue étrangère',
                        'descriptors' => [
                            'Identifier les interlocuteurs présents et leur attentes',
                            'Exprimer un propos tenant compte de son interlocuteur et de la situation (utiliser le registre de langue et le lexique approprié à l\'interlocuteur et à la situation)',
                            'Poser des questions pour comprendre',
                            'Répondre à des questions ou poser des questions adaptées à la situation de communication',
                            'Décrire de manière compréhensible pour autrui une situation, un objet, un problème ou un sentiment'
                        ]
                    ],
                    [
                        'code' => '9d',
                        'name' => 'Échanger par écrit avec autrui en langue étrangère',
                        'descriptors' => [
                            'Rédiger un texte avec le vocabulaire approprié à la situation',
                            'Repérer des anomalies dans un texte et les modifier'
                        ]
                    ],
                    [
                        'code' => '9e',
                        'name' => 'Argumenter un point de vue personnel en langue étrangère',
                        'descriptors' => [
                            'Identifier ce qui est en jeu dans une situation de communication',
                            'Échanger avec autrui de manière appropriée dans la situation',
                            'Identifier les différents points de vue en jeu dans un échange',
                            'Élaborer un point de vue personnel',
                            'Participer à un débat en expliquant son point de vue'
                        ]
                    ],
                ]
            ],
        ];

        $levels = [
            [
                'name' => 'Non évaluée',
                'hierarchy' => 0,
                'description' => 'Aucune expérience n\'a été évaluée'
            ],
            [
                'name' => 'Palier 1',
                'hierarchy' => 1,
                'description' => 'Je fais'
            ],
            [
                'name' => 'Palier 2',
                'hierarchy' => 1,
                'description' => 'J\'explique'
            ],
            [
                'name' => 'Palier 3',
                'hierarchy' => 3,
                'description' => 'J\'analyse'
            ],
            [
                'name' => 'Palier 4',
                'hierarchy' => 4,
                'description' => 'Je transfère'
            ],
        ];

        $sites = ['Siège', 'site d\'Armentières', 'site de Lille', 'site de Roubaix', 'site de Saint-Omer'];
        $admSite = null;
        
        
        $structure = (new Structure())
            ->setName('E2C - Grand Lille')
            ->setLogo('e2cgl.webp');
        
        $manager->persist($structure);

        $framework = (new SkillFramework())
            ->setName('Référentiel APC')
            ->setDescription('Référentiel officiel du réseau E2C France couvrant les compétences transversales (soft skills) mobiliser pendant un parcours de formation')
            ->addStructure($structure);

        $manager->persist($framework);

        foreach($apcData as $dom) {
            $domain = new Domain();
            $domain->setName($dom['name']);
            $domain->setCode($dom['code']);
            $domain->setFramework($framework);
            foreach($dom['skills'] as $ki) {
                $skill = new Skill();
                $skill->setName($ki['name']);
                $skill->setCode($ki['code']);
                $skill->setDomain($domain);
                foreach($ki['descriptors'] as $desc) {
                    $descriptor = new Descriptor();
                    $descriptor->setDescription($desc);
                    $descriptor->setSkill($skill);
                    $manager->persist($descriptor);
                }
                $manager->persist($skill);
            }
            $manager->persist($domain);
        }

        foreach($levels as $lvl) {
            $level = new Level();
            $level->setName($lvl['name']);
            $level->setHierarchy($lvl['hierarchy']);
            $level->setDescription($lvl['description']);
            $level->setFramework($framework);

            $manager->persist($level);
        }

        foreach($sites as $st) {
            $site = new Site();
            $site->setName($st);
            $site->setStructure($structure);
            if($st === 'Siège') {
                $admSite = $site;
            }

            $manager->persist($site);
        }

        $user = (new User());
        $user->setEmail('admin@apc.e2c-app-factory.fr');
        $user->setPassword($this->hasher->hashPassword($user, 'Admin'));
        $user->setSite($admSite);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setFirstname('Olivier');
        $user->setLastname('Burcker');
        $user->setActive(true);

        $manager->persist($user);



        $manager->flush();
    }
}
