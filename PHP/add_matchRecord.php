<?php
ini_set('display_errors', 'On');
include_once('DaisyScout.php');

$data = json_decode(file_get_contents("php://input"));

echo json_encode(DaisyScout::daisybase()->addMatchRecord(
$data->event_id,
$data->team_num, 
$data->match_num,
$data->scout_name,
$data->auton_reach,
$data->auton_cross,
$data->auton_midline,
$data->auton_scored_high,
$data->auton_shot_high,
$data->auton_scored_low,
$data->auton_shot_low,
$data->bot_type,
$data->defensive_ability,
$data->portcullis_crossings, 
$data->chevaldefrise_crossings, 
$data->moat_crossings, 
$data->ramparts_crossings,
$data->drawbridge_crossings, 
$data->sallyport_crossings, 
$data->roughterrain_crossings, 
$data->rockwall_crossings,
$data->lowbar_crossings, 
$data->shooter_range,
$data->primary_goal,
$data->high_boulders_scored, 
$data->high_boulders_shot, 
$data->low_boulders_scored,
$data->low_boulders_shot,
$data->balls_acquired,
$data->challenge,
$data->scaled,
$data->comments));

?>