<?php
class ShoesManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function getShoes()
    {

        //get detail
        $pathInfoArr1 = explode("/", $_SERVER["PATH_INFO"]);
        // dd((empty($_GET['page'])));
        if ($pathInfoArr1[2] = 'shoes' && empty($_GET['page']) && is_numeric($pathInfoArr1[3])) { //is fixing is_numeric, show incorrect data
            $module = $pathInfoArr1[3];
            // var_dump($pathInfoArr1[3]);
            // var_dump($module);
            $sqlId = "SELECT shoes.id, shoes.name , shoes.price, category.name AS category FROM shoes inner JOIN category  ON shoes.categories  = category.id where shoes.id ='$module'";
            $resultId = $this->pdo->query($sqlId);
            $searchIdd = $resultId->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($searchIdd[0]);
        }

          //FILTER   http://localhost:8000/api.php?action=filter&field=price&value=25&comparison=more
       else if (isset($_GET['min_number']) && isset($_GET['max_number']) && isset($_GET['page'])) {
        // Get the min and max numbers from the parameters
        $minNumber = $_GET['min_number'];
        $maxNumber = $_GET['max_number'];
        $limit = 10; // Number of records per page
        // Get page numfber from the request, default to page 1
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        // dd($page);
        $start = ($page - 1) * $limit;
        // dd($minNumber);
        // SQL query to filter data with less than and greater than conditions
        // $sql = "SELECT * FROM shoes WHERE price < $maxNumber AND price> $minNumber";
        $sql = "SELECT shoes.id, shoes.name ,shoes.price , category.name AS categories FROM shoes LEFT JOIN category   ON shoes.categories=category.id   WHERE price < $maxNumber AND price> $minNumber LIMIT $start, $limit";


        // Execute query
        $result = $this->pdo->query($sql);
        // $result->bindParam(':start', $start, PDO::PARAM_INT);
        // $result->bindParam(':limit', $limit, PDO::PARAM_INT);
        $result->execute();
        $users = $result->fetchAll(PDO::FETCH_ASSOC);

        $total_stmt = $this->pdo->query("SELECT COUNT(*)  from (SELECT shoes.id, shoes.name ,shoes.price , category.name AS categories FROM shoes LEFT JOIN category   ON shoes.categories=category.id   WHERE price < $maxNumber AND price> $minNumber) tmp");
        $total_rows = $total_stmt->fetchColumn();
        $total_pages = ceil($total_rows / $limit);
        // dd($total_stmt);
        // Construct the API response
        $response = [
            'page' => $page,
            'total_pages' => $total_pages,
            'total_records' => $total_rows,
            'users' => $users
        ];

        // Set headers to JSON

        // Output JSON response
        echo json_encode($response);
        // // Check if there are results
        // if ($result) {
        //     $response = $result->fetchAll(PDO::FETCH_ASSOC);
        //     // Return data as JSON
        //     echo json_encode($response);
        // }
    } 

        //PAGINATION
        else if ($_GET['page'] != "" && !isset($_GET['min_number'])) {
            $limit = 10; // Number of records per page
            // Get page numfber from the request, default to page 1
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($page - 1) * $limit;

            // Query to fetch records for the current page
            $stmt = $this->pdo->prepare("SELECT shoes.id, shoes.name ,shoes.price , category.name AS categories FROM shoes LEFT JOIN category   ON shoes.categories=category.id LIMIT :start, :limit");
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // var_dump($users);

            // Total number of records (for pagination)
            $total_stmt = $this->pdo->query("SELECT COUNT(*)  from (SELECT shoes.id, shoes.name ,shoes.price , category.name AS categories FROM shoes INNER JOIN category   ON shoes.categories=category.id) tmp");
            $total_rows = $total_stmt->fetchColumn();
            $total_pages = ceil($total_rows / $limit);

            // Construct the API response
            $response = [
                'page' => $page,
                'total_pages' => $total_pages,
                'total_records' => $total_rows,
                'users' => $users
            ];

            // Set headers to JSON

            // Output JSON response
            echo json_encode($response);
        }

        //search name shoe
        else if (isset($_GET['name'])) {
            $searchName = $_GET["name"];
            // dd($searchName);
            $sqlName = "SELECT shoes.id, shoes.name, shoes.price , category.name AS category FROM shoes LEFT JOIN category  ON shoes.categories = category.id WHERE shoes.name LIKE '%$searchName%'";
            $resultName = $this->pdo->query($sqlName);
            // dd($resultName);
            $resultNames = $resultName->fetchAll(PDO::FETCH_ASSOC);    
            if ($resultNames) {
                echo json_encode($resultNames);
            }
            echo json_encode(array("message"=>"invalid"));

            }

            
        }

        
    
    public function postShoe()
    {
        try {
            $pathInfoArr1 = explode("/", $_SERVER["PATH_INFO"]);

            $module = $pathInfoArr1[2];
            if ($module = "shoes") {

                $data = json_decode(file_get_contents("php://input"), true);
                $name = $data['name'];
                $price = $data['price'];
                $category_name = $data['category'];
                // dd($categories);

                //get category.id
                $sqlId = "SELECT category.id FROM category WHERE category.name = '$category_name'";
                $queryCategoryId = $this->pdo->query($sqlId);
                // dd($queryCategoryId);
                $category_id = $queryCategoryId->fetchAll(PDO::FETCH_ASSOC);
                // dd($category_id[0]);

                $category_id = $category_id[0]["id"];

                $stmt = $this->pdo->prepare("INSERT INTO shoes  (name, price,categories) VALUES ('$name', $price, $category_id)");
                // dd($stmt);


                // Bind parameters
                // $stmt->bindParam(':name', $name);
                // $stmt->bindParam(':price', $price);
                // $stmt->bindParam(':category_name', $categories);
                // $stmt->bindParam(':category_id', $category_id);

                // Execute the statement
                $stmt->execute();
                // http_response_code(201); // Created
                // echo json_encode(array("message" => "created successfully."));
                if ($stmt->rowCount() == 0) {
                    // Handle the case where 0 rows were affected
                    $message = "No matching records found for creation";
                } else {
                    // Handle the successful delete operation
                    $message = "created successfully";
                }
                http_response_code(200); // OK
                echo json_encode(array("message" => $message));
            }
        } catch (Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(array("message" => "Database error: " . $e->getMessage()));
        }
    }
    public function delShoe()
    {
        $pathInfoArr1 = explode("/", $_SERVER["PATH_INFO"]);
        if ($pathInfoArr1[2] = 'cars') {
            $module = $pathInfoArr1[3];
            // dd($module);
            $stmt = $this->pdo->prepare("DELETE FROM shoes WHERE id = :id");

            // Bind parameter
            $stmt->bindParam(':id', $module);

            // Execute the statement
            try {
                $stmt->execute();
                // Check if the delete operation affected any rows
                if ($stmt->rowCount() == 0) {
                    // Handle the case where 0 rows were affected
                    $message = "No matching records found for deletion";
                } else {
                    // Handle the successful delete operation
                    $message = "Records deleted successfully";
                }
                http_response_code(200); // OK
                echo json_encode(array("message" => $message));
            } catch (PDOException $e) {
                http_response_code(500); // Internal Server Error
                echo json_encode(array("message" => "Failed to delete record: " . $e->getMessage()));
            }
        }
    }
    
    public function editShoe()
    {
        try {
            //    dd("Patch cars");
            $pathInfoArr1 = explode("/", $_SERVER["PATH_INFO"]);
            $id = $pathInfoArr1[3];
            // dd($id);
            // dd($pathInfoArr1[3]);
            $module = $pathInfoArr1[2];
            if ($module = "shoes") {

                $data = json_decode(file_get_contents("php://input"), true);
                $name = $data['name'];
                $price = $data['price'];
                $category_name = $data['category'];

                // get category.id
                $sqlId = "SELECT category.id FROM category WHERE category.name = '$category_name'";
                $queryCategoryId = $this->pdo->query($sqlId);
                // dd($queryCategoryId);
                $category_id = $queryCategoryId->fetchAll(PDO::FETCH_ASSOC);
                // dd($category_id[0]);
                $category_id = $category_id[0]["id"];

                // Prepare the SQL statement
                $stmt = $this->pdo->prepare("UPDATE shoes SET name = '$name' , price = $price , categories = $category_id WHERE  id= $id");
                // Bind parameters
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':category_id', $category_id);
                $stmt->bindParam(':category_name', $category_name);

                // dd($stmt);
                // dd($category_id);
                // Execute the statement
                $stmt->execute();
                http_response_code(201); // Created
                echo json_encode(array("message" => "edit successfully."));
            }
        } catch (Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(array("message" => "Database error: " . $e->getMessage()));
        }




    }
}
