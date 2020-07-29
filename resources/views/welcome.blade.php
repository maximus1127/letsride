@extends('layouts.template')
@section('content')


<!-- Booking now form wrapper html start -->
<div class="booking-form-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="row">
							<div class="form-wrap ">
								<div class="form-headr"></div>
                                <h2>Compare vehicle rate</h2>
                                <p class="shift">Search all vehicle companies in Nigeria closest to your location, and get best fair rates within seconds </p>
								<div class="form-select">
									<form>

										<div class="col-sm-12 custom-select-box tec-domain-cat3">
											<div class="row">
												<div id="panel">
												<select id="start" onchange="calcRoute();" class="selectpicker custom-select-box tec-domain-cat">
												  <option value="">From</option>
												  <option value="chicago, il">Chicago</option>
												  <option value="st louis, mo">St Louis</option>
												  <option value="joplin, mo">Joplin, MO</option>
												  <option value="oklahoma city, ok">Oklahoma City</option>
												  <option value="amarillo, tx">Amarillo</option>
												  <option value="gallup, nm">Gallup, NM</option>
												  <option value="flagstaff, az">Flagstaff, AZ</option>
												  <option value="winona, az">Winona</option>
												  <option value="kingman, az">Kingman</option>
												  <option value="barstow, ca">Barstow</option>
												  <option value="san bernardino, ca">San Bernardino</option>
												  <option value="los angeles, ca">Los Angeles</option>
												  <option value="khulna">Khulna, Bangladesh</option>
												  <option value="terokhada">Terokhada, Bangladesh</option>
												</select>
												</div>

											</div>
										</div>
										<div class="col-sm-12 custom-select-box tec-domain-cat4">
											<div class="row">
												<div>
													<select id="end" onchange="calcRoute();"  class="selectpicker custom-select-box tec-domain-cat">
														<option value="">To</option>
													  <option value="chicago, il">Chicago</option>
													  <option value="st louis, mo">St Louis</option>
													  <option value="joplin, mo">Joplin, MO</option>
													  <option value="oklahoma city, ok">Oklahoma City</option>
													  <option value="amarillo, tx">Amarillo</option>
													  <option value="gallup, nm">Gallup, NM</option>
													  <option value="flagstaff, az">Flagstaff, AZ</option>
													  <option value="winona, az">Winona</option>
													  <option value="kingman, az">Kingman</option>
													  <option value="barstow, ca">Barstow</option>
													  <option value="san bernardino, ca">San Bernardino</option>
													  <option value="los angeles, ca">Los Angeles</option>
													  <option value="Satkhira">Satkhira, Bangladesh</option>
													  <option value="terokhada">Terokhada, Bangladesh</option>
													</select>
												</div>
											</div>
                                        </div>


										<div class="col-sm-12 custom-select-box tec-domain-cat4">
											<div class="row">

												<div>

														<input class="form-control custom-select-box tec-domain-cat5" type="date" name="date"  />

												</div>


											</div>
										</div>

										<div class="form-button">
											<button type="submit" class="btn form-btn btn-lg btn-block">Search Transport Company</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    <!-- Booking now form wrapper html Exit -->



    <!-- anytime-anywhere html start -->
		<div class="anytime-anywhere">
			<div class="row">
				<div class="anytime-wrap">
					<h1>BEST <br/>RATES!</h1>
					<div class="anytime-text">
						<p><i class="fa fa-custom fa-circle-o"></i>Find cheapest fare from over 100 transport companies.</p>
						<p><i class="fa fa-custom fa-circle-o"></i>Compare rates and find the one nearest to you.</p>
						<p><i class="fa fa-custom fa-circle-o"></i>Avoid long wait time | quick search.</p>
					</div>
				</div>
			</div>
		</div>
	<!-- anytime-anywhere html Exit -->






@stop
