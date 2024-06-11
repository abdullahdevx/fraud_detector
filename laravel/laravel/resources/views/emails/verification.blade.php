<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
    <p>Hi {{$user->name}}</p><br>
    <p>Click on this link to verify your email address:</p><br>
    http://127.0.0.1:8000/verify-email/{{$user->verification_token}}

    <p> If you didnt request this. You don't need to do anything.</p><br>
</body>
</html>