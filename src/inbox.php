<?php
	include('auth.php');
	include('header.php');
	include('library/force.php');
	
?>

<br/>
<br/>
<br/>
<link href="css/inbox.css" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-2">
            
        </div>
        <div class="col-sm-9 col-md-10">
            <button type="button" class="btn btn-default" data-toggle="tooltip" title="Refresh">
                &nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;&nbsp;</button>
            <!-- Single button -->
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    More <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Mark all as read</a></li>
                    <li class="divider"></li>
                    <li class="text-center"><small class="text-muted">Select messages to see more actions</small></li>
                </ul>
            </div>
			 &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
			<button type="button" class="btn btn-success messageSent" style="display:none">Your message has been sent</button>
            <div class="pull-right">
                <span class="text-muted"><b>1</b>–<b>50</b> of <b>160</b></span>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-default">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </button>
                    <button type="button" class="btn btn-default">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-3 col-md-2">
            <a href="#" class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#myModal" role="button"><i class="glyphicon glyphicon-edit"></i> Compose</a>
            <hr>
            <ul class="nav nav-pills nav-stacked">
                <!--<li class="active"><a href="#"><span class="badge pull-right">32</span> Inbox </a>-->
                </li>
            </ul>
        </div>
        <div class="col-sm-9 col-md-10">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-inbox">
                </span>Primary</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade in active" id="home">
                    <div class="list-group refreshThis">
					
						<?php
							
							$user = $_SESSION['username'];
							$sql = 'CALL getListOfMessages(:dce)';
							$stmt = $connection->prepare($sql);
							$stmt->bindParam(':dce',$user);
							$stmt->execute();
							
							$result = $stmt->fetchAll();
							$stmt->closeCursor();
							
							foreach($result as $row)
							{
								echo '
										<a data-toggle="modal" data-target="#readModal" class="list-group-item specificMessage" key='.$row['id'].'>
											<div class="checkbox">
												<label>
													<input type="checkbox">
												</label>
											</div>
											
											<span class="glyphicon glyphicon-star-empty"></span><span class="name" style="min-width: 120px;
												display: inline-block;">'.$row['sender_dce'].'</span> <span class="">'.$row['subject'].'</span>
											<span class="text-muted"  style="font-size: 11px;"></span> <span class="badge">'.$row['dateReceived'].'</span> <span class="pull-right"><span>
												</span></span>
										</a>';
							}
						?>
                        
								
                    </div>
                </div>
                
            </div>
			<!-- /.modal compose message -->
    <div class="modal fade" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Compose Message</h4>
          </div>
          <div class="modal-body">
            <form role="form" class="form-horizontal message">
                <div class="form-group">
                  <label class="col-sm-2" for="inputTo">To</label>
                  <div class="col-sm-10">
						<input type="email" class="form-control address" name="to" id="inputTo" placeholder="dce">
						<div id="result"></div>
				  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2" for="inputSubject">Subject</label>
                  <div class="col-sm-10"><input type="text" class="form-control" id="inputSubject" name="subject" placeholder="subject"></div>
                </div>
                <div class="form-group">
                  <label class="col-sm-12" for="inputBody">Message</label>
                  <div class="col-sm-12"><textarea class="form-control" id="inputBody" name="message" rows="18"></textarea></div>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button> 
            <button type="button" class="btn btn-primary " id="submit">Send <i class="fa fa-arrow-circle-right fa-lg"></i></button>
            
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal compose message -->
	
	<!--read inbox modal-->
				<!-- /.modal compose message -->
    <div class="modal fade" id="readModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Reading Message</h4>
          </div>
          <div class="modal-body">
            <form role="form" class="form-horizontal message">
                <div class="form-group">
                  <label class="col-sm-2" for="inputTo">Sender</label>
                  <div class="col-sm-10">
						<input type="email" class="form-control receiveSender"   id="inputTo" placeholder="dce" readonly>
				  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2" for="inputSubject">Subject</label>
                  <div class="col-sm-10"><input type="text" class="form-control receiveSubject" id="inputSubject"  placeholder="subject" readonly></div>
                </div>
                <div class="form-group">
                  <label class="col-sm-12" for="inputBody">Message</label>
                  <div class="col-sm-12"><textarea class="form-control receiveMessage" id="inputBody"  rows="18" readonly></textarea></div>
                </div>
            </form>
          </div>
          <div class="modal-footer" style="text-align:center">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close Message</button> 
            
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal compose message -->

        </div>
    </div>
</div>
<br/>
<br/>

<?php include('footer.php');?>

<script>
	$('.specificMessage').click(function()
	{
		var key = $(this).attr('key');
		
		//get the message result via ajax
		$.ajax({
			  url: 'getMessage.php',
			  type: 'GET',
			  data: 'key='+key,
			  success: function(data) {
				//alert(data);
				var obj = $.parseJSON(data);
				var sender = obj.sender_dce;
				var subject = obj.subject;
				var message = obj.message;
				
				
				$('.receiveSender').val(sender);
				$('.receiveSubject').val(subject);
				$('.receiveMessage').val(message);
				//alert(data);
			  },
			  error: function(e) {
				//called when there is an error
				//console.log(e.message);
			  }
			});
	});
</script>

<script>
	$(function()
	{
		$('.address').keyup(function()
		{
			var searchData = $(this).val();
			var dataString = 'search='+searchData;
			
			if(searchData!="")
			{
				$.ajax({
					type:"POST",
					url:"emailFinder.php",
					data:dataString,
					cache:false,
					success: function(data)
					{
						$('#result').html(data).show();
					}
				});//end of ajax
			}
			return false;
		});
	});
	
	$('#result').click(function(e)
	{
		var $clicked = $(e.target);
		var $name = $clicked.find('.email').html();
		var decoded = $("<div/>").html($name).text();
		$('.address').val(decoded);
		
		if (! $clicked.hasClass("search")){
				$("#result").fadeOut(); 
			}
	});
</script>

<script>
//function to count down 5 second few seconds before make the message disappear
	function countDown(){
			var counter = 5;
			setInterval(function(){
				counter--;
				if(counter==0){
					$('.messageSent').fadeOut();
				}
			},1000);
		}
//code for submitting the form
	$('button#submit').click(function()
	{
		$.ajax({
			type:"POST",
			url:"sendMessage.php",
			data:$('form.message').serialize(),
			success:function(msg)
			{
				$('#myModal').modal('hide');
				$('.refreshThis').load( "inbox.php .refreshThis" );
				$('.messageSent').show();
				countDown();
			}
		});
		//alert('hello');
	});

</script>
