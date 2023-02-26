
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('Admin/assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('Admin/assets/css/atlantis.min.css') }}">
</head>
<body>
    <table style="border:1px;">
        <thead>
        <tr>
            @foreach($data[0] as $key => $value)
            <th><b>{{ ucfirst($key) }}</b></th>
            @endforeach
            </tr>
        </thead>
        <tbody>
        @foreach($data as $row)
            <tr>
            @foreach ($row as $value)
                <td>{{ $value }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">Total</td>
            <td>$22</td>
            <td>$22</td>
            <td>$22</td>
          </tr>
    </tfoot>
    </table>
</body>
</html>