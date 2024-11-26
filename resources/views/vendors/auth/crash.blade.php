<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/' . $websiteInfo->favicon) }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/img/' . $websiteInfo->favicon) }}">
  
    <title>Basic Page with Navigation</title>
    <style>
        body
        {
          padding:2rem;
            margin: 0;
            background: #f1f1f1;
        }
        /* Basic styling for the navbar */
        .navbar {
            margin-bottom:1rem;
            background-color: #f1f1f1;
            overflow: hidden;
            color: white;
            padding: 10px 0px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: inline-block;
        }
        .logo {
            text-align:center;
            height: 40px;
        }
        /* Clear floats */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .us_p
        {
            font-size: 17px;
            width: 100%;
            line-height: 20px;
            margin-top: 10px;
        }
        .custom_btn
        {
            display: inline-block;
               width: 340px;
            background: #1b87f4;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
        }
        
        @media screen and (max-width: 450px) {
 .custom_btn {
         width: 265px !important;
  }
}
  
    </style>
</head>
<body>
    <div class="navbar clearfix">
       <a href="{{url('/')}}">
            <img src="{{ asset('assets/img/' . $websiteInfo->logo) }}" class="logo">
       </a>
    </div>

    <div style="    font-family: sans-serif;">
        <b style="font-size: 20px;">Opss! Something went wrong.</b>
        <p class="us_p">Account is disabled, contact your administration.</p>
        
        <a class="custom_btn" href="mailto:support@listit.im">Continue </a>
    </div>
</body>
</html>
