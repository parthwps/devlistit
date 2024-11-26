



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .container {
            text-align: center;
            padding: 2rem;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .mainLogo img {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        .title {
            font-weight: 500;
            font-size: 1.3rem;
        }
        .instruction {
            margin-top: 2rem;
            color: gray;
        }
    </style>
</head>
<body>

<center style="background: white;padding: 2rem;border-radius: 10px;box-shadow: 0px 0px 10px #e2e2e2;">
    
     @if (!empty($websiteInfo->logo))
          <a href="{{ route('index') }}" class="navbar-brand mainLogo">
            <img src="{{ asset('assets/img/' . $websiteInfo->logo) }}" alt="logo"  style="margin-top: 2rem;margin-bottom: 2rem;width:200px"> 
           
          </a>
        @endif
        <br>
        <strong style="font-family: sans-serif;font-weight: 500;font-size: 1.3rem;" >Password Reset Request</strong>
        <br>
        <p style="font-family: sans-serif;margin-top: 2rem;color: gray;">
            Reset password instruction has been sent to <span style="color:#439ae4;">{{$email}}</span>, Please follow steps in the instruction in email to reset your password.
        </p>
</center>

</body>
</html>
