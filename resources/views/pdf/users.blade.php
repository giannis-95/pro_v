<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Χρήστες PDF</title>
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
    <h2>Λίστα Χρηστών</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Όνομα</th>
                <th>Email</th>
                <th>Ημερομηνία Εγγραφή</th>
                <th>Ημερομηνία Ενημέρωσης</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>{{ $user->updated_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
