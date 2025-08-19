<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buggy To‑Do</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/css/custom.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="{{ route('tasks.index') }}">Buggy To‑Do</a>
    <form class="d-flex" role="search" action="{{ route('tasks.search') }}" method="GET">
      <input class="form-control me-2" type="search" placeholder="Search" name="q" value="{{ request('q') }}">
      <button class="btn btn-outline-light" type="submit">Search</button>
    </form>
  </div>
</nav>
<div class="container">
  @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
