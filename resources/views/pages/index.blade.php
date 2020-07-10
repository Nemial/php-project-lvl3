<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>
<body>
<table class="table">
    <tr>
        <th>ID</th>
        <th>Name</th>
    </tr>
    @foreach($domains as $domain)
        <tr>
            <td> {{ $domain->id }}</td>
            <td><a href="{{ url("/pages/$domain->id") }}">{{ $domain->name }}</a></td>
        </tr>
    @endforeach
</table>
</body>
</html>
