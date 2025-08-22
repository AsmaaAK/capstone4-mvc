<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // جلب كل الفعاليات والمتطوعين
    $volunteers = $pdo->query("SELECT * FROM volunteers")->fetchAll(PDO::FETCH_ASSOC);
    $events = $pdo->query("SELECT * FROM events")->fetchAll(PDO::FETCH_ASSOC);

    $matches = [];

    foreach ($events as $event) {
        foreach ($volunteers as $vol) {
            $eventSkills = explode(',', $event['required_skills']);
            $volSkills = explode(',', $vol['skills']);

            $skillMatch = count(array_intersect($eventSkills, $volSkills)) > 0;
            $locationMatch = $event['location'] === $vol['location'];
            $timeMatch = $event['event_time'] === $vol['available_time'];

            if ($skillMatch && $locationMatch && $timeMatch) {
                $matches[] = [
                    'volunteer' => $vol['name'],
                    'event' => $event['name'],
                    'skills_match' => implode(',', array_intersect($eventSkills, $volSkills)),
                    'location' => $event['location'],
                    'event_time' => $event['event_time']
                ];
            }
        }
    }

    echo json_encode(['status'=>'success','matches'=>$matches]);
    exit;
}
