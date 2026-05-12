<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ανακοίνωσεις PDF</title>
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
    <h2>Λίστα Ανακοίνωσεων</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Τίτλος</th>
                <th>Καθηγητής</th>
                <th>Μάθημα</th>
                <th>Ημερομηνία Δημιουργίας</th>
                <th>Ημερομηνία Ενημέρωσης</th>
            </tr>
        </thead>
        <tbody>
            @foreach($announcements as $announcement)
                <tr>
                    <td>{{ $announcement->id }}</td>
                    <td>{{ $announcement->title }}</td>
                    <td>{{ $announcement->user->name }}</td>
                    <td>{{ $announcement->course->title }}</td>
                    <td>{{ $announcement->created_at->format('d/m/Y') }}</td>
                    <td>{{ $announcement->updated_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
