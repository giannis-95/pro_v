<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ιστορικό Ανακοίνωσεων PDF</title>
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
    <h2>Ιστορικό Ανακοίνωσεων</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Τίτλος</th>
                <th>Καθηγητής</th>
                <th>Μάθημα</th>
                <th>Κατάσταση Ανακοίνωσης</th>
                <th>Ημερομηνία Δημιουργίας</th>
                <th>Ημερομηνία Ενημέρωσης</th>
            </tr>
        </thead>
        <tbody>
            @foreach($announcement_histories as $announcement_history)
                <tr>
                    <td>{{ $announcement_history->id }}</td>
                    <td>{{ $announcement_history->title }}</td>
                    <td>{{ $announcement_history->user }}</td>
                    <td>{{ $announcement_history->course }}</td>
                    <td>
                        @if($announcement_history->status == 'Ενεργή')
                            <span style="color: #00AA00">{{ $announcement_history->status }}</span>
                        @else
                            <span style="color: #FF0000">{{ $announcement_history->status }}</span>
                        @endif
                    </td>
                    <td>{{ $announcement_history->created_at->format('d/m/Y') }}</td>
                    <td>{{ $announcement_history->updated_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
