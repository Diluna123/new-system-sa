<?php

http_response_code(410);
header('Content-Type: application/json');

echo json_encode([
	'status' => 'disabled',
	'message' => 'Endpoint removed for security reasons.'
]);

?>