<html>
  <head>
    <title><?=$this->e($title)?></title>
  </head>
  <body>
  	<nav>
  		<ul>
  			<li><a href="/">Homepage</a></li>
  			<li><a href="/about">About</a></li>
  		</ul>
  	</nav>
    <?=$this->section('content')?>
  </body>
</html>
