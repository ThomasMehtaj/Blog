<?php
return [
'paths' => ['api/*'],
'allowed_methods' => ['*'],
'allowed_origins' => ['https://frontend.fr'], // Spécifiez explicitement l'origine
'allowed_origins_patterns' => [],
'allowed_headers' => ['*'],
'exposed_headers' => [],
'max_age' => 0,
'supports_credentials' => true, // Autorise les credentials il faut absoluement que ce soit à true comme le frontend
];