<?php
require_once __DIR__ . '/vendor/autoload.php';
use Phpml\Classification\NaiveBayes;

$samples = [[1, 2, 8], [1, 4, 5, 6], [2, 3, 4, 7], [3, 4, 8, 9]];

$labels = ['corona virus', 'allergies', 'cold', 'flu'];

$classifier = new NaiveBayes();
$classifier->train($samples, $labels);

$symptoms = [
    'cough' => 1,
    'fever' => 2,
    'sore throat' => 3,
    'runny nose' => 4,
    'nausea' => 5,
    'loss of smell or taste' => 6,
    'body aches' => 7,
    'shortness of breath' => 8,
    'muscle aches' => 9,
    'chills' => 10,
    'sweating' => 11,
    'chest pain' => 12,
    'back pain' => 13,
    'abdominal pain' => 14,
    'diarrhea' => 15,
    'constipation' => 16,
    'blood in stools' => 17,
    'blurred vision' => 18,
    'eye pain' => 19,
    'ear pain' => 20,
    'nosebleed' => 21,
    'skin rash' => 22,
    'joint pain' => 23,
    'swollen lymph nodes' => 24,
    'none' => 25
];

$inputSymptoms = [1,2,8];

$predict = $classifier->predict($inputSymptoms);

echo $predict;
?>
