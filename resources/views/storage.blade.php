<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Содержимое storage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background-color: #f5f5f5;
        }

        a {
            color: #2a6496;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .nav-path {
            margin-bottom: 12px;
        }
    </style>
</head>

<body>
    <h1>Содержимое папки: /storage/{{ $currentPath }}</h1>

    @php
        // Формируем хлебные крошки для текущего пути
        $segments = $currentPath ? explode('/', $currentPath) : [];
        $breadcrumbs = [];
        $accumPath = '';
    @endphp

    <div class="nav-path">
        <a href="{{ route('storage') }}">Корень</a>
        @foreach ($segments as $segment)
            @php $accumPath .= ($accumPath ? '/' : '') . $segment; @endphp
            &nbsp; / &nbsp;
            <a href="{{ route('storage', ['path' => $accumPath]) }}">{{ $segment }}</a>
        @endforeach
    </div>


    <table>
        <thead>
            <tr>
                <th>Имя</th>
                <th>Тип</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($directories as $dir)
                @php
                    $name = basename($dir);
                @endphp
                <tr>
                    <td>
                        <a href="{{ route('storage', ['path' => $dir]) }}">{{ $name }}/</a>
                    </td>
                    <td>Папка</td>
                </tr>
            @endforeach

            @foreach ($files as $file)
                @php
                    $name = basename($file);
                @endphp
                <tr>
                    <td>{{ $name }}</td>
                    <td>Файл</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
