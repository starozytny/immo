<?php

namespace Shanbo\ImmobilierBundle\Command;

use Shanbo\ImmobilierBundle\Entity\ShAgence;
use Shanbo\ImmobilierBundle\Entity\ShBien;
use Shanbo\ImmobilierBundle\Entity\ShStatAgence;
use Shanbo\ImmobilierBundle\Entity\ShStatGlobal;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ShanboImmoStatsCommand extends Command
{
    protected static $defaultName = 'shanbo:immo:stats';
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create stat for immo')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $agences = $this->em->getRepository(ShAgence::class)->findAll();
        $users = $this->em->getRepository(User::class)->findAll();

        $totalVentes = 0;
        $totalLocations = 0;
        $totalMaisons = 0;$totalApparts = 0;$totalParkings = 0;$totalBureaux = 0;
        $totalLocaux = 0;$totalImmeubles = 0;$totalTerrains = 0;$totalFonds = 0;$totalAutres = 0;
        foreach ($agences as $agence) {
            $agenceTotalVentes = 0;
            $agenceTotalLocations = 0;
            $totMaisons = 0;$totApparts = 0;$totParkings = 0;$totBureaux = 0;
            $totLocaux = 0;$totImmeubles = 0;$totTerrains = 0;$totFonds = 0;$totAutres = 0;
            foreach ($agence->getBiens() as $bien) {
                if($bien->getNatureCode() == ShBien::NATURE_LOCATION){
                    $totalLocations++;
                    $agenceTotalVentes++;
                }else{
                    $totalVentes++;
                    $agenceTotalLocations++;
                }

                switch ($bien->getTypeCode()){
                    case ShBien::TYPE_MAISON:
                        $totMaisons++;
                        $totalMaisons++;
                        break;
                    case ShBien::TYPE_APPARTEMENT:
                        $totApparts++;
                        $totalApparts++;
                        break;
                    case ShBien::TYPE_PARKING:
                        $totParkings++;
                        $totalParkings++;
                        break;
                    case ShBien::TYPE_BUREAUX:
                        $totBureaux++;
                        $totalBureaux++;
                        break;
                    case ShBien::TYPE_LOCAL:
                        $totLocaux++;
                        $totalLocaux++;
                        break;
                    case ShBien::TYPE_IMMEUBLE:
                        $totImmeubles++;
                        $totalImmeubles++;
                        break;
                    case ShBien::TYPE_TERRAIN:
                        $totTerrains++;
                        $totalTerrains++;
                        break;
                    case ShBien::TYPE_FOND_COMMERCE:
                        $totFonds++;
                        $totalFonds++;
                        break;
                    default:
                        $totAutres++;
                        $totalAutres++;
                        break;
                }
            }

            $anterieursStats = $this->em->getRepository(ShStatAgence::class)->findBy(array(
                'agence' => $agence
            ));


            if(sizeof($anterieursStats) >= 5){
                $this->em->remove($anterieursStats[0]);
            }

            $st = (new ShStatAgence())
                ->setTotalVentes($agenceTotalVentes)
                ->setTotalLocations($agenceTotalLocations)
                ->setTotBiens(count($agence->getBiens()))
                ->setTotM($totMaisons)
                ->setTotA($totApparts)
                ->setTotP($totParkings)
                ->setTotB($totBureaux)
                ->setTotL($totLocaux)
                ->setTotI($totImmeubles)
                ->setTotT($totTerrains)
                ->setTotF($totFonds)
                ->setTotAutres($totAutres)
                ->setAgence($agence)
            ;

            $this->em->persist($st);
        }

        $stats = $this->em->getRepository(ShStatGlobal::class)->findAll();

        if(sizeof($stats) >= 5){
            $this->em->remove($stats[0]);
        }

        $stat = (new ShStatGlobal())
            ->setTotalLocations($totalLocations)
            ->setTotalVentes($totalVentes)
            ->setTotalUsers(count($users))
            ->setTotM($totalMaisons)
            ->setTotA($totalApparts)
            ->setTotP($totalParkings)
            ->setTotB($totalBureaux)
            ->setTotL($totalLocaux)
            ->setTotI($totalImmeubles)
            ->setTotT($totalTerrains)
            ->setTotF($totalFonds)
            ->setTotAutres($totalAutres)
        ;

        $this->em->persist($stat);
        $this->em->flush();

        $io->comment('Stats créées.');
        return 1;
    }
}
