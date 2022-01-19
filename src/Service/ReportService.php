<?php

namespace App\Service;

use App\Entity\Generator;
use App\Entity\GeneratorFactory;
use App\Repository\GeneratorRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;

class ReportService
{   
    private GeneratorRepository $repo;

    public function __construct(private KernelInterface $kernel, private ManagerRegistry $doctrine, private Environment $twig) {
        $this->repo = $this->doctrine->getRepository(Generator::class);
    }

    public function create(): string{
        $result = [];
        $file_name = "report_" . date('Y-m-d') . ".pdf";

        for($generator_id = 1; $generator_id <= 20; $generator_id ++){
            $start = (new DateTime('now'));
            $end = (new DateTime('now'));
            for($i = 0; $i < 24; $i++){
                $start->setTime($i, 0);
                $end->setTime($i, 59, 59, 599999);
                $hour = $i < 10 ? "0$i" : $i;
                $result[$generator_id][$hour] = $this->getMeasurementAverageByTime($generator_id, $start, $end);
            }
        }
        
        $this->saveDataToPdf($file_name, $result);
        return $file_name;
    }

    private function saveDataToPdf(string $file_name, Array $result): void{
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        
        $html = $this->twig->render('pdf/report.html.twig', [
            'report_data' => $result
        ]);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        
        $publicDirectory = $this->kernel->getProjectDir() . '/public';
        $pdfFilepath =  $publicDirectory . "/$file_name";
        
        file_put_contents($pdfFilepath, $output);
    }

    private function getMeasurementAverageByTime($generator_id, \DateTime $start, \DateTime $end): float{
        $power = 0;
        $measurement_list = $this->repo->findAllMeasurementByGeneratorId(
                $generator_id, 
                $start->getTimestamp(), 
                $end->getTimestamp()
            );
        
        if(!empty($measurement_list))
            $power = array_reduce($measurement_list, function ($sum = 0, $item) {
                $sum += $item->getPower();
                return $sum;
            });
        

        // if empty measurement_list return 0
        $power = empty($measurement_list) ? 0 :  $power / count($measurement_list) / 1000;

        return round($power, 5);
    }

}