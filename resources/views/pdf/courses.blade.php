<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Μαθήματα PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background: #eee;
        }
    </style>
</head>
<body>
    <h2>Λίστα Μαθημάτων</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Τίτλος</th>
                <th>Περιγραφή</th>
                <th>Ημερομηνία Δημιουργίας</th>
                <th>Ημερομηνία Ενημέρωσης</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->description }}</td>
                    <td>{{ $course->created_at->format('d/m/Y') }}</td>
                    <td>{{ $course->updated_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
