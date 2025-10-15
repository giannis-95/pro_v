<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $message['title'] }}</title>
    <style>
        p,h1,a {
            text-align: center;
        }
    </style>
</head>
<body>
    <div style="padding: 0; margin:auto;">
        <h1>{{ $message['title'] }}</h1>
        <p>{{ $message['body'] }}</p>
        <div>
            <p>Αν θέλετε <strong>να διαγραφείτε από το μάθημα {{ $course->title }}</strong> πατήστε το παρακάτω κουμπί</p>
        </div>
        <a href="{{ route('course.unregistration_course_email',$course->id) }}" style="display: inline-block; padding: 0.375rem 0.75rem; font-size: 1rem; font-weight: 400; color: #fff; background-color: #dc3545; border-radius: 0.25rem; text-decoration: none;">Απεγραφή</a>
    </div>
</body>
</html>
