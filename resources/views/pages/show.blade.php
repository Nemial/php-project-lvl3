<!DOCTYPE html >
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>
<body>
<h1>Name Site: {{ $domain->name }}</h1>
<table class="table">
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
