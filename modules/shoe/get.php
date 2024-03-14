<?php
    class getShoesManager
    {
        private $pdo;
    
        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }
        public function handleGet()
        {

            $pathInfoArr1 = explode("/", $_SERVER["PATH_INFO"]);
            if ($pathInfoArr1[2] = 'shoes') {
                $module = $pathInfoArr1[3];
                // var_dump($pathInfoArr1[3]);
                // var_dump($module);
                $sqlId = "SELECT * FROM shoes WHERE id = '$module'";
                $resultId = $this->pdo->query($sqlId);
                $searchIdd = $resultId->fetchAll(PDO::FETCH_ASSOC);
                if (is_null($searchIdd[0])) {
                    echo json_encode(array("message"=>"null"));
                    exit;
                }
                echo json_encode($searchIdd[0]);
            }
        }   
    }
   
    // $shoesManager = new ShoesManager($pdo);
    // dd("anh chaop em");  
    
