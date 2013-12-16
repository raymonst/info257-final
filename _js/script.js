//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
var geo = {

	init: function() {
		geo.location();
	},

	location: function() {
		// get location
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);	
		} else {
			alert("We could not locate your position");
		}
		function showPosition(position) {
			$("#input-locate").on("click", function() {
				$("#input-location-raw, #input-location").val(position.coords.latitude + " " + position.coords.longitude);	
			});
		}
	},

	map: function(results) {
		// get latlong from input 
		var latlong = $("#input-location").val().split(" ");

		// set map options, draw map, then re-center (to fix bug when showing/hiding map)
		var mapOptions = {
		    center: new google.maps.LatLng(latlong[0], latlong[1]),
		    zoom: 14
		};
		var map = new google.maps.Map(document.getElementById("map"), mapOptions);
		setTimeout(function() {
			google.maps.event.trigger(map, 'resize');
			map.setZoom(map.getZoom());
			map.setCenter(new google.maps.LatLng(latlong[0], latlong[1]));
		}, 50); 

		// close button actions
		$("#map-overlay").fadeIn(100);
		setTimeout(function() {
			$("#map-close").fadeIn(100);
		}, 1000);
		$("#map-close").on("click", function() {
			$("#map-overlay").fadeOut(100);
			$("#map").html("");
			return false;
		});

		// create markers array & info window object
		var markers = [];
		var infowindow = new google.maps.InfoWindow({
			maxWidth: 300
		});

		// the first item is the user's location input
		// then, read items from the database
		markers.push([[latlong[0], latlong[1]]]);
		$.each(results, function(i,v) {
			var item = []
			item.push([results[i][0], results[i][1]], results[i][2], results[i][3])
		    markers.push(item);	
		});

		// loop through all markers 
		for(i = 0; i < markers.length; i++) {
			if(i == 0) {
			    marker = new google.maps.Marker({
			    	position: new google.maps.LatLng(markers[i][0][0], markers[i][0][1]),
			    	map: map,
			    	icon: "_images/marker-center.png"
			    });				
			} else {
			    	marker = new google.maps.Marker({
			    		position: new google.maps.LatLng(markers[i][0][0], markers[i][0][1]),
			    		map: map
			    	});
			};
		    google.maps.event.addListener(marker, 'click', (function(marker, i) {
				if(i == 0) {
			    	return function() {
			    		infowindow.setContent("You are here");
			    		infowindow.open(map, marker);
			    	}
			    } else {
			    	return function() {
				    	var content = markers[i][2].replace("Title:","").replace(" Link:","&hellip;<br/><br/>Link:<span class='map-modal-link'>") + "</span>";
			    		infowindow.setContent("<strong class='map-modal-title'>" + markers[i][1] + "</strong><br/><div class='map-modal-content'>" + content + "</div>");
			    		infowindow.open(map, marker);
			    	}
				}
		    }) (marker, i));

		};

		// create a 1-mile radius around the initial point
		var bindPoint = new google.maps.Marker({
		    position: new google.maps.LatLng(latlong[0], latlong[1]),
		    map: map,
		    visible: false // this is a hidden marker that serves as an anchor point for the circle
		});			
		var circle = new google.maps.Circle({
			map: map,
			radius: 1609.34,
			fillColor: "#4d6c77",
			fillOpacity: 0.25,
			strokeWeight: 0
		});
		circle.bindTo("center", bindPoint, "position");
   },

}



//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
var form = {

	search: function() {
		$("#form-search").on("submit", function(event) {
			// convert user input to geocode (latlong)
			var address = $("#input-location-raw").val();
			var geocoder = new google.maps.Geocoder();
			var latitude;
			var longitude;
			geocoder.geocode({ 
			    "address": address
			}, function(results, status) {
				// if geocode works, draw map 
				if (status == google.maps.GeocoderStatus.OK) {
			    	latitude = results[0].geometry.location.lat();
			        longitude = results[0].geometry.location.lng();
			        $("#input-location").val(latitude + " " + longitude);
			        var values = $("#form-search").serialize();
			        $.ajax({
			            type: "POST",
			            url: "search-form.php",
			            data: values,
			            dataType: "json"
			        })
			        .done(function(results) {
			            geo.map(results);
			        })
			        .fail(function() {
			        })
			        .always(function() {
			        });
			    } else {
			        alert("Please enter a valid address.")
			    }
			});
			event.preventDefault();
		});
	},

	report: function() {
		$("#input-generate-map").on("click", function() {
			var address = $("#input-location-raw").val();
			var geocoder = new google.maps.Geocoder();
			var latitude;
			var longitude;
			geocoder.geocode({ 
			    "address": address
			}, function(results, status) {
				// if geocode works, draw map 
				if (status == google.maps.GeocoderStatus.OK) {
					function drawMap() {
						// set map options & draw map
					    latitude = results[0].geometry.location.lat();
					    longitude = results[0].geometry.location.lng();
					    var latlong = new google.maps.LatLng(latitude, longitude);
						var mapOptions = {
					    	center: new google.maps.LatLng(latitude, longitude),
					    	zoom: 16
					    };
					    var map = new google.maps.Map(document.getElementById("map-location"), mapOptions);
					    var marker = new google.maps.Marker({
					        position: latlong,
					        map: map
					    });

					    // animate & re-center map (to fix bug when showing/hiding map)
					    $("#map-location").slideDown(200);
					    setTimeout(function() {
					        google.maps.event.trigger(map, 'resize');
					        map.setZoom(map.getZoom());
					        map.setCenter(new google.maps.LatLng(latitude, longitude));
					    }, 200); 
					};

					// call function
					drawMap();
			    } else {
			        alert("Please enter a valid address.")
			    };
			});
		});

		$("#form-report").on("submit", function(event) {
			// convert user input to geocode (latlong)
			var address = $("#input-location-raw").val();
			var geocoder = new google.maps.Geocoder();
			var latitude;
			var longitude;
			geocoder.geocode({ 
			    "address": address
			}, function(results, status) {
				// if geocode works, submit to database 
				if (status == google.maps.GeocoderStatus.OK) {
			    	latitude = results[0].geometry.location.lat();
			        longitude = results[0].geometry.location.lng();
			        $("#input-location").val(latitude + " " + longitude);
			        var values = $("#form-report").serialize();
			        $.ajax({
			            type: "POST",
			            url: "report-form.php",
			            data: values
			        })
			        .done(function(results) {
				        $("#loading").slideUp(100);
			            $("main").hide().html("<h1>The report was successfully submitted.<br/>Thank you.</h1><a href='index.php'>Return to homepage</a>").fadeIn(100);
			        })
			        .fail(function() {
				        $("#loading").slideUp(100);
			            $("#form-message").html("The report could not be submitted. Please try again.");
			        })
			        .always(function() {
				        $("#loading").slideDown(100);
			        });
			    } else {
			        alert("Please enter a valid address.")
			    }
			});
			event.preventDefault();
		});
	}

}



//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
$(document).ready(function() {
});

$(window).resize(function() {
});