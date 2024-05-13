<?php
class ShoesManager {
    public function getShoes() {
        return "List of shoes";
    }
}

$shoesManager = new ShoesManager();
$methodName = "getShoes";

// Check if the method exists in the object
if (method_exists($shoesManager, $methodName)) {
    // Call the method using call_user_func()
    $result = call_user_func(array($shoesManager, $methodName));
    echo $result; // Output will be "List of shoes"
} else {
    echo "Method does not exist.";
}
?>
