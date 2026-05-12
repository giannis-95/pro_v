<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ιστορικό Μαθημάτων PDF</title>
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
    <h2>Λίστα Ιστορικό Μαθημάτων</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Τίτλος</th>
                <th>Κατάσταση Μαθήματος</th>
                <th>Ημερομηνία Δημιουργίας</th>
                <th>Ημερομηνία Επεξεργασίας</th>
            </tr>
        </thead>
        <tbody>
            @foreach($course_histories as $course_history)
                <tr>
                    <td>{{ $course_history->id }}</td>
                    <td>{{ $course_history->title }}</td>
                    <td>
                        @if($course_history->status == 'Ενεργό')
                            <span style="color: #00AA00;">{{ $course_history->status }}</span>
                        @elseif($course_history->status == 'Μη Ενεργό')
                            <span style="color: #0dcaf0;">{{ $course_history->status }}</span>
                        @else
                            <span style="color: #FF0000;">{{ $course_history->status }}</span>
                        @endif
                    </td>
                    <td>{{ $course_history->created_at->format('d/m/Y') }}</td>
                    <td>{{ $course_history->updated_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
