<!DOCTYPE html>
<html lang="en">
<table>
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

</html>
