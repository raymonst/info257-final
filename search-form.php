<?php

	// connect to the database
	$conn = "host=db.ischool.berkeley.edu dbname=walkdb user=walkdb password=590jkr";
	$dbconn = pg_connect($conn) or die("could not connect");

	// form inputs
	$location = explode(" ", $_POST["input-location"]);
	$incidentType = $_POST["input-incident-type"];
	$race = $_POST["input-race"];
	$gender = $_POST["input-gender"];

	// query to collect incidents around a latlong point
	// IMPORTANT: the postgis sql input format is longlat, NOT latlong
	// e.g. -84.3879824 33.7489954
	$query = "
		SELECT *
		FROM incident
		LEFT JOIN incident_type ON incident.incident_type_id = incident_type.incident_type_id
		LEFT JOIN ind_reporter ON incident.reporter_id = ind_reporter.reporting_entity_id
		WHERE 
			ST_Distance(
				ST_Transform(
					ST_GeomFromText(
						'POINT(".$location[1]." ".$location[0].")',4326
						),26986
					), 
				ST_Transform(geom,26986)) <= 1609.34
	";

	// check incident type	
	if (!($incidentType == "all")) {
	    $query = $query." AND (incident.incident_type_id = ".$incidentType.")";
	};

	// check race
	if (isset($race)) {
	    $query .= " AND (";
	    foreach ($race as $r) {
	        $query .= "'".$r."' = ANY (race) OR ";
	    };
	    $query = substr($query, 0, -4);
	    $query .= ")";
	};	

	// check gender
	if (isset($gender)) {
	    $query .= " AND (";
	    foreach ($gender as $g) {
	        $query .= "'".$g."' = ANY (gend) OR ";
	    };
	    $query = substr($query, 0, -4);
	    $query .= ")";
	};	

	// collect the results in an array
	$res = pg_query($dbconn, $query);
	$return = array();
	while ($row = pg_fetch_row($res)) {
		// lat, long, incident type, notes
	    $return[] = array($row[4], $row[5], $row[11], $row[3]);
	};

	// echo the final return value so jquery can read it
	echo json_encode($return);

?>