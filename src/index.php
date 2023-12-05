<?php
$route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($route) {
    case '/':
        require 'user.php';
        break;
    case '/new_cv':
        require 'new_cv.html';
        break;
    case '/read_cv':
        require 'cv_details.php';
        break;
    case '/cv_pdf':
        require 'generate_pdf.php';
        break;
    default:
        require '404.php';
        break;
}

?>