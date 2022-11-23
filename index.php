<?php

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "snotes";

    $conn = new mysqli($servername, $username, $password, $database) or die("Connection Error");

    header('Content-Type: application/json');

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $myData = array();
        if ($result = mysqli_query($conn, "SELECT * FROM notes ORDER BY nonote DESC")) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $myData[] = $row;
            }
            echo json_encode($myData);
        }
    } else if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $note = $_POST['note'];
        $query = "INSERT INTO notes (note) VALUES (?)";
        $stmt = $conn->prepare($query);
        $res = $stmt->execute([$note]);
        if ($res){
            $data = ['note'=>$note];
            echo json_encode($data);
        } else {
            echo json_encode(['error'=>$stmt->errorCode()]);
        }
    } else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        $nomor = $_GET['nonote'];
        $query = "DELETE FROM notes WHERE nonote = (?)";
        $stmt = $conn->prepare($query);
        $res = $stmt->execute([$nomor]);
        if ($res) {
            $data = ['nonote'=>$nomor];
            echo json_encode($data);
        } else {
            echo json_encode(['error'=>$stmt->errorCode()]);
        }
    }

?>