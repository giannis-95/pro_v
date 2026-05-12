<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ιστορικό Χρηστών PDF</title>
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
    <h2>Λίστα Ιστορικό Χρηστών</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Όνομα</th>
                <th>Email</th>
                <th>Ρόλος</th>
                <th>Κατάσταση</th>
                <th>Ημερομηνία Δημιουργίας</th>
                <th>Ημερομηνία Ενημέρωσης</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user_histories as $user_history)
                <tr>
                    <td>{{ $user_history->id }}</td>
                    <td>{{ $user_history->name }}</td>
                    <td>{{ $user_history->email }}</td>
                    <td>{{ $user_history->role }}</td>
                    <td>
                        @if($user_history->status == 'Ενεργός')
                            <span style="color: #00AA00">{{ $user_history->status }}</span>
                        @elseif($user_history->status == 'Διεγεγραμένος')
                             <span style="color: #FF0000">{{ $user_history->status }}</span>
                        @else
                            <span style="color: #0dcaf0">{{ $user_history->status }}</span>
                        @endif
                    </td>
                    <td>{{ $user_history->created_at->format('d/m/Y') }}</td>
                    <td>{{ $user_history->updated_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
