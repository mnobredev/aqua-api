<!doctype html>
<html>
  <head>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="libs/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="libs/font-awesome-4.7.0/css/font-awesome.min.css">
    <title>JSON Testing Application</title>
  </head>
  <body>
    <nav class="navbar navbar-default">
      <a class="navbar-brand" href="#">API Tester</a>
    </nav>
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">What is this?</div>
        <div class="panel-body">
          <p>Sometimes it seems easier to make your own solution than to use other tools that you don't know where your data is going.</p>
          <p>This was one of those times, got pretty tired of trying to use other solutions to test my API's so I decided to grab some code that a guy got me to test one of my projects and adapted it to a solution within my needs.</p>
          <p>As the name indicates this application is testing JSON POST requests at the moment, as it is early development I do intend to offer other request compability.</p>
          <p>Want to know more about me? Check me out!</p>
          <p><i class="fa fa-github" aria-hidden="true"></i> GitHub</p>
          <p><i class="fa-linkedin-square" aria-hidden="true"></i> LinkedIn</p>
          <p><i class="fa-facebook-official" aria-hidden="true"></i> Facebook</p>
          <p><i class="fa-home" aria-hidden="true"></i> WebSite</p>
        </div>
      </div>  
    </div>
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">Send a request</div>
        <div class="panel-body">
          <input id="url" class="form-control" placeholder="URL"><br>
          <div id=args class="form-horizontal"></div>
          <button id="add" class="btn btn-success">Add argument</button>
          <button id="submit" class="btn btn-default">Send Request</button><br>
        </div>
      </div>  
    </div>
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">Get an answer</div>
        <div class="panel-body">
          <div id="results"></div>
        </div>
      </div>  
    </div>
    
    <script>
      $(document).ready(function(){
        $("#add").click(function(){
          $("#args").append('<div class="col-md-12 form-group"><div class="col-md-4"><input type="text" class="arg form-control"></div><div class="col-md-4"><input type="text" class="val form-control"></div><div class="col-md-4"><button class="remove btn btn-danger">Remove this argument</button></div></div>');
        });
        $("#args").on("click", ".remove", function() {
          $(this).parent().parent().remove();
        });
        $("#submit").click(function(){
          var package = {};
          $("#args").children("div").each(function() {
            package[$(this).children().children(".arg").val()] = $(this).children().children(".val").val();
          });
          $.ajax({
            type: "POST",
            url:  $("#url").val(),
            data: JSON.stringify(package),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data){$("#results").text(data);},
            failure: function(errMsg) {
              console.log(errMsg);
            }
          });
        });
      });
    </script>
  </body>
</html>