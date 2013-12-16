<?php

	// connect to the database
	$conn = "host=db.ischool.berkeley.edu dbname=walkdb user=walkdb password=590jkr";
	$dbconn = pg_connect($conn) or die("could not connect");

	// form inputs
	$location = explode(" ", $_POST["input-location"]);
	$incidentType = $_POST["input-incident-type"];
	$username = 'lindab85'; // placeholder
	$birthYear = 1985; // placeholder
	$race = $_POST["input-race"];
	$gender = $_POST["input-gender"];
	$story = $_POST["input-story"];	

	print_r($location);
	// clean up "race" input for sql
	$raceArray;
	foreach ($race as $r) {
	    $raceArray .= "'".$r."',";
	};
	$raceArray = substr($raceArray, 0, -1);

	// clean up "gender" input for sql
	$genderArray;
	foreach ($gender as $g) {
	    $genderArray .= "'".$g."',";
	};
	$genderArray = substr($genderArray, 0, -1);

	// query to add incident to database
	// first add to "ind_reporter" table so we can get the reporter id
	// then based on this reporter id, update the "incident" table accordingly
	$query = "
		WITH id_row as (
			INSERT INTO ind_reporter(reporting_entity_type, username, birth_year, gend, race) 
			VALUES('individual', '".$username."', ".$birthYear.", ARRAY[".$genderArray."]::gender[], ARRAY[".$raceArray."]::race_ethnic_origins[])
			RETURNING reporting_entity_id
		)
		INSERT INTO incident(reporter_id) 
		SELECT reporting_entity_id
		FROM id_row;
		
		UPDATE incident
		SET (incident_type_id, incident_time, notes, lat, long, geom) = (".$incidentType.", now(), '".$story."', ".$location[0].", ".$location[1].", ST_Transform(ST_SetSRID(ST_Point(".$location[1].", ".$location[0]."),4269),32661))
		WHERE reporter_id = (SELECT max(reporter_id) FROM incident);
	";

	pg_query($dbconn, $query);

?>