<?php

$Target = crisp\Universe::UNIVERSE_BETA;

if (CURRENT_UNIVERSE < $Target) {
    http_response_code(424);
    echo $TwigTheme->render("errors/universe.twig", ["UNIVERSE_REQUIRED" => crisp\Universe::getUniverseName($Target)]);
    exit;
}