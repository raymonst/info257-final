<?php

	// connect to the database
	$conn = "host=db.ischool.berkeley.edu dbname=walkdb user=walkdb password=590jkr";
	$dbconn = pg_connect($conn) or die("could not connect");

	// form inputs
	$location = explode(" ", $_POST["input-location"]);
	$incidentType = $_POST["input-incident-type"];
	$race = $_POST["input-race"];
	$gender = $_POST["input-gender"];
	$story = $_POST["input-story"];

	// query to add incident to database
	$query = "
		INSERT INTO ind_reporter(reporting_entity_type, username, birth_year, gend, race) 
		VALUES('individual', 'lindab', 1985, ARRAY['Female']::gender[], ARRAY['White','Black']::race_ethnic_origins[])
		RETURNING reporting_entity_id as new_reporter_id;

		INSERT INTO incident(incident_type_id, reporter_id, notes, lat, long, geom) 
		VALUES(".$incidentType.", ind_reporter.new_reporter_id,".$story.$location[0].$location[1].", ST_Transform(ST_SetSRID(ST_Point(".$location[1].",".$location[0]."),4269),32661))
	";




/*
		WITH id as (
			INSERT INTO ind_reporter(reporting_entity_type, username, birth_year, gend, race) 
			VALUES('individual', 'lindab', 1985, ARRAY['Female']::gender[], ARRAY['White','Black']::race_ethnic_origins[])
			RETURNING reporting_entity_id
		)
		FROM id
		INSERT INTO incident(incident_type_id, incident_time, reporter_id, notes, lat, long, geom) 
		VALUES(11, TIMESTAMP '2011-05-16 15:36:38', id.reporting_entity_id, 'test', -84.3879824, 33.7489954, ST_Transform(ST_SetSRID(ST_Point(-84.3879824, 33.7489954),4269),32661));

		INSERT INTO incident(reporter_id) SELECT reporting_entity_id FROM id;




WITH id_row as (
	INSERT INTO ind_reporter(reporting_entity_type, username, birth_year, gend, race) 
	VALUES('individual', 'lindab', 1985, ARRAY['Female']::gender[], ARRAY['White','Black']::race_ethnic_origins[])
	RETURNING reporting_entity_id
)
INSERT INTO incident(incident_type_id, incident_time, reporter_id, notes, lat, long, geom) 
SELECT reporting_entity_id
FROM id_row
VALUES('11', now(), reporting_entity_id, 'test', -84.3879824, 33.7489954, ST_Transform(ST_SetSRID(ST_Point(-84.3879824, 33.7489954),4269),32661))



WITH id_row as (
	INSERT INTO ind_reporter(reporting_entity_type, username, birth_year, gend, race) 
	VALUES('individual', 'lindab', 1985, ARRAY['Female']::gender[], ARRAY['White','Black']::race_ethnic_origins[])
	RETURNING reporting_entity_id
)
INSERT INTO incident(incident_type_id, incident_time, reporter_id, notes, lat, long, geom) 
SELECT reporting_entity_id
FROM id_row



WITH id_row as (
	INSERT INTO ind_reporter(reporting_entity_type, username, birth_year, gend, race) 
	VALUES('individual', 'lindab', 1985, ARRAY['Female']::gender[], ARRAY['White','Black']::race_ethnic_origins[])
	RETURNING reporting_entity_id
)
INSERT INTO incident(reporter_id) 
SELECT reporting_entity_id
FROM id_row;

UPDATE incident
SET (incident_type_id, incident_time, notes, lat, long, geom) = (11, now(), 'test', -84.3879824, 33.7489954, ST_Transform(ST_SetSRID(ST_Point(-84.3879824, 33.7489954),4269),32661))
WHERE reporter_id = (SELECT max(reporter_id) FROM incident);





*/

/*
	$res = pg_query($dbconn, $query);
	$return = array();
	while ($row = pg_fetch_row($res)) {
		// lat, long, incident type, notes
	    $return[] = array($row[4], $row[5], $row[11], $row[3]);
	};
*/



	echo print_r($location)."<br/>";
	echo $incidentType."<br/>";
	echo print_r($race)."<br/>";
	echo print_r($gender)."<br/>";
	echo $story."<br/>";

?>