<?php
    include "../config.php";
	function Content(){
            $user = unserialize($_SESSION['user']);
            echo '<div id="content">'.$user->showAllBooks().'</div>';  
        }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo backToFuture() ?>Library/Layout/layout.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js" type="text/javascript"></script>
		<title>Biblioteka PAI</title>
                
                <script type="text/javascript">
                $(document).ready(function(){
                    $("#id").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var isbn = $("#isbn").val();
                        if(isbn == "") isbn = "%";
                        var title = $("#title").val();
                        if(title == "") title = "%";
                        var authors = $("#authors").val();
                        if(authors == "") authors = "%";
                        var publHou = $("#publisher_house").val();
                        if(publHou == "") publHou = "%";
                        var nrPa = $("#number_page").val();
                        if(nrPa == "") nrPa = "%";
                        var edition = $("#edition").val();
                        if(edition == "") edition = "%";
                        var premiere = $("#premiere").val();
                        if(premiere == "") premiere = "%";
                        var number = $("#number").val();
                        if(number == "") number = "%";
                        $("#booksTable").load("../ajax.php", 
                        {book:1, ID: id, ISBN : isbn, T: title, A: authors, PH: publHou, NP:nrPa, E:edition, P:premiere, N:number},
                        function(responseTxt,statusTxt,xhr){});
                    });
                    $("#isbn").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var isbn = $("#isbn").val();
                        if(isbn == "") isbn = "%";
                        var title = $("#title").val();
                        if(title == "") title = "%";
                        var authors = $("#authors").val();
                        if(authors == "") authors = "%";
                        var publHou = $("#publisher_house").val();
                        if(publHou == "") publHou = "%";
                        var nrPa = $("#number_page").val();
                        if(nrPa == "") nrPa = "%";
                        var edition = $("#edition").val();
                        if(edition == "") edition = "%";
                        var premiere = $("#premiere").val();
                        if(premiere == "") premiere = "%";
                        var number = $("#number").val();
                        if(number == "") number = "%";
                        $("#booksTable").load("../ajax.php", 
                        {book:1, ID: id, ISBN : isbn, T: title, A: authors, PH: publHou, NP:nrPa, E:edition, P:premiere, N:number},
                        function(responseTxt,statusTxt,xhr){});
                    });
                    $("#title").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var isbn = $("#isbn").val();
                        if(isbn == "") isbn = "%";
                        var title = $("#title").val();
                        if(title == "") title = "%";
                        var authors = $("#authors").val();
                        if(authors == "") authors = "%";
                        var publHou = $("#publisher_house").val();
                        if(publHou == "") publHou = "%";
                        var nrPa = $("#number_page").val();
                        if(nrPa == "") nrPa = "%";
                        var edition = $("#edition").val();
                        if(edition == "") edition = "%";
                        var premiere = $("#premiere").val();
                        if(premiere == "") premiere = "%";
                        var number = $("#number").val();
                        if(number == "") number = "%";
                        $("#booksTable").load("../ajax.php", 
                        {book:1, ID: id, ISBN : isbn, T: title, A: authors, PH: publHou, NP:nrPa, E:edition, P:premiere, N:number},
                        function(responseTxt,statusTxt,xhr){});
                    });
                    $("#authors").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var isbn = $("#isbn").val();
                        if(isbn == "") isbn = "%";
                        var title = $("#title").val();
                        if(title == "") title = "%";
                        var authors = $("#authors").val();
                        if(authors == "") authors = "%";
                        var publHou = $("#publisher_house").val();
                        if(publHou == "") publHou = "%";
                        var nrPa = $("#number_page").val();
                        if(nrPa == "") nrPa = "%";
                        var edition = $("#edition").val();
                        if(edition == "") edition = "%";
                        var premiere = $("#premiere").val();
                        if(premiere == "") premiere = "%";
                        var number = $("#number").val();
                        if(number == "") number = "%";
                        $("#booksTable").load("../ajax.php", 
                        {book:1, ID: id, ISBN : isbn, T: title, A: authors, PH: publHou, NP:nrPa, E:edition, P:premiere, N:number},
                        function(responseTxt,statusTxt,xhr){});
                    });
                    $("#publisher_house").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var isbn = $("#isbn").val();
                        if(isbn == "") isbn = "%";
                        var title = $("#title").val();
                        if(title == "") title = "%";
                        var authors = $("#authors").val();
                        if(authors == "") authors = "%";
                        var publHou = $("#publisher_house").val();
                        if(publHou == "") publHou = "%";
                        var nrPa = $("#number_page").val();
                        if(nrPa == "") nrPa = "%";
                        var edition = $("#edition").val();
                        if(edition == "") edition = "%";
                        var premiere = $("#premiere").val();
                        if(premiere == "") premiere = "%";
                        var number = $("#number").val();
                        if(number == "") number = "%";
                        $("#booksTable").load("../ajax.php", 
                        {book:1, ID: id, ISBN : isbn, T: title, A: authors, PH: publHou, NP:nrPa, E:edition, P:premiere, N:number},
                        function(responseTxt,statusTxt,xhr){});
                    });
                    $("#number_page").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var isbn = $("#isbn").val();
                        if(isbn == "") isbn = "%";
                        var title = $("#title").val();
                        if(title == "") title = "%";
                        var authors = $("#authors").val();
                        if(authors == "") authors = "%";
                        var publHou = $("#publisher_house").val();
                        if(publHou == "") publHou = "%";
                        var nrPa = $("#number_page").val();
                        if(nrPa == "") nrPa = "%";
                        var edition = $("#edition").val();
                        if(edition == "") edition = "%";
                        var premiere = $("#premiere").val();
                        if(premiere == "") premiere = "%";
                        var number = $("#number").val();
                        if(number == "") number = "%";
                        $("#booksTable").load("../ajax.php", 
                        {book:1, ID: id, ISBN : isbn, T: title, A: authors, PH: publHou, NP:nrPa, E:edition, P:premiere, N:number},
                        function(responseTxt,statusTxt,xhr){});
                    });
                    $("#edition").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var isbn = $("#isbn").val();
                        if(isbn == "") isbn = "%";
                        var title = $("#title").val();
                        if(title == "") title = "%";
                        var authors = $("#authors").val();
                        if(authors == "") authors = "%";
                        var publHou = $("#publisher_house").val();
                        if(publHou == "") publHou = "%";
                        var nrPa = $("#number_page").val();
                        if(nrPa == "") nrPa = "%";
                        var edition = $("#edition").val();
                        if(edition == "") edition = "%";
                        var premiere = $("#premiere").val();
                        if(premiere == "") premiere = "%";
                        var number = $("#number").val();
                        if(number == "") number = "%";
                        $("#booksTable").load("../ajax.php", 
                        {book:1, ID: id, ISBN : isbn, T: title, A: authors, PH: publHou, NP:nrPa, E:edition, P:premiere, N:number},
                        function(responseTxt,statusTxt,xhr){});
                    });
                    $("#premiere").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var isbn = $("#isbn").val();
                        if(isbn == "") isbn = "%";
                        var title = $("#title").val();
                        if(title == "") title = "%";
                        var authors = $("#authors").val();
                        if(authors == "") authors = "%";
                        var publHou = $("#publisher_house").val();
                        if(publHou == "") publHou = "%";
                        var nrPa = $("#number_page").val();
                        if(nrPa == "") nrPa = "%";
                        var edition = $("#edition").val();
                        if(edition == "") edition = "%";
                        var premiere = $("#premiere").val();
                        if(premiere == "") premiere = "%";
                        var number = $("#number").val();
                        if(number == "") number = "%";
                        $("#booksTable").load("../ajax.php", 
                        {book:1, ID: id, ISBN : isbn, T: title, A: authors, PH: publHou, NP:nrPa, E:edition, P:premiere, N:number},
                        function(responseTxt,statusTxt,xhr){});
                    });
                    $("#number").change(function(){
                        var id = $("#id").val();
                        if(id == "") id = "%";
                        var isbn = $("#isbn").val();
                        if(isbn == "") isbn = "%";
                        var title = $("#title").val();
                        if(title == "") title = "%";
                        var authors = $("#authors").val();
                        if(authors == "") authors = "%";
                        var publHou = $("#publisher_house").val();
                        if(publHou == "") publHou = "%";
                        var nrPa = $("#number_page").val();
                        if(nrPa == "") nrPa = "%";
                        var edition = $("#edition").val();
                        if(edition == "") edition = "%";
                        var premiere = $("#premiere").val();
                        if(premiere == "") premiere = "%";
                        var number = $("#number").val();
                        if(number == "") number = "%";
                        $("#booksTable").load("../ajax.php", 
                        {book:1, ID: id, ISBN : isbn, T: title, A: authors, PH: publHou, NP:nrPa, E:edition, P:premiere, N:number},
                        function(responseTxt,statusTxt,xhr){});
                    });
		});
                </script>
                
	</head>
	<body>
		<?php
			Logo();
			Menu();
			Canvas();
		?>
	</body>
</html>