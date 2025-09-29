<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the POST data
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if (isset($data['seats']) && is_array($data['seats'])) {
        // Save the seats in the session
        $_SESSION['selected_seats'] = $data['seats'];

        // Send success response
        echo json_encode([
            'success' => true,
            'message' => 'Stoelen zijn succesvol opgeslagen',
            'seats' => $_SESSION['selected_seats']
        ]);
    } else {
        // Invalid data received
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Ongeldige data ontvangen'
        ]);
    }
} else {
    // Wrong request method
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Alleen POST requests zijn toegestaan'
    ]);
}
?>