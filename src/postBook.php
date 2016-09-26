<?php
	include('auth.php');
	include('header.php');
?>
	
	<section>
		<div class="container">
			<div class="row">
				<div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title" style="text-align:center">Post a book</h3>
						</div>
						
						<div class="panel-body">
							<form role="form" action="exe/postBookexe.php" method="POST" enctype="multipart/form-data" >
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12">
										<span style='color:red'></span>
										<br>
										Book ISBN: 
										<div class="form-group">
											<input name='isbn' placeholder='ISBN-11 or ISBN-13' class="form-control input-lg" placeholder="BOOK ISBN" tabindex="1" required="required">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12">
										<span style='color:red'></span>
										<br>
										Book Edition: 
										<div class="form-group">
											<input name='edition' placeholder='Edition' class="form-control input-lg" tabindex="1" required="required">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12">
										<span style='color:red'></span>
										<br>
										Condition:
										<div class="form-group">
											<select name='condition' class="selectpicker" data-width="100%" >Select</option>
												<option value='new' >New</option>
												<option value='good'>Good</option>
												<option value='fair'>Fair</option>
												<option value='poor'>Poor</option>
											</select>
										</div>
										
									</div>
								</div>
								<div class="row">
									
									<div class="col-xs-12 col-sm-12 col-md-12">
										<span style='color:red'></span>
										<br>
										Price:
										<div class="form-group">
											<input type='number' name='price' min='0' step="0.01" value='1.00' class="form-control input-lg" placeholder="5.00" tabindex="2" required="required">
										</div>
									</div>
								</div>
								<div class="form-group">
									<span style='color:red'></span>
									<br>
									Quantity:
									<input type='number' name='quantity' min='1' class="form-control input-lg" value="1" placeholder="1" tabindex="4" required="required">
								</div>
								<div class="row">
								  Description:
								  <div class="form-group">  
								  <div class="input-group">
									<div class="input-group-addon"><span class="glyphicon glyphicon-align-left"></span></div>
									<textarea name="description" id="message_ok" class="form-control" rows="6" placeholder="Describe the book condition, what are you considering, desired location of meet, etc" required></textarea>
								  </div>
								</div>
								</div>
								<div class="row">
									Picture of the book:
									<div class="form-group">
										<input  name="picture" type="file" class="filestyle" data-buttonName="btn-primary" data-buttonBefore="true" data-input="true" multiple required>
									</div>
									
								</div>
								
								
								<div class="form-group">	
									<div class="checkbox">
										<label>
											<input name="remember" type="checkbox" value="remember-me" required> I agree
											by clicking <strong class="label label-primary">Post</strong> and you agree to the <a href="#" data-toggle="modal" data-target="#t_and_c_m">Terms and Conditions</a> set out by this site.
										</label>
									</div>
								</div>
								<br>
								
								
								<div class="row">
									<div class="col-xs-6 col-md-12"><input type="submit" value="Post"  name="register" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>
	
	

		
<?php
	include('footer.php');
?>

	
