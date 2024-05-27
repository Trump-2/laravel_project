<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <h1>Hello, this is a blade template.</h1>

  {{-- {{ }} ：作一些動態的事情 --}}
  <p>A great number is {{2+5}}</p>
  <p>The current year is {{date('Y')}}</p>

  {{-- 使用從 controller 傳過來的參數 --}}
<h3>{{$name}}</h3>

<ul>

  {{-- blade 的特色之一 --}}
  @foreach($allAnimals as $animal)
  <li>{{$animal}}</li>
  @endforeach
</ul>

  <a href="/about">View the about page</a>
</body>
</html>