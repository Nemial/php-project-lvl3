<!DOCTYPE html >
<html>
<head>

</head>
<body>
<h1>Name Site: {{ $domain->name }}</h1>
<table>
    <tr>
        <th>ID</th>
        <th>NAME</th>
        <th>UPDATED_AT</th>
        <th>CREATED_AT</th>
    </tr>
    <tr>
        <td>{{ $domain->id }}</td>
        <td>{{ $domain->name }}</td>
        <td>{{ $domain->updated_at }}</td>
        <td>{{ $domain->created_at }}</td>
    </tr>
</table>
</body>
</html>
