<?php
class Database
{
    private $host = "localhost";
    private $dbname = "bookstoredb";
    private $username = "root";
    private $password = "root";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Database error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

// Usage example
// $database = new Database();
// $db = $database->getConnection();
// if ($db) {
//     echo "Connected to the database successfully!";
    // function getAllBooks($db) {
    //     $query = "SELECT * FROM Book ORDER BY ReleaseDate DESC";
    //     $stmt = $db->prepare($query);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
    // $books = getAllBooks($db);
    // if ($books) {
    //     echo "<h2>Danh Sách Sách</h2>";
    //     foreach ($books as $book) {
    //         echo "Book ID: " . htmlspecialchars($book['BookID']) . "<br>";
    //         echo "Book Name: " . htmlspecialchars($book['Name']) . "<br>";
    //         echo "Description: " . htmlspecialchars($book['Description']) . "<br>";
    //         echo "Price: " . htmlspecialchars($book['Price']) . "<br>";
    //         echo "Stock: " . htmlspecialchars($book['Stock']) . "<br>";
    //         echo "ImageURL: " . htmlspecialchars($book['ImageURL']) . "<br>";
    //         echo "CategoryID: " . htmlspecialchars($book['CategoryID']) . "<br>";
    //         echo "Length: " . htmlspecialchars($book['Length']) . "<br>";
    //         echo "Weight: " . htmlspecialchars($book['Weight']) . "<br>";
    //         echo "Demensions: " . htmlspecialchars($book['Demensions']) . "<br>";
    //         echo "Language: " . htmlspecialchars($book['Language']) . "<br>";
    //     }
    // } else {
    //     echo "No books found.";
    // }
// } else {
//     echo "Failed to connect to the database.";
// }
