<!DOCTYPE html>
<html>

<body>
    <h3>Welcome to ElectionSystem</h3>
    <p>
        Thank you for registration in Election System apllication.<br>
        This email contain the registration information which you see in follow.
    </p>
    <h5>email: {{$user['email']}}</h5>
    <h5>UserName: {{$user['username']}}</h5>

    <p>
        for complete registration please click on the button link below.
        or copy the link in your web browser.
    </p>
    <button onclick="{{$url}}">Email Verification</button><br>
    <a href={{$url}}>{{$url}}</a>

    <p>
        if this email not related to you, dont need any actions.
    </p>

    <h6>Thank you. Online Electin System</h6>

    
</body>

</html>