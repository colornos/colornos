<?php
require_once __DIR__ . '/vendor/autoload.php';

use Phpml\Classification\MLPClassifier;
use Phpml\NeuralNetwork\ActivationFunction\PReLU;
use Phpml\NeuralNetwork\ActivationFunction\Sigmoid;
use Phpml\NeuralNetwork\Layer;
use Phpml\NeuralNetwork\Node\Neuron;

$illnesses = ['allergies', 'flu', 'cold', 'coronavirus'];
$symptoms = [[1, 0, 0, 1, 0, 1, 1, 0, 0, 0], [0, 1, 1, 1, 1, 0, 0, 0, 1, 1], [1, 0, 1, 0, 0, 1, 0, 1, 1, 0], [1, 1, 1, 0, 1, 0, 0, 0, 0, 0]];

// Create layers
$layer1 = new Layer(2, Neuron::class, new PReLU);
$layer2 = new Layer(2, Neuron::class, new Sigmoid);

// Create MLP classifier
$mlp = new MLPClassifier(4, [$layer1, $layer2], $illnesses);

// Create symptoms weight arrays
$symptoms_weights_allergies = [2, 1, 1, 2, 2, 1, 1, 1, 1, 1];
$symptoms_weights_flu = [1, 2, 2, 1, 1, 1, 1, 1, 2, 1];
$symptoms_weights_cold = [1, 2, 1, 1, 2, 1, 1, 1, 1, 2];
$symptoms_weights_coronavirus = [1, 2, 2, 1, 1, 1, 1, 2, 1, 1];

// Multiply the symptoms by the weight
$symptoms_allergies = array_map(function($symptom) use ($symptoms_weights_allergies){
    return array_map(function($value, $weight) {
        return $value*$weight;
    }, $symptom, $symptoms_weights_allergies);
}, $symptoms);

$symptoms_flu = array_map(function($symptom) use ($symptoms_weights_flu){
    return array_map(function($value, $weight) {
        return $value*$weight;
    }, $symptom, $symptoms_weights_flu);
}, $symptoms);

$symptoms_cold = array_map(function($symptom) use ($symptoms_weights_cold){
    return array_map(function($value, $weight) {
        return $value*$weight;
    }, $symptom, $symptoms_weights_cold);
}, $symptoms);

$symptoms_coronavirus = array_map(function($symptom) use ($symptoms_weights_coronavirus){
    return array_map(function($value, $weight) {
        return $value*$weight;
    }, $symptom, $symptoms_weights_coronavirus);
}, $symptoms);
// Create labels array
$symptoms_labels = ['sneezing', 'cough', 'fever', 'runny nose', 'sore throat', 'diarrhea', 'rash', 'shortness of breath', 'fatigue', 'headache'];

// Train the classifier
$mlp->train($symptoms_allergies, $illnesses);
$mlp->train($symptoms_flu, $illnesses);
$mlp->train($symptoms_cold, $illnesses);
$mlp->train($symptoms_coronavirus, $illnesses);

// Store the actual symptoms
$actual_symptoms = [1, 0, 0, 0, 0, 0, 0, 0, 0, 0];

// Make a prediction
$predicted_illness = $mlp->predict($actual_symptoms);

// Print the prediction
echo "Predicted illness: " . $predicted_illness . "\n";

// Print the actual symptoms
echo "Actual Symptoms: ";
$symptoms_count = count($symptoms_labels);
foreach ($symptoms_labels as $index => $symptom) {
    if ($actual_symptoms[$index] == 1) {
        echo $symptom;
        if($index < $symptoms_count-1) {
            echo ", ";
        }
    }
}
?>
