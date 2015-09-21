<?php

require '../../../includes/google-api-php-client/autoload.php';
//require 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('client_secrets.json');
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {

    $client->setAccessToken($_SESSION['access_token']);
    $service = new Google_Service_Calendar($client);
//      echo '<pre>'.print_r($service).'</pre>';exit;
    // Print the next 10 events on the user's calendar.
    $calendarId = 'jyupanqui@multibox.pe';
    $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => TRUE,
        'timeMin' => date('c'),
    );
    //THIS IS WHERE WE ACTUALLY PUT THE RESULTS INTO A VAR
    $events = $service->events->listEvents($calendarId, $optParams);
//    echo '<pre>'.print_r($events).'</pre>';exit;
    $calTimeZone = $events->timeZone; //GET THE TZ OF THE CALENDAR
//SET THE DEFAULT TIMEZONE SO PHP DOESN'T COMPLAIN. SET TO YOUR LOCAL TIME ZONE.
    date_default_timezone_set($calTimeZone);



    //START THE LOOP TO LIST EVENTS
    foreach ($events->getItems() as $event) {

        //Convert date to month and day

        $eventDateStr = $event->start->dateTime;
        if (empty($eventDateStr)) {
            // it's an all day event
            $eventDateStr = $event->start->date;
        }

        $temp_timezone = $event->start->timeZone;
        //THIS OVERRIDES THE CALENDAR TIMEZONE IF THE EVENT HAS A SPECIAL TZ
        if (!empty($temp_timezone)) {
            $timezone = new DateTimeZone($temp_timezone); //GET THE TIME ZONE
            //Set your default timezone in case your events don't have one
        } else {
            $timezone = new DateTimeZone($calTimeZone);
        }

        $eventdate = new DateTime($eventDateStr, $timezone);
        $link = $event->htmlLink;
        $TZlink = $link . "&ctz=" . $calTimeZone; //ADD TZ TO EVENT LINK
        //PREVENTS GOOGLE FROM DISPLAYING EVERYTHING IN GMT
        $newmonth = $eventdate->format("M"); //CONVERT REGULAR EVENT DATE TO LEGIBLE MONTH
        $newday = $eventdate->format("j"); //CONVERT REGULAR EVENT DATE TO LEGIBLE DAY
        echo '<div class="event-container">
            <div class="eventDate">
                <span class="month">';
        echo $newmonth;
        echo '</span><br />
                <span class="day">';
        echo $newday;
        echo ' </span><span class="dayTrail"></span>
            </div>
            <div class="eventBody">';
        echo '<a href="' . $TZlink . '">';
        echo $event->summary; //SUMMARY = TITLE
        echo '     </a>
            </div>
        </div>';
    }
} else {
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/dashboardDev/modulos/Admin/controllers/oauth2callback.php';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
    