<?php

if (isset($_CRON)) {

    $ServiceID = $_CRON["Data"]->data;

    foreach (\crisp\api\Config::get("plugin_statuspage_services") as $Service) {
        if ($Service->id == $ServiceID) {
            $ServiceData = \crisp\api\Config::get("plugin_statuspage_$ServiceID");

            if ($Service->type == "https") {



                echo $response;

                $handle = curl_init("https://" . $Service->address . ":" . $Service->port);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);

                $Start = microtime(true);
                curl_exec($handle);
                $End = microtime(true);

                $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

                curl_close($handle);

                $ServiceData->online = ($httpCode == 200);
                $ServiceData->ping = $End - $Start;
                $ServiceData->code = $httpCode;

                var_dump($ServiceData);

                \crisp\api\Config::set("plugin_statuspage_$ServiceID", $ServiceData);

                curl_close($handle);
            }
        }
    }
}