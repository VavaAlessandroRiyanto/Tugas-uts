<?php

include "koneksi.php";

// Menentukan metode request
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

switch($method) {
    case 'GET':
        $sql = "SELECT * FROM wisata";
        $stmt = $pdo->query($sql);
        $wisata = $stmt->fetchAll();
        echo json_encode($wisata);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->id_destinasi) && isset($data->Nama_destinasi) && isset($data->Alamat_wisata)&& isset($data->Jenis_destinasi)) {
            $sql = "INSERT INTO wisata (id_destinasi, Nama_destinasi, Jenis_destinasi, Alamat_destinasi) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->id_destinasi, $data->Nama_destinasi, $data->Alamat_wisata, $data->Jenis_destinasi]);
            echo json_encode(['message' => 'Wisata berhasil ditambahkan']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->id_destinasi) && isset($data->Nama_destinasi) && isset($data->Alamat_wisata) && isset($data->Jenis_destinasi)) {
            $sql = "UPDATE wisata SET Nama_destinasi=?, Alamat_wisata=?, Jenis_destinasi=? WHERE id_destinasi=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->Nama_destinasi, $data->Alamat_wisata, $data->Jenis_destinasi, $data->id_destinasi]);
            echo json_encode(['message' => 'Wisata']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->id_destinasi)) {
            $sql = "DELETE FROM wisata WHERE id_destinasi=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->id]);
            echo json_encode(['message' => 'Wisata berhasil dihapus']);
        } else {
            echo json_encode(['message' => 'Id_Destinasi tidak ditemukan']);
        }
        break;

    default:
        echo json_encode(['message' => 'Metode tidak dikenali']);
        break;
}

?>
