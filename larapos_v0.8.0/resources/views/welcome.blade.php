<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Modern Point of Sale Solution</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Mukta:200,600" rel="stylesheet" type="text/css">
  <style>
    html,
    body {
      margin: 0;
      height: 100vh;
      color: #636b6f;
      font-weight: 200;
      background-color: #fff;
      font-family: 'Mukta', sans-serif;
    }

    .full-height {
      height: 100vh;
    }

    .flex-center {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .content {
      margin: auto;
      text-align: center;
    }

    .title {
      font-size: 84px;
      margin-top: 24px;
      line-height: 42px;
      margin-bottom: 24px;
    }

    .title.message {
      color: #333;
      font-size: 16px;
      padding: 2px 16px;
      border-radius: 5px;
      font-weight: normal;
      background: #f5f6f7;
      font-family: 'Courier New', Courier, monospace;
    }

    .title.small {
      color: #aababa;
      font-size: 24px;
    }

    .by {
      padding: 24px;
      color: #aababa;
      font-size: 18px;
    }

    .links>a {
      color: #636b6f;
      padding: 0 24px;
      font-size: 15px;
      font-weight: 600;
      letter-spacing: .1rem;
      text-decoration: none;
      text-transform: uppercase;
    }

    .m-b-md {
      margin-bottom: 30px;
    }

  </style>
</head>

<body>
  <div class="flex-center full-height">
    <div class="content">
      <div class="title m-b-md">
        {{ demo() ? 'MPS' : mps_config('short_name') }}
      </div>
      <div class="title small">
        {{ demo() ? 'Modern Point of Sale Solution' : mps_config('name') }}
      </div>

      @if (session('message'))
        <div class="title message">
          {{ session('message') }}
        </div>
      @else
        <div class="links">
          <a href="https://mps.tecdiary.net">Demo</a>
          <a href="https://tecdiary.github.io/mps-guide/">Documentation</a>
          <a href="https://tecdiary.net/products/modern-point-of-sale-solution">Buy Now</a>
        </div>
        <div class="by">
          by <strong>Tecdiary</strong>
        </div>
      @endif
    </div>
  </div>
</body>

</html>
