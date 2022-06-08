<!DOCTYPE html>
<html>

<head>
    <title>{{ $setting->site_name }}</title>
</head>

<body>
    <h1>Kiriman pesan dari {{ $email }}</h1>
    <p>{{ $subject }}</p>

    <p>{{ $message }}</p>

    <p>Thank you</p>
</body>

</html>
