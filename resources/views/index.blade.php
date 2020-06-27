<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
          content="">
    <meta name="author"
          content="">

    <title>Táborová hra</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
          crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.css"
          integrity="sha256-BbKecxrFo+Ecew/N4HhSlsVkNCvNiDHJySBsqWciTYg=" crossorigin="anonymous"/>

    <link rel="stylesheet" href="{{mix('css/app.css')}}">
</head>

<body>
<div class="container mt-5">
    <h1>Rozhraní LARP hry</h1>

    <div class="card mb-2">
        <div class="card-header">Přihlášení postavy</div>

        <div class="card-body">
            <table class="table">
                <th>Postava</th>
                <th>Jméno</th>
                <th>Přihlášení</th>
                @foreach($roles as $role)
                    <tr>
                        <td><a href="{{route('role.show', $role->id)}}">{{$role->name}}</a></td>

                        <td>{{$role->real_name}}</td>
                        <td><a href="{{route('role.show', $role->id)}}" class="btn btn-primary">Přihlásit</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

</body>
</html>
