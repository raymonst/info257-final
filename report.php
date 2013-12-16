<?php include "_includes/header.php" ?>
	
<section id="container">
	
	<header>
		<a href="index.php">Sketched<span>Out</span></a>
	</header>

	<main>
 		<h1>Report An Incident</h1>
		<hr/>
		<form id="form-report" method="post">
			<h2>Where were you?</h2>
			<input type="text" placeholder="Address or street intersection" value="" id="input-location-raw" name="input-location-raw" /> 
			<input type="hidden" id="input-location" name="input-location" />
			<input type="button" id="input-generate-map" value="Generate map" />

			<div id="map-location"></div>

			<hr/>
			<h2>What happened?</h2>
			<select name="input-incident-type">
				<option value="">Select one</option>
				<option value="18">Aided case non-criminal</option>
				<option value="1">Assault</option>
				<option value="19">Death report</option>
				<option value="22">Disorderly conduct</option>
				<option value="13">Drugs</option>
				<option value="16">Drunkenness</option>
				<option value="21">Forcible sex offense</option>
				<option value="23">Found injured person</option>
				<option value="2">Groping</option>
				<option value="3">Homophobic</option>
				<option value="4">Homophobic assault</option>
				<option value="20">Kidnapping</option>
				<option value="25">Loitering</option>
				<option value="5">Masturbation</option>
				<option value="15">Mentally disturbed</option>
				<option value="6">Nonverbal</option>
				<option value="24">Prostitution</option>
				<option value="8">Racist</option>
				<option value="9">Racist assault</option>
				<option value="12">Robbery</option>
				<option value="10">Stalking</option>
				<option value="14">Vandalism</option>
				<option value="11">Verbal</option>
				<option value="17">Weapon laws</option>
				<option value="7">Other</option>
			</select>

			<hr/>
			<h2>Please tell us as much about yourself as you&rsquo;re comfortable with.</h2>
			<h3>Race/ethnicity (choose as many as apply)</h3>
			<div class="form-options">
				<input type="checkbox" name="input-race[]" id="input-race-latino" value="Latino" /> <label class="label-checkbox" for="input-race-latino">Latino</label>
				<br/>
				<input type="checkbox" name="input-race[]" id="input-race-hispanic" value="Hispanic" /> <label class="label-checkbox" for="input-race-hispanic">Hispanic</label>
				<br/>
				<input type="checkbox" name="input-race[]" id="input-race-black" value="Black" /> <label class="label-checkbox" for="input-race-black">Black</label>
				<br/>
				<input type="checkbox" name="input-race[]" id="input-race-south-asian" value="South Asian" /> <label class="label-checkbox" for="input-race-south-asian">South Asian</label>
				<br/>
				<input type="checkbox" name="input-race[]" id="input-race-native" value="Native American" /> <label class="label-checkbox" for="input-race-native">Native American</label>
				<br/>
				<input type="checkbox" name="input-race[]" id="input-race-pacific-islander" value="Pacific Islander" /> <label class="label-checkbox" for="input-race-pacific-islander">Pacific Islander</label>
				<br/>
				<input type="checkbox" name="input-race[]" id="input-race-white" value="White" /> <label class="label-checkbox" for="input-race-white">White</label>
				<br/>
				<input type="checkbox" name="input-race[]" id="input-race-southeast-asian" value="Southeast Asian" /> <label class="label-checkbox" for="input-race-southeast-asian">Southeast Asian</label>
				<br/>
			</div>
			<div class="form-options">
				<input type="checkbox" name="input-race[]" id="input-race-east-asian" value="East Asian" /> <label class="label-checkbox" for="input-race-east-asian">East Asian</label>
				<br/>
				<input type="checkbox" name="input-race[]" id="input-race-middle-eastern" value="Middle Eastern" /> <label class="label-checkbox" for="input-race-input-race-middle-eastern">Middle Eastern</label>
				<br/>
				<input type="checkbox" name="input-race[]" id="input-race-african" value="African" /> <label class="label-checkbox" for="input-race-african">African</label>
				<br/>
				<input type="checkbox" name="input-race[]" id="input-race-south-american" value="South American" /> <label class="label-checkbox" for="input-race-south-american">South American</label>
				<br/>
				<input type="checkbox" name="input-race[]" id="input-race-central-american" value="Central American" /> <label class="label-checkbox" for="input-race-central-american">Central American</label>
				<br/>
				<input type="checkbox" name="input-race[]" id="input-race-caribbean" value="Caribbean" /> <label class="label-checkbox" for="input-race-caribbean">Caribbean</label>
				<br/>
				<input type="checkbox" name="input-race[]" id="input-race-european" value="European" /> <label class="label-checkbox" for="input-race-european">European</label>
				<br/>
				<input type="checkbox" name="input-race[]" id="input-race-other" value="Other" /> <label class="label-checkbox" for="input-race-other">Other</label>
			</div>

			<br/><br/>
			<h3>Gender (choose as many as apply)</h3>
			<input type="checkbox" name="input-gender[]" id="input-gender-male" value="Male" /> <label class="label-checkbox" for="input-gender-male">Male</label>
			<br/>
			<input type="checkbox" name="input-gender[]" id="input-gender-female" value="Female" /> <label class="label-checkbox" for="input-gender-female">Female</label>
			<br/>
			<input type="checkbox" name="input-gender[]" id="input-gender-genderqueer" value="Genderqueer/gender non-conforming" /> <label class="label-checkbox" for="input-gender-genderqueer">Genderqueer / gender non-conforming</label>
			<br/>
			<input type="checkbox" name="input-gender[]" id="input-gender-trans" value="Trans" /> <label class="label-checkbox" for="input-gender-trans">Trans</label>

			<hr/>
			
			<h2>Tell your story</h2>
			<textarea name="input-story" id="input-story"></textarea>

			<br/><br/><br/><br/>
			<input type="submit" value="SUBMIT" />
		</form>

		<div id="loading"><img src="./_images/loading.gif" width="22" height="22" /></div>
		<div id="form-message"></div>

	</main>

</section>

<script type="text/javascript">
	form.report();
</script>

<?php include "_includes/footer.php" ?>
