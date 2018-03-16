<?php

/* -------------------
    Magic methods
 ------------------- */

class Method_Testing
{
    public $data = array();
    public $arg1;
    public $arg2;

    public function __construct()
    {
        echo "1. Constructor method <br /> Classes which have a constructor method call this method on each newly-created object.<br /><br />";
    }

    public function __destruct()
    {
        echo "<br /><br />15. Destruct method <br /> The destructor method will be called as soon as there are no other references to a particular object.";
    }

    public function  __get($name)
    {
        if(array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        return null;
    }

    public function __set($key, $value) 
    {
        $this->data[$key] = $value;
    }

    public function  __isset($name)
    {
        return array_key_exists($name, $this->data);
    }
    public function  __unset($name)
    {
        unset($this->data[$name]);
    }

    public function __call($func, $args) 
    {
        echo "6. {$func} with argument " . implode(", ", $args);
    }

    public static function __callStatic($func, $args)
    {
        echo "7. Static {$func} with argument " . implode(", ", $args);
    }

    public function __invoke() 
    {
        echo "<br />8. The __invoke() method is called when a script tries to call an object as a function.<br /><br />";
    }

    public function __toString() 
    {
        return "9. The __toString() method allows a class to decide how it will react when it is treated like a string.<br /><br />";
    }

    public function __debugInfo() 
    {
        return 
        [
            "<br />10. DebugInfo method <br />This method is called by var_dump() when dumping an object to get the properties that should be shown."
        ];
    }

    public function  __sleep() {
        return array("data");
    }
    public function  __wakeup() {
        echo "Wakeup method";
    }
}

// Init
$methods = new Method_Testing;

// Get & Set
echo "2. ir 3. Get & Set";
echo "<br />";
$methods->user = 'Steve';
$methods->surename = 'Green';
print_r($methods->data);
echo "<br />";

// Isset & unset
echo "4. Isset";
echo "<br />";
echo "Is user is set: ";
var_dump(isset($methods->user));
echo "<br />";
echo "5. Unset";
echo "<br />";
echo "Is user is set: ";
unset($methods->user);

var_dump(isset($methods->user));

// Call & callstatic methods
echo "<br /><br />";
echo "Call & callstatic methods";
echo "<br />";
$methods->runTest('Delete');
echo "<br/> ";
$methods::getName("Create");

// Invoke method
echo "<br /><br />";
echo "Invoke methods";
$methods();

echo "toString methods";
echo "<br />";
echo $methods;

// DebugInfo
var_dump($methods);
echo "<br /><br />";

echo "11. ir 12. Sleep $ wakeup";
echo "<br />";
class demoSleepWakeup {
    public $array;
    public function __construct() {
        $this->array = array(1,2,3,4);
    }
    public function __sleep(){
        return array('array');
    }
    public function __wakeup(){
        echo "Wakeup method happend! ---";
    }
}
   $obj = new demoSleepWakeup();
   $serializedStr = serialize($obj);
   var_dump($obj);
   echo "<br />";
   var_dump($serializedStr);
   echo "<br />";
   var_dump(unserialize($serializedStr));
   

   echo "<br /><br />";
// Clone method
echo "13. Clone method";
echo "<br />";
class NewMethod
{
    static $instances = 0;
    public $instance;

    public function __construct() {
        $this->instance = ++self::$instances;
    }

    public function __clone() {
        $this->instance = ++self::$instances;
    }
}

class MyCloneable
{
    public $object1;
    public $object2;

    function __clone()
    {
        $this->object1 = clone $this->object1;
    }
}

$obj = new MyCloneable();

$obj->object1 = new NewMethod();
$obj->object2 = new NewMethod();

$obj2 = clone $obj;

print("Original Object:");
print_r($obj);
echo "<br />";
print("Cloned Object:");
print_r($obj2);

class Student2
{
    public $name;
    public $id;
    public static function __set_state($array)
    {
        $obj = new Student2;
        $obj->name = $array['name'];
        $obj->id = $array['id'];
        return $obj;
    }
}
echo "<br /><br />";
echo "14. SetState method<br>";
$student2 = new Student2(1, "Jacob");
$student2->name = "Mathew";
$student2->id = 1;

eval('$b = ' . var_export($student2, true) . ';');
var_dump($b);
