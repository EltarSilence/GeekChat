# Zexarel
My personal PHP Framework

# Installation & Usage
To use this Framework you need download the code and put the Zexarel folder in your project, then create the .htaccess file and the .zenv file, in Zexarel folder there is an example
Remember: In .htaccess file you could change the RewriteBasec option

# Content
Content:
  - Functions
    - [find](#find)
    - [get_string_between](#get_string_between)
    - [redirect](#redirect)
    - [d_var_dump](#d_var_dump)
  - Classes
    - [ZConfig](#ZConfig)
    - [ZDatabase](#ZDatabase)
    - [ZRoute](#ZRoute)
    - [ZView](#ZView)
    - [ZModel](#ZModel)
    - [ZLogger](#ZLogger)
## find
```php
function find(string $what, string $in) : int
```
This function searches a string inside another string, it returns -1 if the string is not found, else it returns the position (0 is the first char)
## get_string_between
```php
function get_string_between(string $str, string $from, string $to) : string
```
This function returns the string between two selected strings
## redirect
```php
function redirect(string $location) : void
```
Returns an HTTP header that redirects to the location
## d_var_dump
```php
function d_var_dump(mixed $obj, int $size = null) : void
```
This function prints the obj content, you can choose the size (default 17px)
Find more info [here](https://github.com/Zexal0807/d_var_dump).

## ZConfig
This class manages the application config, to use this class you need to have a .zenv file where configs are saved.
In your application, when you want to get a config, you can call statically the config method, passing the config's key and the optional default value
```php
ZConfig::config("APP_NAME", "Zexarel");
```
## ZDatabase
This class manages the database, to use this class you must set the connection parameters in .zenv file, you then create a new class that extends ZDatabase and overrides the beforeExecute and afterExecute method:
```php
class My_Database extends ZDatabase{
  protected function beforeExecute($sql){
    //you can use a logger
  }
  protected function afterExecute($sql, $result, $rowAffected){
    //you can use a logger
  }
}
```
To create a SQL query you must create a new object, and apply the method on it:
```php
$db = new ZDatabase();
$ret = $db->select("*")
  ->from("users")
  ->where("id", "=", 1)
  ->execute();
  //Now $ret contains all field of table users where id = 1
```
Here there are all the possible methods:
```php
public function select(...$fields)
public function selectAll()
public function selectDistinct(... $fields)
public function from($table){
public function where($field, $operator, $compare)
public function groupBy($field)
public function having($field, $operator, $compare)
public function orderBy($field)
public function innerJoin($table, $on, $operator, $compare)
public function leftJoin($table, $on, $operator, $compare)
public function rightJoin($table, $on, $operator, $compare)
public function insert($table, ... $field_list)
public function value(... $value_list)
public function update($table)
public function set($field, $value)
public function getSQL() : string         //return the SQL string
public function execute() : void          //execute
public function executeSql($sql) : void   //execute a specific SQL
```
## ZRoute
This class manages the S.P.A. Route, to use this class you need add the route calling the static methods (get, post, put, head, delete) passing the following parameters in the index.php file, and call the listen method at the end.
```php
public static function $method(string $route, callable $callback, string $name = null) : void
```
And
Here an example
```php
ZRoute::get("/home", function (){
  echo "This is my homepage"
}, "home");

ZRoute::listen();
```
If the name is set, you can call the method getUri padding the name, and you get the correct route
```php
ZRoute::getUri("home");
```

## ZView
This class manages the application views, to use this class you need create a new class that extends ZView and overides  dir (directory of view) and app(name of the application file)
```php
class View extends ZView{
  protected static $dir = 'view/';
  protected static $app = 'app.html';
}
```
To visualized a view you must call the static method getView, passing the name of the view(without .html), the base(transform, the number of "/" in route in "../")
  [
    "/home"           =>    ""
    "/utente/1225"    =>    "../"
    "/utente/it/1225" =>    "../../"
  ]
and the eventual parameter as associative array
In your app must exist the @include, so this class read a view in directory and replace @include with its content, and must exist the @base inside a head, here an example
```php
$title = "My app";
View::getView("home", '', ["title" => $title]);
```
```html
//app.html
<html>
  <head>
    @base
    <title>{{ $title }}</title>
  </head>
  <body>
    <nav>This is my menu</nav>
    @include('content')
  </body>
</html>
```
```html
//home.html
<div>
  That will be include
</div>
```
```html
//result
<html>
  <head>
    <base href="">
    <title>My app</title>
  </head>
  <body>
    <nav>This is my menu</nav>
    <div>
      That will be include
    </div>
  </body>
</html>
```

In view you can use the blade instruction:
```txt
@if($i < 0)
@elseif($i < 0)
@else
@endif
@for($i = 0; $i < sizeof($c); $i++)
@endfor
@foreach($a as $k => $v)
@endoforeach
@while($i < sizeof($c))
@endwhile
@dowhile
@enddowhile($i < sizeof($c))
```

## ZModel
This class manages the model, a model is a part of HTML file, it use the blade instruction.
To use this you need create a html model and a PHP class that extends ZModel choosing the directory and the name of the html model (without .html)
```php
//message.php
class Message extends ZModel{
  protected $dir = "model/";
  protected $name = 'message';
}
```
```html
//message.html
<div>
  <font>{{ $this->sender}}</font>
  <p>
  {{ $this->body }}
  </p>
</div>
```
When you create a new object in constructor you pass the data, and call the method getHtml
```php
$m = new Message(["sender" => "Zexal0807", "body" => "This is the body of the message"]);
echo $m->getHtml();
```
```html
//result
<div>
  <font>Zexal0807</font>
  <p>
  This is the body of the message
  </p>
</div>
```
## ZLogger
This class manages the log, to use this class you need create object and call on it the method.
```php
$l = new ZLogger();
$l->debug("prova", ["yellow", "red", ["yellow", "red", "green"]])

```
And, here log content
```txt
[2019-04-01 13:09:48][DEBUG] : prova
	Array(3) {
		[0] => String : "yellow"
		[1] => String : "red"
		[2] => Array(3) {
			[0] => String : "yellow"
			[1] => String : "red"
			[2] => String : "green"
		}
	}
```
