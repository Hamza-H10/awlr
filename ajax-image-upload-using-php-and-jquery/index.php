<html>
<head>
<title>Ajax Image Upload Using PHP and jQuery</title>
<link rel="stylesheet" href="style.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/ajax-upload.js"></script>
</head>
<body>
    <div class="img-upload">
        <h1 style="text-align: center;">Ajax Image Upload</h1>
        <form class="frmUpload" action="" method="post">
            <label>Upload Image:</label>
            <input type="file" name="userImage" id="userImage" class="user-image" required />
            <input type="submit" value="UPLOAD" class="btn-upload" />        
        </form>
        <div class="img-preview"></div>
        <div class="upload-msg"></div>
    </div>
</body>
</html>